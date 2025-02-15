<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiQris;
use App\Models\TransaksiTunai;
use App\Models\MenuBestSeller;

class ReportOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qrisCount = TransaksiQris::count();
        $tunaiCount = TransaksiTunai::count();

        // Get best seller data
        $bestSellers = MenuBestSeller::select('product_ordered')
            ->get()
            ->flatMap(function ($item) {
                return explode(', ', $item->product_ordered);
            })
            ->countBy()
            ->sortDesc()
            ->take(5); // Ambil 5 menu terlaris

        // Hitung total transaksi untuk persentase
        $totalOrders = $bestSellers->sum();
        
        // Tambahkan persentase ke data best seller
        $bestSellersWithPercentage = $bestSellers->map(function ($count) use ($totalOrders) {
            return [
                'count' => $count,
                'percentage' => round(($count / $totalOrders) * 100, 1)
            ];
        });

        return view('owner.report.index', compact('qrisCount', 'tunaiCount', 'bestSellersWithPercentage'));
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
