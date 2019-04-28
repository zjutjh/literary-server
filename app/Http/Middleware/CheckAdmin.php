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
        // TODO 如何验证是管理员
        return $next($request);
//        if ($user = $request->Admin()) {
//            if ($user->isAdmin) {
//                return $next($request);
//            }
//            return RJM(1, null, '不是管理员');
//        }
//        return RJM(1, null, '请先登录');
//        if ($request->)
    }
}
