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

    // Mengatur range tanggal untuk 7 hari terakhir
    $endDate = Carbon::now();
    $startDate = Carbon::now()->subDays(6); // 7 hari termasuk hari ini
    
    // Query untuk mendapatkan data kunjungan
    $visits = VisitHistory::select(
            DB::raw('DATE(visited_at) as date'),
            DB::raw('COUNT(DISTINCT ip_address) as total')
        )
        ->whereBetween('visited_at', [
            $startDate->startOfDay(),
            $endDate->endOfDay()
        ])
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Menyiapkan data untuk grafik
    $daysIndonesia = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    // Inisialisasi data untuk 7 hari
    $visitData = [];
    $currentDate = $startDate->copy();
    
    while ($currentDate <= $endDate) {
        $dateStr = $currentDate->format('Y-m-d');
        $dayName = $daysIndonesia[$currentDate->format('l')];
        
        $dayVisits = $visits->firstWhere('date', $dateStr);
        
        $visitData[$dayName] = [
            'count' => $dayVisits ? $dayVisits->total : 0,
            'date' => $dateStr
        ];
        
        $currentDate->addDay();
    }

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
