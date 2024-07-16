<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'start',
        'end',
        'event_type_id',
        'time',
        'create_owner'
    ];
    public function eventType(){
        return $this->belongsTo(EventsType::class,"event_type_id","id");
    }
}