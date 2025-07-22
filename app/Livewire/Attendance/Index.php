<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;

class Index extends Component
{
    public $attendances, $date;



    public function mount()
    {
        $this->date = date("Y-m-d");
        $this->attendances = $this->getAttendances();
    }

    public function changeDate()
    {
        $this->attendances = $this->getAttendances();
    }

    public function getAttendances() {
        return Attendance::whereDate('created_at', $this->date)->get();
    }
    public function render()
    {
        return view('livewire.attendance.index')->layout('components.layouts.app', ['title'=> 'Kunjungan Driver']);
    }
}
