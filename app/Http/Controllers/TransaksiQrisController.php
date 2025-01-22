<?php

namespace App\Http\Controllers;

use App\Models\TransaksiQris;
use Illuminate\Http\Request;

class TransaksiQrisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validasi data yang diterima dari request
        $request->validate([
            'subtotal' => 'required|numeric|min:0',
            'total_cost_price' => 'required|numeric|min:0',
            'name_user' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'timestamp' => 'required|date',
        ]);

        // Buat dan simpan instance baru dari model TransaksiTunai
        $transaksiTunai = TransaksiQris::create($request->all());

        // Kembalikan respon yang sesuai
        return redirect()->route('owner.cashier.index')
            ->with('success', 'Transaksi tunai berhasil disimpan!');
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
