<?php

namespace App\Livewire\Transaction;

use App\Models\Attendance;
use App\Models\Komisi;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

use function PHPUnit\Framework\isNumeric;

class Create extends Component
{
    #[Validate('required|string')]
    public $nomor_transaksi = '', $status = 'selesai', $tanggal = '';

    #[Validate('nullable|numeric')]
    public $stiker = '';
    public $name = '';
    public $products = [
        ['name' => 1, 'jumlah' => 1, 'max' => 10],
    ];

    public $attendance, $driver, $total = 0, $commission = 0, $payment = 'cash', $title = 'Tambah Transaksi', $allProduct;

    public function rules()
    {
        return [
            'products' => 'required|array',
            'products.*.produk_id' => 'required|numeric',
            'products.*.jumlah' => 'required|numeric|min:1',
            'products.*.harga' => 'required|integer',
            'products.*.subtotal' => 'required|integer',
        ];
    }

    public function addProdukItem()
    {
        $this->products[] = ['produk_id' => null, 'harga' => null, 'jumlah' => 1, 'subtotal' => 0];
    }
    public function removeProdukItem($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }

    public function changeStiker()
    {
        try {
            $this->attendance = Attendance::whereDate('created_at', date('Y-m-d'))->where('nomor_stiker', $this->stiker)->first();
            // dd($this->attendance);
            $this->driver = $this->attendance->driver;
            // dd($this->driver);

        } catch (\Throwable $th) {
            $this->driver = null;
            // return $th;
        }

        if ($this->driver) {
            $this->commission = $this->total * Setting::where('key', 'rasio_komisi')->value('value') / 100;
        }
    }

    public function mount()
    {
        $this->allProduct = Product::where('status', true)->get();
        $this->nomor_transaksi = Transaction::transactionNumberGenerator();
        $this->tanggal = date('Y-m-d\TH:i');
        // $this->updatePrice();
        $this->products = [
            ['produk_id' => null, 'harga' => null, 'jumlah' => 1, 'subtotal' => 0],
        ];

    }

    public function produkChanged($index)
    {
        $produk_id = $this->products[$index]['produk_id'];
        $produk = \App\Models\Product::find($produk_id);
        $this->products[$index]['harga'] = $produk ? $produk->harga : null;

        $this->countTotal();
    }

    public function countTotal()
    {
        $total = 0;
        foreach ($this->products as $key => $item) {
            if (is_numeric($item['harga']) && is_numeric($item['jumlah'])) {
                $total += $item['harga'] * $item['jumlah'];
                $this->products[$key]['subtotal'] = $item['harga'] ? $item['harga']* $this->products[$key]['jumlah'] : 0;

                // dd($item);

                Log::info($item['subtotal']);
            } else {
                $item['subtotal'] = 0;
                return;
            }
        }

        $this->total = $total;
        // dd($this->products);
    }

    public function save(Request $request)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::create([
                'nomor_transaksi' => Transaction::transactionNumberGenerator(),
                'metode_pembayaran' => $this->payment,
                'stiker_id' => $this->attendance?->id_stiker,
                'total_harga' => $this->total,
                'tanggal' => $this->tanggal,
            ]);

            // dd($transaction);
            foreach ($this->products as $key => $item) {
                $product = Product::findOrFail($item['produk_id']);
                TransactionDetail::create([
                    'transaksi_id' => $transaction->id_transaksi,
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                ]);
            }

            if ($this->driver) {
                $this->driver->user->aktifitas()->create([
                    'aktifitas' => "Customer berhasil melakukan transaksi dengan nomor transaksi $transaction->nomor_transaksi dan total harga Rp. " . number_format($this->total, 0, ',', '.')
                ]);

                Komisi::create([
                    'driver_id' => $this->driver->id_driver,
                    'nilai' => $this->commission,
                    'transaksi_id' => $transaction->id_transaksi,
                    'status' => 'pending',
                    'persen' => Setting::where('key', 'rasio_komisi')->value('value'),
                ]);
            }

            DB::commit();
            $session = 'data transaksi telah tersimpan.';
            return redirect(route('transaction.index'))->with('success', $session);
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                session()->flash('error', $th->getMessage());
            } else {
                // return back()->with('error', $th->getMessage());
            }
        }
    }
    public function render()
    {
        return view('livewire.transaction.create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
