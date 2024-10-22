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



namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class TrackVisit
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $ip = $request->ip();
            $today = now()->format('Y-m-d');
            $cacheKey = 'visit_' . $ip . '_' . $today;
            
            // Cek apakah request dari bot
            $userAgent = $request->header('User-Agent');
            if (!preg_match('/bot|crawler|spider|crawling/i', $userAgent)) {
                // Menggunakan cache harian
                if (!Cache::has($cacheKey)) {
                    // Catat kunjungan baru
                    VisitHistory::create([
                        'ip_address' => $ip,
                        'user_id' => Auth::id(),
                        'visited_at' => now()
                    ]);
                    
                    // Set cache selama 1 hari
                    Cache::put($cacheKey, true, now()->endOfDay());
                    
                    Log::info('New visit recorded', [
                        'ip' => $ip,
                        'user_id' => Auth::id(),
                        'date' => $today
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in TrackVisit middleware: ' . $e->getMessage());
        }
        
        return $next($request);
    }
}

