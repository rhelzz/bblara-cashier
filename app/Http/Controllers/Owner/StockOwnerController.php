<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::all();

        return view('owner.stock.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.stock.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'raw_material' => 'required|string|max:255',
            'qty' => 'required|integer',
            'weight' => 'required|string|max:255',
            'unit' => 'required|string|max:10',
        ]);

        Stock::create($request->all());

        return redirect()->route('owner.stock.index')->with('success', 'Stock created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        return view('owner.stock.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        return view('owner.stock.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'raw_material' => 'required|string|max:255',
            'qty' => 'required|integer',
            'weight' => 'required|string|max:255',
            'unit' => 'required|string|max:10',
        ]);

        $stock->update($request->all());

        return redirect()->route('owner.stock.index')->with('success', 'Stock updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('owner.stock.index')->with('success', 'Stock deleted successfully.');
    }

    public function incrementQty($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->qty += 1;
        $stock->save();

        return redirect()->route('owner.stock.index')->with('success', 'Quantity increased successfully.');
    }

    public function decrementQty($id)
    {
        $stock = Stock::findOrFail($id);
        if ($stock->qty > 0) {
            $stock->qty -= 1;
            $stock->save();
        }

        return redirect()->route('owner.stock.index')->with('success', 'Quantity decreased successfully.');
    }
}
