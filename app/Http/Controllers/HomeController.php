<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Kategori;
use DB;
use App\Transaksi;
use Carbon\Carbon;

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

        $transaksi = Transaksi::where('user_id',$id)
        ->whereMonth('created_at',Carbon::now('Asia/Bangkok')->month)
        ->orderBy('created_at','DESC')
        ->get();


        


        // $pemasukan_hari_ini = Transaksi::where('user_id',$id)
        // ->where('jenis_transaksi', 'pemasukan')->get();
        // // ->where('created_at', '=', date('now'))->get();
        // // ->select(DB::raw("SUM(nominal) as pemasukan"))->get();
        // dd($pemasukan_hari_ini);

        // $pengeluaran_hari_ini = Transaksi::where('user_id',$id)
        // ->where('jenis_transaksi', '=', 'pengeluaran')
        // ->where('created_at', '=', date('now'))
        // ->select(DB::raw("SUM(nominal) as pengeluaran"))->get();


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

        
       
        

        


        $pemasukan_hari_ini = DB::table('transaksis')
            ->where('user_id', '=', $id)
            ->whereDate('created_at', '=', Carbon::now('Asia/Bangkok')->toDateString())
            ->where('jenis_transaksi', '=' , 'pemasukan')
            ->sum('nominal');
            

         $pengeluaran_hari_ini = DB::table('transaksis')
        ->where('user_id', '=', $id)
        ->whereDate('created_at', '=', Carbon::now('Asia/Bangkok')->toDateString())
        ->where('jenis_transaksi', '=' , 'pengeluaran')
        ->sum('nominal');


            





        // $subkategoripemasukan = Subkategori::where()
        // ->get();

        // $subkategoripengeluaran = Subkategori::where()
        // ->get();



        $user = User::where('id', $id)
        ->get();

        // $pemasukan = DB::select();





       
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
                return view('dashboard', compact('kategoripemasukan','kategoripengeluaran', 'transaksi','pemasukan_hari_ini', 'pengeluaran_hari_ini'));
            }
       }  
    }
}
