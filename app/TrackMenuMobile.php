<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackMenuMobile extends Model
{
    use HasFactory;
    public $table = 'track_menu_mobile';
    protected $fillable = [
        'menu_name',
        'user_name',
        'campus',
    ];
}