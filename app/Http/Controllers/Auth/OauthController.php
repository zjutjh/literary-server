<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OauthController extends Controller
{
    public function weapp(Request $request) {
        if(!$code = $request->get('code')) {
            return RJM(null, -401, 'code不存在');
        }
        $app = app('wechat.mini_program');
        $result = $app->auth->session($code);

        return RJM(0, [
            'openid' => $result['openid'],
        ], '获取openid成功');
    }
}
