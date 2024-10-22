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

        // Menentukan rentang tanggal
        $endDate = Carbon::now(); // Hari ini
        $startDate = Carbon::now()->startOfWeek(); // Senin dari minggu ini
        
        // Mengambil data kunjungan dengan query yang lebih efisien
        $visits = VisitHistory::select(DB::raw('DATE(visited_at) as date'), DB::raw('COUNT(DISTINCT ip_address) as total'))
            ->whereBetween('visited_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // Menyiapkan data untuk grafik dengan format hari dalam Bahasa Indonesia
        $daysIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        $visitData = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $dayName = $daysIndonesia[$currentDate->format('l')];
            
            $visitData[$dayName] = [
                'count' => $visits->has($dateStr) ? $visits[$dateStr]->total : 0,
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
