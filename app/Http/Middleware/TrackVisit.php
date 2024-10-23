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
        $ip = $request->ip();  // Ambil IP pengguna
        $userAgent = $request->header('User-Agent');  // Ambil User Agent
        $today = Carbon::now()->format('Y-m-d');  // Tanggal hari ini

        Log::info("Tracking visit: IP - {$ip}, User-Agent - {$userAgent}, Date - {$today}");

        // Cek apakah kunjungan dari IP yang sama pada hari ini sudah tercatat
        $existingVisit = VisitHistory::where('ip_address', $ip)
            ->where('user_agent', $userAgent)
            ->whereDate('visited_at', $today)
            ->first();

        if (!$existingVisit) {
            // Simpan kunjungan baru ke database
            VisitHistory::create([
                'ip_address' => $ip,
                'user_id' => Auth::id(),  // User ID atau null jika pengguna tidak login
                'user_agent' => $userAgent,
                'visited_at' => now(),
            ]);

            Log::info("New visit recorded for IP - {$ip}");
        } else {
            Log::info("Visit already exists for IP - {$ip}");
        }
    } catch (\Exception $e) {
        Log::error('Error in TrackVisit middleware: ' . $e->getMessage());
    }

    return $next($request);
}



    private function isBot($userAgent)
    {
        $botKeywords = ['bot', 'crawler', 'spider', 'slurp', 'baidu', 'yandex'];
        $userAgentLower = strtolower($userAgent);
        
        foreach ($botKeywords as $keyword) {
            if (str_contains($userAgentLower, $keyword)) {
                return true;
            }
        }
        
        return false;
    }
}


