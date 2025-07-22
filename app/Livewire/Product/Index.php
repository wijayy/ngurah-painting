<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $product;

    public function mount()
    {
        $this->product = Product::latest()->get();
    }

    public function delete(Product $product)
    {
        $product->delete();

        $this->product = Product::latest()->get();
        session()->flash('success', 'Produk Berhasil Dihapus');
        $this->dispatch('close-delete-modal-' . $product->id);
    }

    public function render()
    {
        return view('livewire.product.index', ['title' => "Produk"]);
    }
}
