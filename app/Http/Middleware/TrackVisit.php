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
            $today = Carbon::now()->format('Y-m-d');
            $cacheKey = "visit_{$ip}_{$today}";
            
            // Cek apakah pengunjung sudah tercatat hari ini
            if (!Cache::has($cacheKey)) {
                // Cek apakah sudah ada kunjungan dengan IP yang sama hari ini
                $existingVisit = VisitHistory::where('ip_address', $ip)
                    ->whereDate('visited_at', $today)
                    ->first();

                if (!$existingVisit) {
                    // Catat kunjungan baru
                    VisitHistory::create([
                        'ip_address' => $ip,
                        'user_id' => Auth::id(),
                        'visited_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // Set cache untuk mencegah multiple entries
                    Cache::put($cacheKey, true, Carbon::now()->endOfDay());
                    
                    Log::info('New visit recorded', [
                        'ip' => $ip,
                        'user_id' => Auth::id(),
                        'time' => now()->toDateTimeString(),
                        'url' => $request->fullUrl()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in TrackVisit middleware: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
        }

        return $next($request);
    }
}


