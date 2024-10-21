<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Orders;
use App\Models\Toko;
use Illuminate\Http\Request;
use App\Models\VisitHistory;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Orders::orderBy('id', 'desc')->paginate(20);
        $totalUser = User::all()->count(); //menghitung jumlah user
        $stores = Toko::all()->count(); // menghitung jumlah toko
        $totalOrders = Orders::all()->count(); //menghitung jumlah transaksi atau order
        $paymentTotal = Orders::sum('harga'); // menjumlahkan semua kolom harga

        return view('admin.dashboard-main',  compact('orders','totalUser', 'paymentTotal', 'stores', 'totalOrders'));
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

    public function visitHistoryChart()
    {
        // Ambil data kunjungan, dikelompokkan berdasarkan tanggal
        $visits = VisitHistory::selectRaw('DATE(visited_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('dashboard', compact('visits'));
    }

}
