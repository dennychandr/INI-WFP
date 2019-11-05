<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Kategori;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  

    // $datapersen = [];
        
        
       $id = Auth::user()->id;
       // $kategori_id_pemasukan = [];
       // $kategori_id_pengeluaran = [];

       $kategoripemasukan = Kategori::where('user_id',$id)
       ->where('jenis_kategori', 'pemasukan')
        ->get();

        $kategoripengeluaran = Kategori::where('user_id',$id)
        ->where('jenis_kategori', 'pengeluaran')
        ->get();



        // foreach($kategoripemasukan as $kpemasukan)
        // {
        //     $kategori_id = $kpemasukan->id;
        //     array_push($kid,$kategori_id);
        // }

        // foreach($kategoripengeluaran as $kpengeluaran)
        // {
        //     $kategori_id = $kpengeluaran->id;
        //     array_push($kid,$kategori_id);
        // }





        // $subkategoripemasukan = Subkategori::where()
        // ->get();

        // $subkategoripengeluaran = Subkategori::where()
        // ->get();



        $user = User::where('id', $id)
        ->get();

       
       foreach($user as $u)
       {
            if($u->firstlogin == 1)
            {
                $updateID =  User::find($id);
                $updateID->firstlogin= 0;
                $updateID->save();
                return redirect()->route('konfigurasi');
            }
            else
            {
                return view('dashboard', compact('kategoripemasukan','kategoripengeluaran'));
            }
       }  
    }
}
