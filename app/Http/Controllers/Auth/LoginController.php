<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\UserAdmin;
use Illuminate\Support\Facades\Validator;
use App\UserLink;
//use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Services\JHService;
use Illuminate\Http\Request;
use App\Rules\Mobile;
//use Tymon\JWTAuth\JWTAuth;

//use Tymon\JWTAuth\Facades\JWTAuth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function loginByWeappOpenid(Request $request) {
        $messages = [
            'openid' => '参数错误'
        ];
        $validator = Validator::make($request->all(), [
            'openid' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }
        $openid = $request->get('openid');
        if ($userLink = UserLink::where('openid', $openid)->where('type', 'weapp')->first()) {
            $user = User::where('id', $userLink->uid)->first();
            try {
                if (!$token = JWTAuth::fromUser($user)) {
                    return RJM(1, null, '用户错误');
                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return RJM(1, null, 'token生成错误');
            }

            return RJM(0, [
                'token' => $token
            ], '自动登录成功');
        } else {
            return RJM(1, null, '找不到绑定关系');
        }
    }

    public function loginWithOpenid(Request $request) {
        $messages = [
            'username.required' => '用户名不能为空',
            'password.required' => '用户名不能为空',
            'openid' => '缺少openid',
            'type' => '缺少类型',
        ];
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'openid' => 'required',
            'type' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }
        $username = $request->get('username');
        $password = $request->get('password');
        $openid = $request->get('openid');
        $type = $request->get('type');
        try {
            JHService::login($username, $password);
        } catch (\Exception $e) {
            return RJM(1, null, $e->getMessage());
        }

        // 检测是否存在用户，不存在则创建
        if(!$user = User::where('sid', $username)->first()) {
            $user = new User;
            $user->sid = $username;
            $user->save();
            $userLink = new UserLink;
            $userLink->uid = $user->id;
            $userLink->type = $type;
            $userLink->openid = $openid;
            $userLink->save();
        }

        try {
            if (!$token = JWTAuth::fromUser($user)) {
                return RJM(1, null, '用户错误');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return RJM(1, null, 'token生成错误');
        }

        return RJM(0, [
            'token' => $token
        ]);
    }

    public function login(Request $request) {
        $messages = [
            'username.required' => '用户名不能为空',
            'password.required' => '密码不能为空'
        ];
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }
        $username = $request->get('username');
        $password = $request->get('password');
        try {
            JHService::login($username, $password);
        } catch (\Exception $e) {
            return RJM(1, null, $e->getMessage());
        }

        // 检测是否存在用户，不存在则创建
        if(!$user = User::where('sid', $username)->first()) {
            $user = new User;
            $user->sid = $username;
            $user->save();
        }

        try {
            if (!$token = JWTAuth::fromUser($user)) {
                return RJM(1, null, '用户错误');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return RJM(1, null, 'token生成错误');
        }

        return RJM(0, [
            'token' => $token
        ]);
    }

//    管理员登录
    public function adminLogin(Request $request){
        $messages = [
            'username.required' => '用户名不能为空',
            'password.required' => '密码不能为空'
        ];
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }
        $username = $request->get('username');
        $password = $request->get('password');
        if (!$user = UserAdmin::where('username',$username)->first()){
            return RJM(1, null, '用户不存在');
        }else if ($user->password != $password){
            return RJM(1, null, '用户密码错误');
        }else{
//            $request->session()->put('is_admin', "true");
            return RJM(0,$user);
        }
    }

}
