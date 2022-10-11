<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    //protected $table = 'turns';

    public function clients(){

    	return $this->belongsTo('App\Client', 'client_id');

    }

    public function tickets(){

    	return $this->belongsToMany('App\Ticket','ticket_turn')->withPivot('turn_status')->withTimestamps();;

    }
}
