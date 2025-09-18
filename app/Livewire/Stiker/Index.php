<?php

namespace App\Livewire\Stiker;

use Livewire\Component;

class Index extends Component
{
    public $title = "Data Kunjungan", $kunjungan;

    public function mount()
    {
        $this->kunjungan = \App\Models\Attendance::latest()->get();
    }

    public function render()
    {
        return view('livewire.stiker.index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
