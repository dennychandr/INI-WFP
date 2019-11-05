<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TabunganBerencana extends Model
{
    protected $table = 'tabunganberencanas';

   
    	public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
    
}
