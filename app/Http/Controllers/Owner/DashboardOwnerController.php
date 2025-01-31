<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiQris;
use App\Models\TransaksiTunai;
use Illuminate\Support\Carbon;

class DashboardOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $yesterday = Carbon::now()->subDay()->format('Y-m-d');

        $todayQris = TransaksiQris::whereDate('timestamp', $today)->get();
        $todayTunai = TransaksiTunai::whereDate('timestamp', $today)->get();
        
        $yesterdayQris = TransaksiQris::whereDate('timestamp', $yesterday)->get();
        $yesterdayTunai = TransaksiTunai::whereDate('timestamp', $yesterday)->get();

        $todayModal = $todayQris->sum('total_cost_price') + $todayTunai->sum('total_cost_price');
        $todayPendapatan = $todayQris->sum('subtotal') + $todayTunai->sum('subtotal');
        $todayKeuntungan = $todayPendapatan - $todayModal;

        $yesterdayModal = $yesterdayQris->sum('total_cost_price') + $yesterdayTunai->sum('total_cost_price');
        $yesterdayPendapatan = $yesterdayQris->sum('subtotal') + $yesterdayTunai->sum('subtotal');
        $yesterdayKeuntungan = $yesterdayPendapatan - $yesterdayModal;

        $modalPercentage = $yesterdayModal != 0 ? (($todayModal - $yesterdayModal) / $yesterdayModal) * 100 : 0;
        $pendapatanPercentage = $yesterdayPendapatan != 0 ? (($todayPendapatan - $yesterdayPendapatan) / $yesterdayPendapatan) * 100 : 0;
        $keuntunganPercentage = $yesterdayKeuntungan != 0 ? (($todayKeuntungan - $yesterdayKeuntungan) / $yesterdayKeuntungan) * 100 : 0;

        $modalDiff = $todayModal - $yesterdayModal;
        $pendapatanDiff = $todayPendapatan - $yesterdayPendapatan;
        $keuntunganDiff = $todayKeuntungan - $yesterdayKeuntungan;

        $monthlyData = $this->getMonthlyData();

        return view('owner.dashboard', compact(
            'todayModal', 'todayPendapatan', 'todayKeuntungan',
            'modalPercentage', 'pendapatanPercentage', 'keuntunganPercentage',
            'modalDiff', 'pendapatanDiff', 'keuntunganDiff', 'monthlyData'
        ));
    }

    public function getDataByDateRange(Request $request)
    {
        $startDate = null;
        $endDate = null;

        if ($request->has('preset')) {
            $dates = $this->getPresetDates($request->preset);
            $startDate = Carbon::parse($dates['start'])->startOfDay();
            $endDate = Carbon::parse($dates['end'])->endOfDay();
        } else {
            $startDate = Carbon::parse($request->input('start'))->startOfDay();
            $endDate = Carbon::parse($request->input('end'))->endOfDay();
        }

        $rangeQris = TransaksiQris::whereBetween('timestamp', [$startDate, $endDate])->get();
        $rangeTunai = TransaksiTunai::whereBetween('timestamp', [$startDate, $endDate])->get();

        $rangeModal = $rangeQris->sum('total_cost_price') + $rangeTunai->sum('total_cost_price');
        $rangePendapatan = $rangeQris->sum('subtotal') + $rangeTunai->sum('subtotal');
        $rangeKeuntungan = $rangePendapatan - $rangeModal;

        // Get monthly data with the new comparison logic
        $monthlyData = $this->getMonthlyData($startDate, $endDate, $rangeModal, $rangePendapatan, $rangeKeuntungan);

        return response()->json([
            'todayModal' => $rangeModal,
            'todayPendapatan' => $rangePendapatan,
            'todayKeuntungan' => $rangeKeuntungan,
            'monthlyData' => $monthlyData
        ]);
    }

    /**
     * Get monthly data for charts
     */
    private function getMonthlyData($startDate = null, $endDate = null, $rangeModal = null, $rangePendapatan = null, $rangeKeuntungan = null)
    {
        $monthlyData = [];

        // If no dates are provided, default to the current month
        if (!$startDate || !$endDate) {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        } else {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
        }

        // Jika bulan sama, ambil data harian
        if ($start->format('Y-m') == $end->format('Y-m')) {
            $currentDate = $start->copy();
            while ($currentDate <= $end) {
                $dayQris = TransaksiQris::whereDate('timestamp', $currentDate->format('Y-m-d'))->get();
                $dayTunai = TransaksiTunai::whereDate('timestamp', $currentDate->format('Y-m-d'))->get();

                $modal = $dayQris->sum('total_cost_price') + $dayTunai->sum('total_cost_price');
                $pendapatan = $dayQris->sum('subtotal') + $dayTunai->sum('subtotal');
                $keuntungan = $pendapatan - $modal;

                $monthlyData[$currentDate->format('d M')] = [
                    'modal' => $modal,
                    'pendapatan' => $pendapatan,
                    'keuntungan' => $keuntungan
                ];

                $currentDate->addDay();
            }
        } else {
            // Jika rentang bulan berbeda, ambil data per bulan
            $currentDate = $start->copy()->startOfMonth();
            while ($currentDate <= $end->copy()->endOfMonth()) {
                $monthQris = TransaksiQris::whereYear('timestamp', $currentDate->year)
                    ->whereMonth('timestamp', $currentDate->month)
                    ->get();

                $monthTunai = TransaksiTunai::whereYear('timestamp', $currentDate->year)
                    ->whereMonth('timestamp', $currentDate->month)
                    ->get();

                $modal = $monthQris->sum('total_cost_price') + $monthTunai->sum('total_cost_price');
                $pendapatan = $monthQris->sum('subtotal') + $monthTunai->sum('subtotal');
                $keuntungan = $pendapatan - $modal;

                $monthlyData[$currentDate->format('M Y')] = [
                    'modal' => $modal,
                    'pendapatan' => $pendapatan,
                    'keuntungan' => $keuntungan
                ];

                $currentDate->addMonth();
            }
        }

        // Jika rentang tanggal lebih dari satu hari, tambahkan total dari rentang yang dihitung sebelumnya
        if ($startDate != $endDate) {
            $monthlyData['Total'] = [
                'modal' => $rangeModal,
                'pendapatan' => $rangePendapatan,
                'keuntungan' => $rangeKeuntungan
            ];
        }

        return $monthlyData;
    }

    private function getPresetDates($preset)
    {
        $now = Carbon::now();
        
        switch ($preset) {
            case 'today':
                return [
                    'start' => $now->format('Y-m-d'),
                    'end' => $now->format('Y-m-d')
                ];
            case 'yesterday':
                return [
                    'start' => $now->copy()->subDay()->format('Y-m-d'),
                    'end' => $now->copy()->subDay()->format('Y-m-d')
                ];
            case 'last7days':
                return [
                    'start' => $now->copy()->subDays(6)->format('Y-m-d'),
                    'end' => $now->format('Y-m-d')
                ];
            case 'last30days':
                return [
                    'start' => $now->copy()->subDays(29)->format('Y-m-d'),
                    'end' => $now->format('Y-m-d')
                ];
            case 'thisMonth':
                return [
                    'start' => $now->copy()->startOfMonth()->format('Y-m-d'),
                    'end' => $now->copy()->endOfMonth()->format('Y-m-d')
                ];
            case 'lastMonth':
                return [
                    'start' => $now->copy()->subMonth()->startOfMonth()->format('Y-m-d'),
                    'end' => $now->copy()->subMonth()->endOfMonth()->format('Y-m-d')
                ];
            default:
                return [
                    'start' => $now->format('Y-m-d'),
                    'end' => $now->format('Y-m-d')
                ];
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
