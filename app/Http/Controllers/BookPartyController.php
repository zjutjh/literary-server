<?php

namespace App\Http\Controllers;

use App\Institutes;
use App\SignUp;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
//use Validator;
use App\BookParty;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookPartyController extends Controller
{

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

//    显示所有读书会信息
    public function showBookParty(){

        $bookParties = BookParty::get();
        return RJM(0,
            ['bookParties' => $bookParties]);
    }

//    删除读书会
    public function delete(Request $request){
        $id = $request->get('id');
        $party = BookParty::where('id',$id)->delete();
        return RJM(0,$party);
    }

//    选择一个读书会并显示其详细信息
    public function select($id){

        $party = BookParty::where('id',$id)->first();
        return RJM(0,$party);
    }

//    显示指定读书会的报名人员
    public function showSignUp($id){
        $users= DB::table('users')
            ->join('book_party_signup',function ($join) use ($id){
                $join->on('users.id','=','book_party_signup.uid')
                    ->where('book_party_signup.book_party_id','=',$id);
            })->get();
        $data = [];
        foreach ($users as $user){
            $institute = DB::table('institutes')
                ->where('id',$user->institute_id)
                ->select('name')
                ->first();
            $data [] = array(
                'sid' => $user->sid,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'institute' => $institute->name
            );

        }

        return RJM(0,['user'=>$data]);
    }

//    更新读书会内容
    public function update(Request $request){

        $params = $request->all();
        BookParty::where('id',$params['id'])
            ->update(['title'=>$params['title'],
                    'speaker'=>$params['speaker'],
                    'place' =>$params['place'],
                    'start_time'=>$params['startTime'],
                    'summary'=>$params['summary'],
                    'max_user'=>$params['maxUser'],
                    'checkin_code'=>$params['checkinCode']]);
        return RJM(0,"更新成功");

    }
}
