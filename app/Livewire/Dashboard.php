<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Driver;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $earnings, $earningsDiff, $transaction, $transactionDiff, $sold, $soldDiff, $attendance,
    $attendanceDiff, $now, $attendances, $transactions, $topDrivers, $topCommission,
    $topYear, $topMonthYear, $labels = [], $totals = [];

    public function mount()
    {
        $this->now = Carbon::today();
        $lastmonth = Carbon::today()->subMonthNoOverflow();

        // dd($lastmonth, $this->now);
        $this->earnings = Transaction::whereMonth('created_at', $this->now->month)->whereYear('created_at', $this->now->year)->sum('total_harga');
        $lastEarnings = Transaction::whereMonth('created_at', $lastmonth->month)->whereYear('created_at', $lastmonth->year)->sum('total_harga');
        $this->earningsDiff = 100;
        if ($lastEarnings > 0) {
            $this->earningsDiff = (($this->earnings - $lastEarnings) / $lastEarnings) * 100;
        }

        $this->transaction = Transaction::whereMonth('created_at', $this->now->month)->whereYear('created_at', $this->now->year)->count();
        $lasttransaction = Transaction::whereMonth('created_at', $lastmonth->month)->whereYear('created_at', $lastmonth->year)->count();
        $this->transactionDiff = 100;
        if ($lasttransaction > 0) {
            $this->transactionDiff = (($this->transaction - $lasttransaction) / $lasttransaction) * 100;
        }

        $this->sold = TransactionDetail::whereMonth('created_at', $this->now->month)->whereYear('created_at', $this->now->year)->sum('jumlah');
        $sold = TransactionDetail::whereMonth('created_at', $lastmonth->month)->whereYear('created_at', $lastmonth->year)->sum('jumlah');
        $this->soldDiff = 100;
        if ($sold > 0) {
            $this->soldDiff = (($this->sold - $sold) / $sold) * 100;
        }

        $this->attendance = Attendance::whereMonth('created_at', $this->now->month)->whereYear('created_at', $this->now->year)->get()->count();
        $lastattendance = Attendance::whereMonth('created_at', $lastmonth->month)->whereYear('created_at', $lastmonth->year)->get()->count();
        $this->attendanceDiff = 100;
        if ($lastattendance > 0) {
            $this->attendanceDiff = (($this->attendance - $lastattendance) / $lastattendance) * 100;
        }

        $this->attendances = Attendance::whereDate('created_at', date('Y-m-d'))->take(5)->get();
        $this->transactions = Transaction::latest()->take(4)->get();

        $this->topDrivers = Driver::withSum('komisi', 'komisi') // 'jumlah' = nama kolom komisi
            ->orderByDesc('komisi_sum_komisi')
            ->take(5)
            ->get();

        $this->topCommission = $this->topDrivers->first()->komisi_sum_komisi;

        $this->topYear = Transaction::select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total_harga) as total'))
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderByDesc('total')
            ->first();

        $this->topMonthYear = Transaction::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_harga) as total')
        )
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderByDesc('total')
            ->first();

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
        // dd($this->topDrivers);
    }

    public function render()
    {
        return view('livewire.dashboard')->layout('components.layouts.app', ['title'=> 'Dashboard']);
    }
}
