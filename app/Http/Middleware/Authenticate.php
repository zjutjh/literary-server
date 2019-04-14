<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (!$user = $request->user()) {
            return RJM(1, null, '请先登录');
        }
        return $next($request);
    }
}
