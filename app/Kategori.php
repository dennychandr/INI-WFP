<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';

    public function subkategori()
    {
    		return $this->hasMany('App\Subkategori');
    }

    public function transaksi()
    {
    	return $this->hasMany('App\Transaksi');
    }

}
