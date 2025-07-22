<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;

class Config extends Component
{

    public $ratio, $reward, $minimum, $max;
    public function mount()
    {

        if (!config('app.config')) {
            return redirect(route('dashboard'));
        }
        $this->ratio = Setting::where('key', 'rasio_komisi')->value('value');
        $this->reward = Setting::where('key', 'hadiah_kunjungan')->value('value');
        $this->minimum = Setting::where('key', 'minimum_penukaran_poin')->value('value');
        $this->max = Setting::where('key', 'max_nonaktif')->value('value');
    }

    public function save()
    {
        Setting::where('key', 'rasio_komisi')->update(['value' => $this->ratio]);
        Setting::where('key', 'hadiah_kunjungan')->update(['value' => $this->reward]);
        Setting::where('key', 'minimum_penukaran_poin')->update(['value' => $this->minimum]);
        Setting::where('key', 'max_nonaktif')->update(['value' => $this->max]);

        $this->dispatch('success');
    }
    public function render()
    {
        return view('livewire.config')->layout('components.layouts.app', ['title'=> "Konfigurasi"]);
    }
}
