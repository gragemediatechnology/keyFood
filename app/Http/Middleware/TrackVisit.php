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
            $cacheKey = 'visit_' . $ip . '_' . date('Y-m-d_H');
            
            // Menggunakan cache untuk menghindari pencatatan berulang
            if (!Cache::has($cacheKey)) {
                // Catat kunjungan baru
                VisitHistory::create([
                    'ip_address' => $ip,
                    'user_id' => Auth::id(),
                    'visited_at' => now()
                ]);

                // Set cache selama 1 jam
                Cache::put($cacheKey, true, now()->addHour());

                // Log untuk debugging
                Log::info('New visit recorded', [
                    'ip' => $ip,
                    'user_id' => Auth::id(),
                    'time' => now()->toDateTimeString(),
                    'url' => $request->fullUrl()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error in TrackVisit middleware: ' . $e->getMessage());
        }

        return $next($request);
    }
}


