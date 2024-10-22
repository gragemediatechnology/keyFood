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
        if (!$request->is('admin/*')) { // Hanya track untuk halaman non-admin
            $ip = $request->ip();
            $cacheKey = 'visit_' . $ip . '_' . date('Y-m-d_H');
            
            if (!Cache::has($cacheKey)) {
                try {
                    VisitHistory::create([
                        'ip_address' => $ip,
                        'user_id' => Auth::id(),
                        'visited_at' => now()
                    ]);
                    
                    Cache::put($cacheKey, true, now()->addHour());
                    
                } catch (\Exception $e) {
                    Log::error('Error tracking visit: ' . $e->getMessage());
                }
            }
        }
        
        return $next($request);
    }

}


