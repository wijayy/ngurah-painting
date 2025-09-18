<?php

namespace App\Livewire\Driver;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{

    public $drivers, $title = "Driver";

    #[Url(except: '')]
    public $search;

    public function mount()
    {
        $this->updatedSearch();
    }

    public function updatedSearch()
    {
        $this->drivers = User::where('role', 'driver')->filters(['search' => $this->search])->get();
    }

    public function render()
    {
        return view('livewire.driver.index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
