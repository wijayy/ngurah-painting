<?php

namespace App\Livewire\Komisi;

use Livewire\Component;

class Index extends Component
{
    public $title = 'Komisi', $komisi;

    public function mount()
    {
        $this->komisi = \App\Models\Komisi::get();
    }
    public function render()
    {
        return view('livewire.komisi.index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
