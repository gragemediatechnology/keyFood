<?php

// namespace App\Http\Middleware;

// use Closure;
// use App\Models\VisitHistory;
// use Illuminate\Support\Facades\Auth;


// class TrackVisit
// {
    // public function handle($request, Closure $next)
    // {
        // Catat kunjungan ke database
        // VisitHistory::create([
            // 'ip_address' => $request->ip(),
            // 'user_id' => Auth::check() ? Auth::id() : null,
            // 'visited_at' => now(),
        // ]);

        // return $next($request);
    // }
// }



// App/Http/Middleware/TrackVisit.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class TrackVisit
{
    public function handle(Request $request, Closure $next)
{
    try {
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        $timestamp = Carbon::now()->timestamp; // Tambahkan timestamp sebagai identifikasi tambahan
        $today = Carbon::now()->format('Y-m-d');

        // Kombinasi unik IP, User-Agent, dan timestamp untuk cache key
        $cacheKey = "visit_{$ip}_{$userAgent}_{$timestamp}";

        // Jika cache tidak ditemukan, berarti kunjungan baru
        if (!Cache::has($cacheKey)) {
            $existingVisit = VisitHistory::where('ip_address', $ip)
                ->where('user_agent', $userAgent)
                ->whereDate('visited_at', $today)
                ->first();

            // Jika tidak ada kunjungan yang terdeteksi pada hari yang sama, catat kunjungan baru
            if (!$existingVisit) {
                VisitHistory::create([
                    'ip_address' => $ip,
                    'user_id' => Auth::id(),  // Atau null jika pengunjung tidak login
                    'user_agent' => $userAgent,
                    'visited_at' => now(),
                ]);

                // Simpan dalam cache untuk sesi ini
                Cache::put($cacheKey, true, now()->addMinutes(30));  // Cache hanya bertahan selama 30 menit
            }
        }
    } catch (\Exception $e) {
        Log::error('Error in TrackVisit middleware: ' . $e->getMessage());
    }

    return $next($request);
}

}


