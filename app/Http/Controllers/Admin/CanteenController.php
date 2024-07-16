<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Menu;
use App\MenuDetail;
use Notification;
use App\Notifications\FirebaseNotification;
use App\Firebasetoken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class CanteenController extends Controller
{
    public function index(Request $request){
        if($request->chk_show=="on")
            $menu  = Menu::where('send','0')->orderBy('created_at','DESC')->get();
        else 
            $menu  = Menu::where('send','0')->orderBy('created_at','DESC')->get();
        return view('admin.canteen.index',compact('menu'));
    }
    public function create(){
        return view('admin.canteen.create');
    }
    public function edit(Request $request){
        $menu = Menu::find($request->id);
        return view('admin.canteen.edit',compact("menu"));
    }
    public function initPhoto(Request $request){
        $menuDetail = MenuDetail::all()->where('menu_id','=',$request->id);
        return $menuDetail;
    }
    public function destroyMenu($id){
        $menu = Menu::find($id);
        if( $menu!=null){
        $menu->delete();
        $menuDetail = MenuDetail::all()->where("menu_id","=",$id);
        foreach ($menuDetail as $value) {
            Storage::delete(['image/' . $value->filename]);
        }    
        MenuDetail::destroy($menuDetail);
        return redirect('admin/canteen'); 
    }
    }
    public function update(Request $request ,$id){
        $menu = Menu::find($id);
        $menu->menu_date= $request->menu_date;
        $menu->send= ($request->save_send=='send')?1:0;
        $menu->save();
        if(!empty($request->file('file'))){
        $data = $request->file('file');
        foreach ($data as $files) {
        $filename = "image-".time().'.'.$files->getClientOriginalName();
        $files->storeAs('image',$filename);
        MenuDetail::create([
            'filename' => $filename,
            "menu_id"=>"$id",
            ]);
        }
        }
        // if($request->save_send=='send'){
        // $token =DB::table('firebasetoken_user')
        //     ->join("users","firebasetoken_user.user_id","=","users.id")
        //     ->where("mute_canteen","=",1)
        //     ->join("firebasetokens","firebasetoken_user.firebasetoken_id","=","firebasetokens.id")
        //     ->pluck("firebasetokens.firebasekey")
        //     ->toArray();
        // Notification::send(Auth()->user(),new FirebaseNotification("ICS","a",$token,'Menu Today Is Coming',"ICS01"),); 
        // }
        return redirect('admin/canteen'); 
    }
    public function destroy(Request $request ){
        $menuDetail = MenuDetail::find($request->id);
        Storage::delete(['image/' . $menuDetail->filename]);

        $menuDetail->delete();  
    }

    public function store(Request $request) {            
        $messages = [
        'file.*' => 'Please Upload Image Photo Menu !!!!!',
        ];
        request()->validate([
            'file' => 'required',
        ],$messages);
        $data = array(
            "user_name"=>auth()->user()->name,
            "name"=>$request->title,
            "menu_date"=>$request->menu_date,
            'send' => ($request->save_send=='send')?1:0,
        );
        Menu::create($data);
        $lastId=  Menu::latest('id')->first(); 
        $data = $request->file('file');
        foreach ($data as $files) {
        $filename = "image-".time().'.'.$files->getClientOriginalName();
        $image = \Image::make(file_get_contents($files));
        $image->save(\storage_path('app/public/image/'.$filename),"15");
        MenuDetail::create([
            'filename' => $filename,
            "menu_id"=>$lastId->id,
        ]);
        }
        // if($request->save_send=='send'){
        // $token =DB::table('firebasetoken_user')
        //     ->join("users","firebasetoken_user.user_id","=","users.id")
        //     ->where("mute_canteen","=","1")
        //     ->join("firebasetokens","firebasetoken_user.firebasetoken_id","=","firebasetokens.id")
        //     ->pluck("firebasetokens.firebasekey")
        //     ->toArray();
        // Notification::send(Auth()->user(),new FirebaseNotification(count($token),"",$token,'Menu Today Is Coming',""),); 
        // }
    }
}