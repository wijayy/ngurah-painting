<?php

namespace App\Livewire\Pembayaran;

use App\Models\Pembayaran;
use Livewire\Component;

class Index extends Component
{
    public $title = "Pembayaran", $pembayarans;

    public function mount()
    {
        $this->pembayarans = Pembayaran::latest()->get();
    }

    public function render()
    {
        return view('livewire.pembayaran.index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
