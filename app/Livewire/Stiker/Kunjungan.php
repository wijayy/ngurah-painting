<?php

namespace App\Livewire\Stiker;

use Livewire\Component;

class Kunjungan extends Component
{
    public $stiker = '', $driver, $attendance, $title = 'Scan Kunjungan', $token;

    // public $driver;
    public function updatedToken()
    {
        $this->token = $this->getLastTokenFromUrl($this->token);
        $this->driver = \App\Models\Driver::where('token', $this->token)->first();
    }

    function getLastTokenFromUrl($url)
    {
        $parts = explode('/', rtrim($url, '/'));
        return end($parts);
    }

    public function render()
    {
        return view('livewire.stiker.kunjungan')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
