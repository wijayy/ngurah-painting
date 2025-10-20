<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;

class Index extends Component
{
    public $kunjungan, $date, $title = "Data Kunjungan";

    public function mount()
    {
        $this->date = date("Y-m-d");
        $this->kunjungan = $this->getAttendances();
    }

    public function changeDate()
    {
        $this->kunjungan = $this->getAttendances();
    }

    public function getAttendances() {
        return Attendance::whereDate('created_at', $this->date)->get();
    }
    public function render()
    {
        return view('livewire.attendance.index')->layout('components.layouts.app', ['title'=> 'Kunjungan Driver']);
    }
}
