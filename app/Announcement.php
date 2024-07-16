<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    use HasFactory;

    protected $table='announcement';

  //  protected $appends = ['full_image','date','time'];
 protected $appends = ['date','time'];
      protected $dates = [
        'created_at',
        'updated_at',
    ];

        protected $fillable = [
        'user_id',
        'title',
        'body',
        'thumbnail',
        'send',
        'view',
        ];

    public function getTimeAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('h:i A') : null;
    }   


    public function getDateAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('d-M-Y') : null;
    }

    public function classes(){
        return $this->belongsToMany(SchoolClass::class, 'announcement_class');
    }


//    public function getBodyAttribute($value){
  //  	return 'ddd';
    //}

    public function getPostedByAttribute(){
        return User::find($this->user_id)->name;
    }
/*
    public function getFullImageAttribute(){
        return asset('storage/thumbnail/' . $this->thumbnail);
    }
 */

    public function getUpdatedAtAttribute($value){
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

}