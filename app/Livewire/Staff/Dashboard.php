<?php

namespace App\Livewire\Staff;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $title = "Dashboard";
    public $labels, $totals;

    public function mount()
    {
        $data = Transaction::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("SUM(total_harga) as total")
        )
            ->where('created_at', '>=', now()->subMonthsNoOverflow(12)->startOfMonth())
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('month')
            ->get();

        // Format untuk Chart.js


        // Isi data bulan-bulan lengkap meski tidak ada transaksi
        $months = collect(range(0, 11))->map(function ($i) {
            return now()->subMonths(11 - $i)->format('Y-m');
        });

        foreach ($months as $month) {
            $this->labels[] = Carbon::createFromFormat('Y-m', $month)->format('F Y');
            $record = $data->firstWhere('month', $month);
            $this->totals[] = $record ? $record->total : 0;
        }
    }

    public function render()
    {
        return view('livewire.staff.dashboard')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
