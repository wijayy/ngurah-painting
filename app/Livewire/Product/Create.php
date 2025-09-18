<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public $nama = '';

    #[Validate('required|numeric|min:0')]
    public $harga = 0, $persentase_komisi = 50;

    #[Validate('required')]
    public $status = 1;

    public $product, $title;



    public function mount($slug = null)
    {
        if ($slug) {
            $product = Product::where('slug', $slug)->firstOrFail();
            $this->product = $product->id_produk;
            $this->nama = $product->nama;
            $this->harga = $product->harga;
            $this->persentase_komisi = $product->persentase_komisi;
            $this->status = $product->status;
            $this->title = "Edit Produk $this->nama";
        } else {
            $this->title = "Add New Product";
        }
    }

    public function save()
    {
        $validated = $this->validate();

        Product::updateOrCreate(
            ['id_produk' => $this->product],
            $validated
        );
        session()->flash('success', $this->product ? 'Produk Berhasil Diubah' : 'Produk Berhasil Ditambahkan');
        return redirect()->route('product.index');
    }

    public function render()
    {
        return view('livewire.product.create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
