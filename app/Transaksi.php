<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    public function kategori()
    {
    	return $this->belongsTo('App\Kategori', 'kategori_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function subkategori()
    {
    	return $this->belongsTo('App\Subkategori', 'subkategori_id');	
    }
}
