<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Orders;
use App\Models\Toko;
use Illuminate\Http\Request;
use App\Models\VisitHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




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
    try {
        // Data dasar
        $orders = Orders::orderBy('id', 'desc')->paginate(20);
        $totalUser = User::count();
        $stores = Toko::count();
        $totalOrders = Orders::count();
        $paymentTotal = Orders::sum('harga');

        // Menentukan rentang tanggal
        $endDate = Carbon::now()->endOfDay();
        $startDate = Carbon::now()->startOfWeek()->startOfDay();

        // Query untuk mengambil data kunjungan per hari
        $visits = VisitHistory::select([
            DB::raw('DATE(visited_at) as date'),
            DB::raw('COUNT(DISTINCT ip_address) as total')
        ])
        ->whereBetween('visited_at', [$startDate, $endDate])
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        // Menyiapkan data hari dalam bahasa Indonesia
        $daysIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        // Inisialisasi array untuk data kunjungan
        $visitData = [];
        $currentDate = $startDate->copy();

        // Mengisi data untuk setiap hari
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $dayName = $daysIndonesia[$currentDate->format('l')];
            
            $dayVisit = $visits->firstWhere('date', $dateStr);
            
            $visitData[$dayName] = [
                'count' => $dayVisit ? (int)$dayVisit->total : 0,
                'date' => $dateStr
            ];
            
            $currentDate->addDay();
        }

        // Debug log untuk memverifikasi data
        Log::info('Visit data generated:', ['data' => $visitData]);

        return view('admin.dashboard-main', compact(
            'orders',
            'totalUser',
            'paymentTotal',
            'stores',
            'totalOrders',
            'visitData'
        ));
    } catch (\Exception $e) {
        Log::error('Error in dashboard generation:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return view('admin.dashboard-main')->with('error', 'Terjadi kesalahan saat memuat data.');
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
