<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $product;

    #[Url(except: '')]
    public $search;

    public function mount()
    {
        $this->updatedSearch();
    }

    public function updatedSearch()
    {
        $this->product = Product::latest()->filters(['search' => $this->search])->get();
        $this->resetPage();
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
