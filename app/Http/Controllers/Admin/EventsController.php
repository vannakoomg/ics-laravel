<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use DateTime;
use Illuminate\Support\Facades\DB;

use App\EventsType;
use App\Http\Resources\EventResource;


class EventsController extends Controller
{
    public function index(){
      return view('admin.events.index');
    }
    public function show(){
      $eventsType =  EventsType::all();
      return view('admin.events.create', compact('eventsType'));
    }
    public function getEvent(){
      $data = DB::table('events')
              ->select('events.id','title','start','end','time','color')
              ->join('event_type','events.event_type_id','=','event_type.id')
              ->get();
      return $data;
    }
    public function store(Request $request){
      $request->validate([
      'startdate' => 'required|date',
      'end_date' => 'required|date|after_or_equal:startdate',
      ]);
        $end  = new DateTime($request->end_date);
        $end= $end->modify('+1 day' );
        $endString= $end->format('Y-m-d');
        $data = array(
                'title' => $request->title,
                'start' => $request->startdate,
                'end' => $endString,
                'time' => $request->time??"",
                'event_type_id' => $request->event_type_id,
                'create_owner'=>auth()->user()->name
            );
        $value=  Event::create($data);
        return redirect('admin/events');      
    }
    public function destroy($id){
      $result = Event::find($id);
      $result->delete();
      return redirect('admin/events');      
    }
    public function edit(Request $request){
      $event= Event::find($request->id);
      $eventsType = EventsType::all();
      $endddd  = new DateTime($event->end);
      $endddd= $endddd->modify('-1 day' )->format('Y-m-d');
      return view('admin.events.edit', compact('eventsType',"event","endddd"));
    }
    public function update(Request $request){
      $request->validate([
      'startdate' => 'required|date',
      'end_date' => 'required|date|after_or_equal:startdate',
      ]);
      $event  = Event::find($request->id);
        $end  = new DateTime($request->end_date);
        $end= $end->modify('+1 day' );
        $event->update([
        "title"=>$request->title,
        "start"=>$request->startdate,
        "end"=> $end, 
        "event_type_id"=>$request->event_type_id+1,
        "time"=>$request->time??"",
      ]);  
      return redirect('admin/events');  
    }    
}