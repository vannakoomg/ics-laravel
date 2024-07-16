<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuDetail extends Model
{
    use HasFactory;
    public $table = 'menu_detail';
    protected $fillable = [
        'menu_id',
        'filename',
    ];
    public function getFullImageAttribute(){
        return asset('storage/image/' .     $this->filename);
    }
}