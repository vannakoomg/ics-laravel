<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsType extends Model
{
    use HasFactory;
    public $table = 'event_type';
    protected $fillable = [
        'name',
        'color',
    ];
    public function events(){
        return $this->hasMany(Event::class,"action","id");
    }
}