<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Kategori;
use App\Subkategori;
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


    public function filterdate(Request $request)
    {
        $id = Auth::user()->id;

        $kategoripemasukan = Kategori::where('user_id',$id)
       ->where('jenis_kategori', 'pemasukan')
        ->get();

        $kategoripengeluaran = Kategori::where('user_id',$id)
        ->where('jenis_kategori', 'pengeluaran')
        ->get();

        $arr_sub_pem = [];
        for ($i=0; $i < count($kategoripemasukan); $i++) { 
            $subkatee = Subkategori::where('kategori_id',$kategoripemasukan[$i]->id)
            ->get();
            for ($j=0; $j <count($subkatee) ; $j++) { 
                $count = count($arr_sub_pem);
               $arr_sub_pem[$count][0] = $subkatee[$j]->nama;
               $arr_sub_pem[$count][1] = $kategoripemasukan[$i]->nama;
            }            
        }




        $arr_sub_peng = [];
        for ($i=0; $i < count($kategoripengeluaran); $i++) { 
            $subkate = Subkategori::where('kategori_id',$kategoripengeluaran[$i]->id)
            ->get();
            for ($j=0; $j <count($subkate) ; $j++) { 
                $count = count($arr_sub_peng);
               $arr_sub_peng[$count][0] = $subkate[$j]->nama;
               $arr_sub_peng[$count][1] = $kategoripengeluaran[$i]->nama;
            }            
        }

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

        $bln;
        if($request->get('bulan') == 1)
        {
            $bln = 'Januari';
        }
        else if($request->get('bulan') == 2)
        {
            $bln = 'Februari';
        }
        else if($request->get('bulan') == 3)
        {
            $bln = 'Maret';
        }
        else if($request->get('bulan') == 4)
        {
            $bln = 'April';
        }
        else if($request->get('bulan') == 5)
        {
            $bln = 'Mei';
        }
        else if($request->get('bulan') == 6)
        {
            $bln = 'Juni';
        }
        else if($request->get('bulan') == 7)
        {
            $bln = 'Juli';
        }
        else if($request->get('bulan') == 8)
        {
            $bln = 'Agustus';
        }
        else if($request->get('bulan') == 9)
        {
            $bln = 'September';
        }
        else if($request->get('bulan') == 10)
        {
            $bln = 'Oktober';
        }
        else if($request->get('bulan') == 11)
        {
            $bln = 'November';
        }
        else if($request->get('bulan') == 12)
        {
            $bln = 'Desember';
        }


        if($request->get('terapkan') == 'terapkan_bln_thn')
        {
            $transaksi = Transaksi::where('user_id',$id)
            ->whereMonth('created_at',$request->get('bulan'))
            ->whereYear('created_at',$request->get('tahun'))
            ->orderBy('created_at','DESC')
            ->get();
            $string = 'Daftar Transaksi Bulan ' . $bln . ' Tahun ' . $request->get('tahun') . ' :';
        }
        else if ($request->get('terapkan') == 'terapkan_thn')
        {
            $transaksi = Transaksi::where('user_id',$id)
            ->whereYear('created_at',$request->get('tahun'))
            ->orderBy('created_at','DESC')
            ->get();
            $string = 'Daftar Transaksi Tahun ' . $request->get('tahun') . ' :';
        }

         $totalcount = $transaksi->count();

             $page = $request->input('page') ?:1;
              if ($page) {
                  $skip = 5 * ($page - 1);
                  $transaksi = $transaksi->take(5+$skip)->slice($skip);

                  // dd($laporan);
              } else {
                  $transaksi = $transaksi->take(5)->slice(0);
              }

        $parameters = $request->getQueryString();
                $parameters = preg_replace('/&page(=[^&]*)?|^page(=[^&]*)?&?/','', $parameters);
                $path = url('/') . '/dashboard?' . $parameters;

                // dd($path);

                $categories = $transaksi->toArray();

                

                $paginator = new \Illuminate\Pagination\LengthAwarePaginator($categories, $totalcount, 5, $page);

                $paginator = $paginator->withPath($path);

    return view('dashboard', compact('kategoripemasukan','kategoripengeluaran', 'transaksi','pemasukan_hari_ini', 'pengeluaran_hari_ini','string','arr_sub_peng','arr_sub_pem','paginator'));
        

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

        $arr_sub_pem = [];
        for ($i=0; $i < count($kategoripemasukan); $i++) { 
            $subkatee = Subkategori::where('kategori_id',$kategoripemasukan[$i]->id)
            ->get();
            for ($j=0; $j <count($subkatee) ; $j++) { 
                $count = count($arr_sub_pem);
               $arr_sub_pem[$count][0] = $subkatee[$j]->nama;
               $arr_sub_pem[$count][1] = $kategoripemasukan[$i]->nama;
                $arr_sub_pem[$count][2] = $subkatee[$j]->id;

            }            
        }




        $arr_sub_peng = [];
        for ($i=0; $i < count($kategoripengeluaran); $i++) { 
            $subkate = Subkategori::where('kategori_id',$kategoripengeluaran[$i]->id)
            ->get();
            for ($j=0; $j <count($subkate) ; $j++) { 
                $count = count($arr_sub_peng);
               $arr_sub_peng[$count][0] = $subkate[$j]->nama;
               $arr_sub_peng[$count][1] = $kategoripengeluaran[$i]->nama;
               $arr_sub_peng[$count][2] = $subkate[$j]->id;
            }            
        }
// dd($arr_sub_pem);

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



        $string = 'Daftar Transaksi';

         $totalcount = $transaksi->count();

             $page = $request->input('page') ?:1;
              if ($page) {
                  $skip = 5 * ($page - 1);
                  $transaksi = $transaksi->take(5+$skip)->slice($skip);

                  // dd($laporan);
              } else {
                  $transaksi = $transaksi->take(5)->slice(0);
              }


        $parameters = $request->getQueryString();
                $parameters = preg_replace('/&page(=[^&]*)?|^page(=[^&]*)?&?/','', $parameters);
                $path = url('/') . '/dashboard?' . $parameters;

                // dd($path);

                $categories = $transaksi->toArray();

                

                $paginator = new \Illuminate\Pagination\LengthAwarePaginator($categories, $totalcount, 5, $page);

                $paginator = $paginator->withPath($path);

       
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
                return view('dashboard', compact('kategoripemasukan','kategoripengeluaran', 'transaksi','pemasukan_hari_ini', 'pengeluaran_hari_ini','string','arr_sub_peng','arr_sub_pem','paginator'));
            }
       }  
    }
}
