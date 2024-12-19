<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\AdminHistory;
use Illuminate\Http\Request;

class AdminHistoryController extends Controller
{
    public function index()
    {
        $histories = AdminHistory::with('admin')->latest()->paginate(10);
        return view('admin.history.index', compact('histories'));
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
    
            // Lakukan pencarian berdasarkan beberapa kolom
            $orders = AdminHistory::with('admin') // Eager loading untuk relasi user
                ->where('email', 'LIKE', "%{$query}%")
                ->orWhere('action', 'LIKE', "%{$query}%")
                ->orWhereHas('admin', function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%"); // Cari berdasarkan nama user
                })
                ->orWhere('affected_model', 'LIKE', "%{$query}%")
                ->orWhere('created_at', 'LIKE', "%{$query}%")
                ->get();
    
            return response()->json([
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            Log::error('Error during history search:', [
                'error' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan saat mencari data'], 500);
        }
    }
}
