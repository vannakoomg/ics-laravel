<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EventsType;

class EventTypeController extends Controller
{
    public $colors = [
    '#0F2866','#0F3992','#628AEE','#269195','#398D6E','#6b9080',
    '#8E6F00','#8B4406','#7B0B0E','#9e2a2b','#e09f3e','#DBC95F',
    '#f08080','#E8917D','#EDB787','#7EC3E1','#8da9c4','#598392',
];
    public function index(){
    $eventsType = EventsType::all();
    return view('admin.eventType.index',compact('eventsType'));
    }
    public function store(Request $request){
        $input = $request->all();
        EventsType::create($input);
            $eventsType = EventsType::all();

        return view('admin.eventType.index',compact('eventsType'));
    }
    public function update(Request $request, $id){
       $eventsType = EventsType::find($id);
       $data = array(
        "name"=>$request->name,
        "color"=>"$request->color"
       );
       $eventsType->update($data);
      return redirect('admin/events/type');   
    }
    public function edit(Request $request){
    $colors= $this->colors;
        $eventsType = EventsType::find($request->id);
        return view('admin.eventType.edit', compact('eventsType',"colors"));
    }
    public function destroy (Request $request){
        $eventType = EventsType::find( $request->id);
        $eventType->delete();
         return redirect('admin/events/type');   
    }
    public function show(){
      $colors= $this->colors;
      return view('admin.eventType.create',compact('colors'));
    }
}