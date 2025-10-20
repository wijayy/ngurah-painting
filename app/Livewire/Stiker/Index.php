<?php

namespace App\Livewire\Stiker;

use App\Models\Attendance;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    public $title = "Data Kunjungan";

    #[Url(except:'')]
    public $date = '';

    public function mount()
    {
        if (!$this->date) {
            $this->date = now()->format('Y-m-d');
        }
    }

    public function render()
    {
        $kunjungan = Attendance::query()
            ->when($this->date, fn ($query) => $query->whereDate('created_at', $this->date))
            ->latest()->get();

        return view('livewire.stiker.index', compact('kunjungan'))->layout('components.layouts.app', ['title' => $this->title]);
    }
}
