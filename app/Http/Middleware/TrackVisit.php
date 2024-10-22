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

class TrackVisit
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Cek apakah sudah ada kunjungan dari IP ini dalam 1 jam terakhir
            $recentVisit = VisitHistory::where('ip_address', $request->ip())
                ->where('visited_at', '>=', now()->subHour())
                ->first();

            if (!$recentVisit) {
                // Log untuk debugging
                Log::info('New visit recorded', [
                    'ip' => $request->ip(),
                    'user_id' => Auth::id(),
                    'time' => now()->toDateTimeString(),
                    'url' => $request->fullUrl()
                ]);

                // Catat kunjungan baru
                VisitHistory::create([
                    'ip_address' => $request->ip(),
                    'user_id' => Auth::id(),
                    'visited_at' => now()
                ]);
            }
        } catch (\Exception $e) {
            // Log error tapi jangan hentikan request
            Log::error('Error in TrackVisit middleware: ' . $e->getMessage());
        }

        return $next($request);
    }
}

