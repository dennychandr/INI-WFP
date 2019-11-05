<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','firstlogin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function transaksi()
    {
        return $this->hasMany('App\Transaksi');
    }

    public function kategori()
    {
        return $this->hasMany('App\Kategori');
    }

    public function tabunganberencana()
    {
        return $this->hasMany('App/TabunganBerencana');
    }

    
}
