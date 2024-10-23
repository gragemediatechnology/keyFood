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
            $now = Carbon::now()->setTimezone('Asia/Jakarta');
            $today = $now->format('Y-m-d');
            $cacheKey = "visit_{$ip}_{$today}";
            
            // Cek apakah request dari bot
            $userAgent = $request->header('User-Agent');
            if ($this->isBot($userAgent)) {
                return $next($request);
            }

            // Cek cache dengan waktu yang lebih pendek (30 menit)
            if (!Cache::has($cacheKey)) {
                // Lock untuk menghindari race condition
                Cache::lock("visit_lock_{$ip}", 10)->get(function () use ($ip, $today, $cacheKey, $now) {
                    $existingVisit = VisitHistory::where('ip_address', $ip)
                        ->whereDate('visited_at', $today)
                        ->first();

                    if (!$existingVisit) {
                        VisitHistory::create([
                            'ip_address' => $ip,
                            'user_id' => Auth::id(),
                            'visited_at' => $now,
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);

                        // Cache selama 30 menit
                        Cache::put($cacheKey, true, now()->addMinutes(30));
                        
                        Log::info('New visit recorded', [
                            'ip' => $ip,
                            'time' => $now->toDateTimeString()
                        ]);
                    }
                });
            }

        } catch (\Exception $e) {
            Log::error('Error in TrackVisit middleware', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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


