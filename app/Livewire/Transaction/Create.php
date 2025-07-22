<?php

namespace App\Livewire\Transaction;

use App\Models\Attendance;
use App\Models\Komisi;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $region_id = 1, $allRegion, $allProduct, $name, $email, $phone, $payment = 'cash', $sticker, $note, $commission = 0, $driver, $attendance, $total = 0;

    public $products = [
        ['name' => 1, 'qty' => 1, 'max' => 10],
    ];

    public function addProduct()
    {
        $this->products[] = ['name' => 1, 'qty' => 1, 'max' => 10];
        $this->updatePrice();
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products); // reindex
    }

    public function changeSticker()
    {
        try {
            $this->attendance = Attendance::whereDate('created_at', date('Y-m-d'))->where('nomor_stiker', $this->sticker)->first();
            // dd($attendance);
            $this->driver = $this->attendance->driver;
        } catch (\Throwable $th) {
            $this->driver = null;
        }

        if ($this->driver) {
            $this->commission = $this->total * Setting::where('key', 'rasio_komisi')->value('value') / 100;
        }
    }

    public function updatePrice()
    {
        // dd($this->products);
        $this->total = 0;
        foreach ($this->products as $key => $item) {
            $product = Product::find($item['name']);
            // dd($product, $item['max']);
            if (!$item['qty']) {
                $item['qty'] = 0;
            }
            $this->total += $product->harga * $item['qty'];
        }

        if ($this->driver) {
            $this->commission = $this->total * Setting::where('key', 'rasio_komisi')->value('value') / 100;
        }

        $this->render();
    }

    public function mount()
    {
        $this->allProduct = Product::get();

        $this->updatePrice();
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
                'tanggal' => now(),
            ]);

            // dd($transaction);
            foreach ($this->products as $key => $item) {
                $product = Product::findOrFail($item['name']);
                TransactionDetail::create([
                    'transaksi_id' => $transaction->id_transaksi,
                    'produk_id' => $item['name'],
                    'jumlah' => $item['qty'],
                    'harga' => $product->harga,
                ]);
            }

            if ($this->attendance ?? false) {
                Komisi::create(['transaksi_id' => $transaction->id_transaksi, 'driver_id' => $this->driver->id_driver, 'komisi' => $this->commission]);
            }

            DB::commit();
            $total = $this->total / 1000;
            $session = ($this->driver) ? "Boom! {$this->driver->user->name} delivered IDR {$total}K to your cashbox" : "Cha-ching! IDR {$total}K just landed in your cashbox";
            return redirect(route('transaction.withdrawal'))->with('success', $session);
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
        return view('livewire.transaction.create');
    }
}
