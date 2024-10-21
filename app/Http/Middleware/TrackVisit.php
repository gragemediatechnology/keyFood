<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\VisitHistory;
use Illuminate\Support\Facades\Auth;


class TrackVisit
{
    public function handle($request, Closure $next)
    {
        // Catat kunjungan ke database
        VisitHistory::create([
            'ip_address' => $request->ip(),
            'user_id' => Auth::check() ? Auth::id() : null,
            'visited_at' => now(),
        ]);

        return $next($request);
    }
}

