<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckAdmin extends BaseMiddleware

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
        $this->checkForToken($request);
        try {
            if ($this->auth->parseToken()->authenticate()) {
                return $next($request);
            }
        } catch (TokenExpiredException $e) {
            try {
                // 刷新用户的 token
                $token = $this->auth->refresh();
                // 使用一次性登录以保证此次请求的成功
                Auth::guard('admin')->onceUsingId($this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub']);
            } catch (JWTException $e) {
                return RJM(-402, null, '缺少登录凭证');
            }
        } catch (TokenInvalidException $e) {
            return RJM(-403, null, '登录凭证不合法');
        } catch (JWTException $e) {
            return RJM(-402, null, '缺少登录凭证');
        }
        return $this->setAuthenticationHeader($next($request), $token);
    }

}
