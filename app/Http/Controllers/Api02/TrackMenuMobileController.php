<?php

namespace App\Http\Controllers\Api02;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TrackMenuMobile;
class TrackMenuMobileController extends Controller
{
    public function create(Request $response){
        try {
        $track = TrackMenuMobile::create($response->all());
        return response()->json([
        "massage"=>"done",
        "data"=>$track
        ]);  
        }  
        catch (Throwable $e) {
        return response()->json([
        "massage"=>" you have been catched $e",
        ]);
    }
    }
 public function truncateTable()
    {
        TrackMenuMobile::truncate();
        return response()->json(['message' => 'Table  Event Type and Events truncated successfully']);
    } 
}