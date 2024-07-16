<?php

namespace App\Http\Controllers\Admin;
use App\SchoolClass;
use App\User;
use App\Homework;
use App\HomeworkResult;
use App\Firebasetoken;
use auth;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $classes = User::find(auth()->user()->id)->classteacher()->get();
        $firebaseToken =  Firebasetoken::count();
        $userCCNo = DB::table('users')
            ->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftjoin('school_classes', 'users.class_id', '=', 'school_classes.id')
            ->where('role_user.role_id','=','4')
            ->where('users.remember_token','=',null)
            ->where('school_classes.campus','=','CC')
            ->count();
         $userMCNo = DB::table('users')
            ->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftjoin('school_classes', 'users.class_id', '=', 'school_classes.id')
            ->where('role_user.role_id','=','4')
            ->where('users.remember_token','=',null)
            ->where('school_classes.campus','=','MC')
            ->count();
        
        $assign_returns = Homeworkresult::whereHas('homework', function($q){
                            $q->where('user_id',auth()->user()->id)->where('completed',0);
                          })->where('turnedin',1)->get();
        $data = [
            'unpublish' => Homework::where('user_id',auth()->user()->id)
        ->where('submitted',0)->orderBy('created_at','desc')->get(),
             'publish' => Homework::where('user_id',auth()->user()->id)
        ->where('submitted',1)->where('completed',0)->orderBy('created_at','desc')->get()
        ];
        return view('home',compact('classes','data','assign_returns' , 'firebaseToken','userCCNo','userMCNo'));
    }
    public function show($campus){
        $cam = $campus;
        $user = DB::table('users')
            ->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftjoin('school_classes', 'users.class_id', '=', 'school_classes.id')
            ->where('role_user.role_id','=','4')
            ->where('users.remember_token','=',null)
            ->where('school_classes.campus','=',$campus)
            ->select('users.email','users.name','users.namekh','school_classes.name as class_name')
            ->get();
        return view('admin.home.show',compact('user','cam'));
    
    }

    

}