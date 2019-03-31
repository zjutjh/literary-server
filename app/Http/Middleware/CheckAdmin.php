<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($user = $request->user()) {
            if ($user->isAdmin) {
                return $next($request);
            }
            return RJM(1, $user, '不是管理员');
        }
        return RJM(1, null, '请先登录');
    }
}
