<?php

namespace App\Http\Controllers;

use App\Rules\Mobile as MobileRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateUserInfo(Request $request) {
        $messages = [
            'mobile.required' => '手机不能为空',
            'instituteId.required' => '学院不能为空'
        ];
        $validator = Validator::make($request->all(), [
            'instituteId' => 'required',
            'mobile' => ['required', new MobileRule]
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }
        $mobile = $request->get('mobile');
        $instituteId = $request->get('instituteId');

        $user = $request->user();
        $user->mobile = $mobile;
        $user->institute_id = $instituteId;
        $user->save();

        return RJM(0, $user, '更新成功');
    }
}
