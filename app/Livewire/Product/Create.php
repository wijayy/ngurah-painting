<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads;

    public $product, $name, $price, $stock, $image, $title, $existingImage;
    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ];
        return $rules;
    }

    public function mount($slug = null)
    {
        if ($slug) {
            $product = Product::where('slug', $slug)->firstOrFail();
            $this->product = $product->id_produk;
            $this->name = $product->nama;
            $this->price = $product->harga;
            $this->title = "Edit Produk $this->name";
        } else {
            $this->title = "Add New Product";
        }
    }

    public function save()
    {
        $validated = $this->validate();

        Product::updateOrCreate(
            ['id_produk' => $this->product],
            [
                'nama' => $this->name,
                'harga' => $this->price,
            ]
        );
        session()->flash('success', $this->product ? 'Produk Berhasil Diubah' : 'Produk Berhasil Ditambahkan');
        return redirect()->route('product.index');
    }

    public function render()
    {
        return view('livewire.product.create', ['title' => "{$this->title}"]);
    }
}
