<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //protected $table = 'tickets';
    
    public function turns(){

        return $this->belongsToMany('App\Turn','ticket_turn')->withPivot('turn_status')->withTimestamps();;

    }
    public function users(){

    	return $this->hasMany('App\User', 'id');

    }
}
