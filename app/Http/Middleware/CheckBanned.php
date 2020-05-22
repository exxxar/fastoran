<?php

namespace App\Http\Middleware;

use App\BlackList;
use Closure;
use Illuminate\Support\Facades\Log;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $banned = BlackList::where("ip", $request->ip())->first();

        if (!is_null($banned))
            die("Access denied");

        return $next($request);
    }
}
