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

        // Validasi jika query kosong
        if (empty($query)) {
            return response()->json(['data' => []]);
        }

        // Query dengan group
        $histories = AdminHistory::with('admin') // Eager loading relasi admin
            ->where('action', 'LIKE', "%{$query}%")
            ->orWhere('affected_model', 'LIKE', "%{$query}%")
            ->orWhere('created_at', 'LIKE', "%{$query}%")
            ->orWhereHas('admin', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->get();

        return response()->json([
            'data' => $histories,
        ]);
    } catch (\Exception $e) {
        Log::error('Error during history search:', [
            'error' => $e->getMessage(),
        ]);
        return response()->json(['message' => 'Terjadi kesalahan saat mencari data'], 500);
    }
}

}
