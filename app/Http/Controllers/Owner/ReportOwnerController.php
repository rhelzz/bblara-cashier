<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiQris;
use App\Models\TransaksiTunai;
use App\Models\MenuBestSeller;
use Illuminate\Support\Facades\DB;

class ReportOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qrisCount = TransaksiQris::count();
        $tunaiCount = TransaksiTunai::count();

        // Analisis Karyawan Terbaik
        $qrisEmployees = TransaksiQris::select('name_user as employee', DB::raw('COUNT(*) as transaction_count'))
            ->groupBy('name_user')
            ->get();

        $tunaiEmployees = TransaksiTunai::select('name_user as employee', DB::raw('COUNT(*) as transaction_count'))
            ->groupBy('name_user')
            ->get();

        // Create an associative array instead of a Collection for employee stats
        $employeeStats = [];
        
        // Gabungkan data QRIS
        foreach ($qrisEmployees as $qris) {
            $employeeStats[$qris->employee] = [
                'name' => $qris->employee,
                'qris_count' => $qris->transaction_count,
                'tunai_count' => 0,
                'total_count' => $qris->transaction_count
            ];
        }

        // Gabungkan data Tunai
        foreach ($tunaiEmployees as $tunai) {
            if (isset($employeeStats[$tunai->employee])) {
                $employeeStats[$tunai->employee]['tunai_count'] = $tunai->transaction_count;
                $employeeStats[$tunai->employee]['total_count'] += $tunai->transaction_count;
            } else {
                $employeeStats[$tunai->employee] = [
                    'name' => $tunai->employee,
                    'qris_count' => 0,
                    'tunai_count' => $tunai->transaction_count,
                    'total_count' => $tunai->transaction_count
                ];
            }
        }

        // Convert to collection after all modifications are done
        $employeeCollection = collect($employeeStats);
        
        // Sort by total count
        $employeeCollection = $employeeCollection->sortByDesc('total_count');

        // Calculate percentages
        $totalTransactions = $qrisCount + $tunaiCount;
        $employeeCollection = $employeeCollection->map(function ($stats) use ($totalTransactions) {
            $stats['percentage'] = round(($stats['total_count'] / $totalTransactions) * 100, 1);
            return $stats;
        });

        // Get top 5 employees
        $topEmployees = $employeeCollection->take(5);

        // Get hourly transaction data for QRIS
        $qrisHourlyData = TransaksiQris::select(
            DB::raw('HOUR(timestamp) as hour'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy(DB::raw('HOUR(timestamp)'))
        ->orderBy('hour')
        ->pluck('count', 'hour')
        ->toArray();

        // Get hourly transaction data for Cash
        $tunaiHourlyData = TransaksiTunai::select(
            DB::raw('HOUR(timestamp) as hour'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy(DB::raw('HOUR(timestamp)'))
        ->orderBy('hour')
        ->pluck('count', 'hour')
        ->toArray();

        // Combine and format hourly data
        $hourlyLabels = range(0, 23);
        $formattedHourlyData = [
            'labels' => array_map(function($hour) {
                return sprintf('%02d:00', $hour);
            }, $hourlyLabels),
            'qris' => array_map(function($hour) use ($qrisHourlyData) {
                return $qrisHourlyData[$hour] ?? 0;
            }, $hourlyLabels),
            'tunai' => array_map(function($hour) use ($tunaiHourlyData) {
                return $tunaiHourlyData[$hour] ?? 0;
            }, $hourlyLabels)
        ];

        // Find peak hours
        $totalHourlyData = [];
        foreach ($hourlyLabels as $hour) {
            $totalHourlyData[$hour] = ($qrisHourlyData[$hour] ?? 0) + ($tunaiHourlyData[$hour] ?? 0);
        }
        arsort($totalHourlyData);
        $peakHours = array_slice($totalHourlyData, 0, 3, true);

        // Get best seller data
        $bestSellers = MenuBestSeller::select('product_ordered')
            ->get()
            ->flatMap(function ($item) {
                return explode(', ', $item->product_ordered);
            })
            ->countBy()
            ->sortDesc()
            ->take(5);

        $totalOrders = $bestSellers->sum();
        
        $bestSellersWithPercentage = $bestSellers->map(function ($count) use ($totalOrders) {
            return [
                'count' => $count,
                'percentage' => round(($count / $totalOrders) * 100, 1)
            ];
        });

        return view('owner.report.index', compact(
            'qrisCount', 
            'tunaiCount', 
            'bestSellersWithPercentage',
            'formattedHourlyData',
            'peakHours',
            'topEmployees',  // Add topEmployees to the view
            'employeeCollection' // Add full employee collection if needed
        ));
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
