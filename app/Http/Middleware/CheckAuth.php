<?php

namespace App\Http\Middleware;

use App\ResponseCodes\ResponseCodes;
use App\Traits\Response\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuth
{
    use Response;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()) {
            return $this->response([], ResponseCodes::UNAUTHORIZED);
        }

        return $next($request);
    }
}
