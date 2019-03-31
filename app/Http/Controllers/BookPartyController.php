<?php

namespace App\Http\Controllers;

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
