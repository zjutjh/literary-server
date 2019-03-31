<?php

namespace App\Http\Controllers;

use App\BookPartyCheckin;
use App\BookPartySignup;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Validator;
use App\BookParty;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookPartyController extends Controller
{
    public function list() {
        return RJM(0, BookParty::where('status', '=', '0')->get());
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
        if(!$bookParty = BookParty::getBookPartyWhenLogin($bookPartyId, $user->id)) {
            return RJM(1, null, '找不到该读书会');
        }

        return RJM(0, $bookParty);
    }

    public function getSignupListByUser(Request $request) {
        $user = $request->user();
        $list = BookPartySignup::where('uid', $user->id)->get();
        foreach ($list as $key => $value) {
            $list[$key] = BookParty::getBookPartyWhenLogin($value->book_party_id, $user->id);
        }
        return RJM(0, $list);
    }

    public function getCheckinListByUser(Request $request) {
        $user = $request->user();
        $list = BookPartyCheckin::where('uid', $user->id)->get();
        foreach ($list as $key => $value) {
            $list[$key] = BookParty::getBookPartyWhenLogin($value->book_party_id, $user->id);
        }
        return RJM(0, $list);
    }

    /**
     * 报名
     * @param Request $request
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
        if (BookPartySignup::where('uid', $user->id)->where('book_party_id', $bookPartyId)->first()) {
            return RJM(1, null, '你已经报名过该读书会');
        }
        $signup = new BookPartySignup();
        $signup->uid = $user->id;
        $signup->book_party_id = $bookPartyId;
        $signup->save();

        return RJM(0, null, '报名成功');

    }

    /**
     * 签到
     * @param Request $request
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
        $bookParty = BookParty::where('checkin_code', '=', $checkinCode)->where('status', '=', '0')->first();
        $user = $request->user();
        if (!$bookParty) {
            return RJM(1, null, '找不到读书会');
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

        return RJM(0, null, '报名成功');

    }

    /**
     * 应该只允许管理员添加
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request) {
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
        $startTime = Carbon::parse($request->get('startTime'));
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
}
