<?php

namespace App\Http\Controllers\Api02;
use Symfony\Component\HttpFoundation\Response;
//use App\Http\Controllers\Api\V1\Admin\UsersApiController;
use Notification;
use App\Notifications\FirebaseNotification;
use App\Firebasetoken;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;
use App\User;

use App\MenuDetail;
class CanteenController extends Controller
{
    public function getMenu(Request $request){
        $menu =  Menu::latest('id')->first();
        if($menu!=null){
        $menuDetail = MenuDetail::all()->where('menu_id',"=",$menu->id);
        $list =collect();
        foreach ($menuDetail as $items) {
            $list->push(asset('storage/image/' . $items->filename));
        }
        return response()->json([
            "status"=>200,
            "daa"=>$menuDetail,
            "image"=>$list
        ],);
        }else{
            return response()->json([
            "status"=>400,
            "image"=>"Not fount menu today"
            ],);
        }
    }
}