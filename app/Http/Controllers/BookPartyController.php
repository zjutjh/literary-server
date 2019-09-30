<?php

namespace App\Http\Controllers;

use App\Institute;
use App\User;
use App\BookPartyCheckin;
use App\BookPartySignup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
//use Validator;
use App\BookParty;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookPartyController extends Controller
{
    public function list() {
        return RJM(0, BookParty::where('status', '=', '0')->orderBy('start_time', 'desc')->get());
    }

    public function detail(Request $request) {
        $messages = [
            'bookPartyId.required' => '错误的参数'
        ];
        $validator = Validator::make($request->all(), [
            'bookPartyId' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }
        $bookPartyId = $request->get('bookPartyId');
        $user = $request->user();
        if(!$bookParty = BookParty::getBookPartyWhenLogin($bookPartyId, $user ? $user->id : null)) {

            return RJM(1, null, '找不到该读书会');
        }

        return RJM(0, $bookParty);
    }


    public function getSignupListByUser(Request $request) {
        $user = $request->user();
        $list = BookPartySignup::where('uid', $user->id)->orderBy('start_time', 'desc')->get();
        foreach ($list as $key => $value) {
            $list[$key] = BookParty::getBookPartyWhenLogin($value->book_party_id, $user->id);
        }
        return RJM(0, $list);
    }

    public function getCheckinListByUser(Request $request) {
        $user = $request->user();
        $list = BookPartyCheckin::where('uid', $user->id)->orderBy('id', 'desc')->get();
        foreach ($list as $key => $value) {
            $list[$key] = BookParty::getBookPartyWhenLogin($value->book_party_id, $user->id);
        }
        return RJM(0, $list);
    }

    /**
     * 报名
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function signup(Request $request) {
        $messages = [
            'bookPartyId.required' => '错误的参数'
        ];
        $validator = Validator::make($request->all(), [
            'bookPartyId' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }

        $bookPartyId = $request->get('bookPartyId');
        $bookParty = BookParty::where('id', '=', $bookPartyId)->where('status', '=', '0')->first();
        $user = $request->user();
        if (!$bookParty) {
            return RJM(1, null, '找不到读书会');
        }
        if (!$user) {
            return RJM(1, null, '请先登录');
        }
        $count = BookPartySignup::where('book_party_id', $bookPartyId)->count();
        if ($bookParty->max_user && $bookParty->max_user <= $count) {
            return RJM(1, null, '超过最大报名人数');
        }
        if (BookPartySignup::where('uid', $user->id)->where('book_party_id', $bookPartyId)->first()) {
            return RJM(1, null, '你已经报名过该读书会');
        }
        $signup = new BookPartySignup();
        $signup->uid = $user->id;
        $signup->book_party_id = $bookPartyId;
        $signup->save();

        return RJM(0, BookParty::getBookPartyWhenLogin($bookPartyId, $user ? $user->id : null), '报名成功');

    }

    /**
     * 签到
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkin(Request $request) {
        $messages = [
            'checkinCode.required' => '签到码错误'
        ];
        $validator = Validator::make($request->all(), [
            'checkinCode' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }

        $checkinCode = $request->get('checkinCode');
        $bookPartyId = $request->get('bookPartyId');
        $bookParty = BookParty::where('checkin_code', '=', $checkinCode)->where('status', '=', '0')->first();
        $user = $request->user();
        if (!$bookParty) {
            return RJM(1, null, '签到二维码错误');
        }
        // 假如有传id，那么就校验一下签到的码和查到的是否是同一个读书会
        if ($bookPartyId && intval($bookPartyId) !== intval($bookParty->id)) {
            return RJM(1, null, '你可能签错到了');
        }
        if (!$user) {
            return RJM(1, null, '请先登录');
        }
        if (!$signup = BookPartySignup::where('uid', $user->id)->where('book_party_id', $bookParty->id)->first()) {
            return RJM(1, null, '你未报名过该读书会');
        }
        if (BookPartyCheckin::where('uid', $user->id)->where('book_party_id', $bookParty->id)->first()) {
            return RJM(1, null, '你已经签到过了');
        }
        $checkin = new BookPartyCheckin();
        $checkin->uid = $user->id;
        $checkin->book_party_id = $bookParty->id;
        $checkin->save();

        return RJM(0, BookParty::getBookPartyWhenLogin($bookParty->id, $user ? $user->id : null), '报名成功');

    }

    /**
     * 应该只允许管理员添加
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */


    public function add(Request $request) {
//        表单验证
        $messages = [
            'title.required' => '标题不能为空',
            'startTime.required' => '开始时间不能为空',
            'place.required' => '地点不能为空',
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'startTime' => 'required',
            'place' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }
        $title = $request->get('title');
        $speaker = $request->get('speaker');
        $startTime = Carbon::parse($request->get('startTime'));//时间处理，解析任何顺序和类型的日期
        $place = $request->get('place');
        $summary = $request->get('summary');
        $maxUser = $request->get('maxUser') ? $request->get('maxUser') : 0;
        $checkinCode = Str::random(20);

        $party = new BookParty([
            'title' => $title,
            'speaker' => $speaker,
            'place' => $place,
            'start_time' => $startTime,
            'summary' => $summary,
            'max_user' => $maxUser,
            'checkin_code' => $checkinCode
        ]);

        $party->save();

        return RJM(0);
    }



//    显示指定读书会的报名人员
    public function showSignUp($id){
        $ids = BookPartySignup::where('book_party_id', $id)->pluck('uid');
        $users = User::whereIn('id', $ids)->distinct()->get();

        return RJM(0,[
            'user' => $users
        ]);
    }

    /**
     * 更新
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request) {
        $messages = [
            'bookPartyId.required' => '错误的参数',
            'title.required' => '标题不能为空',
            'startTime.required' => '开始时间不能为空',
            'place.required' => '地点不能为空',
        ];
        $validator = Validator::make($request->all(), [
            'bookPartyId' => 'required',
            'title' => 'required',
            'startTime' => 'required',
            'place' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }
        $bookPartyId = $request->get('bookPartyId');
        $title = $request->get('title');
        $speaker = $request->get('speaker');
        $startTime = Carbon::parse($request->get('startTime'));
        $place = $request->get('place');
        $summary = $request->get('summary');
        $maxUser = $request->get('maxUser') ? $request->get('maxUser') : 0;
        $checkinCode = Str::random(20);

        BookParty::where('id', $bookPartyId)->update([
            'title' => $title,
            'speaker' => $speaker,
            'place' => $place,
            'start_time' => $startTime,
            'summary' => $summary,
            'max_user' => $maxUser,
            'checkin_code' => $checkinCode
        ]);
        return RJM(0);
    }

    public function delete(Request $request) {
        $messages = [
            'bookPartyId.required' => '错误的参数'
        ];
        $validator = Validator::make($request->all(), [
            'bookPartyId' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return RJM(1, null, $errors->first());
        }

        $bookPartyId = $request->get('bookPartyId');
        $bookParty = BookParty::where('id', '=', $bookPartyId)->where('status', '=', '0')->first();
        if (!$bookParty) {
            return RJM(1, null, '找不到读书会');
        }
        $bookParty->delete();

        return RJM(0);
    }

}

