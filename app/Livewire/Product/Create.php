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
            'stock' => 'required|integer|min:0',
        ];

        // Tambahkan aturan gambar
        if ($this->product) {
            // Edit
            $rules['image'] = 'nullable|image|max:2048';
        } else {
            // Create
            $rules['image'] = 'required|image|max:2048';
        }

        return $rules;
    }

    public function mount($slug = null)
    {
        if ($slug) {
            $product = Product::where('slug', $slug)->firstOrFail();
            $this->product = $product->id;
            $this->name = $product->name;
            $this->price = $product->price;
            $this->stock = $product->stock;
            $this->existingImage = $product->image;
            $this->title = "Edit Product $this->name";
        } else {
            $this->title = "Add New Product";
        }
    }

    public function save()
    {
        $validated = $this->validate();

        $imagePath = $this->existingImage;

        if ($this->image) {
            $imagePath = $this->image->store('product');

            if ($this->existingImage) {
                Storage::delete($this->existingImage);
            }
        }
        Product::updateOrCreate(
            ['id' => $this->product],
            [
                'name' => $this->name,
                'price' => $this->price,
                'stock' => $this->stock,
                'image' => $imagePath,
            ]
        );
        session()->flash('success', $this->product ? 'All set! Your product just had a mini makeover.' : 'Ta-da! Your product is born and ready to shine.');
        return redirect()->route('product.index');
    }

    public function render()
    {
        return view('livewire.product.create');
    }
}
