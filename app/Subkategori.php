<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subkategori extends Model
{

	protected $table = 'subkategoris';

    public function Kategori()
    {
    	return $this->belongsTo('App\Kategori','kategori_id');
    }
}
