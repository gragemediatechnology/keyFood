<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Orders;
use App\Models\Toko;
use Illuminate\Http\Request;
use App\Models\VisitHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;





class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $orders = Orders::orderBy('id', 'desc')->paginate(20);
    //     $totalUser = User::all()->count(); //menghitung jumlah user
    //     $stores = Toko::all()->count(); // menghitung jumlah toko
    //     $totalOrders = Orders::all()->count(); //menghitung jumlah transaksi atau order
    //     $paymentTotal = Orders::sum('harga'); // menjumlahkan semua kolom harga
    //     $visits = VisitHistory::selectRaw('DATE(visited_at) as date, COUNT(*) as total')
    //         ->groupBy('date')
    //         ->orderBy('date', 'asc')
    //         ->get();

    //     return view('admin.dashboard-main',  compact('orders','totalUser', 'paymentTotal', 'stores', 'totalOrders','visits'));
    // }

    public function index()
    {
        // Data dasar
        $orders = Orders::orderBy('id', 'desc')->paginate(20);
        $totalUser = User::count();
        $stores = Toko::count();
        $totalOrders = Orders::count();
        $paymentTotal = Orders::sum('harga');

        // Data kunjungan
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(6);
        
        $visits = VisitHistory::selectRaw('DATE(visited_at) as date, COUNT(DISTINCT ip_address) as total')
            ->whereBetween('visited_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data untuk grafik
        $visitData = collect(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])
            ->mapWithKeys(function ($day) use ($visits, $startDate, $endDate) {
                $date = $startDate->copy()->addDays(array_search($day, [
                    'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
                ]));
                
                if ($date <= $endDate) {
                    $visitCount = $visits->where('date', $date->format('Y-m-d'))->first();
                    return [$day => [
                        'count' => $visitCount ? $visitCount->total : 0,
                        'date' => $date->format('Y-m-d')
                    ]];
                }
                
                return [$day => ['count' => 0, 'date' => null]];
            })->toArray();

        return view('admin.dashboard-main', compact(
            'orders',
            'totalUser',
            'paymentTotal',
            'stores',
            'totalOrders',
            'visitData'
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

    // public function visitHistoryChart()
    // {
    //     // Ambil data kunjungan, dikelompokkan berdasarkan tanggal
    //     $visits = VisitHistory::selectRaw('DATE(visited_at) as date, COUNT(*) as total')
    //         ->groupBy('date')
    //         ->orderBy('date', 'asc')
    //         ->get();

    //     return view('admin.dashboard-main', compact('visits'));
    // }

}
