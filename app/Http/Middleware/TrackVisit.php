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
        $userAgent = $request->header('User-Agent');  // Tambahkan User-Agent
        $today = Carbon::now()->format('Y-m-d');
        $cacheKey = "visit_{$ip}_{$userAgent}_{$today}";  // Cache berdasarkan IP dan User-Agent
        
        if (!Cache::has($cacheKey)) {
            $existingVisit = VisitHistory::where('ip_address', $ip)
                ->where('user_agent', $userAgent)  // Tambahkan User-Agent di query
                ->whereDate('visited_at', $today)
                ->first();

            if (!$existingVisit) {
                VisitHistory::create([
                    'ip_address' => $ip,
                    'user_id' => Auth::id(),
                    'user_agent' => $userAgent,  // Simpan User-Agent
                    'visited_at' => now(),
                ]);

                Cache::put($cacheKey, true, Carbon::now()->endOfDay());
            }
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


