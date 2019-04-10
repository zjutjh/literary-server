<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\UserAdmin;
use Illuminate\Support\Facades\Validator;
//use Validator;
//use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Services\JHService;
use Illuminate\Http\Request;
use App\Rules\Mobile;
use Tymon\JWTAuth\JWTAuth;

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
//    global int is_admin = 0;

    public function __construct() {
        $this->middleware('guest')->except('logout');
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
//            if(($user = User::where('sid',$username))->is_admin){
//
//            }
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
