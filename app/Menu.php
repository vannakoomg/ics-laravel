<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    public $table = 'menu';
    protected $fillable = [
        'menu_date',
        'user_name',
        'send',
    ];
}