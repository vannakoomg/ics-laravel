<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TrackMenuMobile;
use App\User;
use Carbon\Carbon;

use DB;
use DateTime;

class TrackMenuMobileController extends Controller
{
    public function index(Request $request){

    
    $chart =collect();
    $fromDate =  Carbon::now()->subDays(7)->startOfDay();
    $endDate=   Carbon::now()->endOfDay();     ;
    $allMenuNames =["announcement","attendance_calendar","timetable","exam_schedule","student_report","events",
                "gallary","homeworks","class_results","pick_up_card","e_learning",
                "feedback","canteen","about us","contact us","profile","notification"
        ];
    if($request->end_date==null){
        if($request->from_date!=null){
            $fromDate =  Carbon::parse($request->from_date)->format('Y-m');
        }
        $records = TrackMenuMobile::whereBetween('created_at', [$fromDate, $endDate])
                ->selectRaw('menu_name, COUNT(*) as count')
                ->groupBy('menu_name')
                ->get();
        $track= TrackMenuMobile::whereBetween('created_at', [$fromDate, $endDate])->get()->sortDesc();
        $mc = TrackMenuMobile::where('campus',"=","MC")->whereBetween('created_at', [$fromDate, $endDate])->count();
        $cc = TrackMenuMobile::where('campus',"=","CC")->whereBetween('created_at', [$fromDate, $endDate])->count();
    }
    else{
        $request->validate([
            'from_date' => 'date',
            'end_date' => 'date|after_or_equal:from_date',
        ]);
        $fromDate = $request->from_date;
        $endDate= $request->end_date;
        $records = TrackMenuMobile::whereBetween('created_at', [$request->from_date, $request->end_date])->selectRaw('menu_name, COUNT(*) as count')
        ->groupBy('menu_name')
        ->get();
        $track = TrackMenuMobile::whereBetween('created_at', [$request->from_date, $request->end_date])->get()->sortDesc();
        $mc = TrackMenuMobile::where('campus',"=","MC")->whereBetween('created_at', [$request->from_date, $request->end_date])->count();
        $cc = TrackMenuMobile::where('campus',"=","CC")->whereBetween('created_at', [$request->from_date, $request->end_date])->count();
    }
    $done =0;
    foreach($allMenuNames as $value){
        $done=0;
        foreach($records as $record){
            if($record["menu_name"]===$value){
                $chart->put($record["menu_name"],$record["count"]);
                $done =1;
            }
        }
        if($done==0){
            $chart->put($value,0);
        }
    }
    $chart->put("cc",$cc);
    $chart->put("mc",$mc);
    foreach($track as $index=>$t){
    $user =User::where('email' ,"=",$t->user_name)->get()->first();
        $track[$index]->name =  $user->name;
    }
    return view('admin.tracking.index',compact('chart','track','fromDate','endDate'));
    }
}