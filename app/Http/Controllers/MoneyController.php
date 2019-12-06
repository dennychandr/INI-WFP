<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Kategori;
use App\Subkategori;
use App\TabunganBerencana;
use App\Transaksi;
use PDF;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\User;
use DB;


class MoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



    }

    public function laporanpengeluaranpemasukan(Request $request)
    {
        $id = Auth::user()->id;
        $data = DB::table('transaksis')
        ->select(
            DB::raw('jenis_transaksi as jenis'),
            DB::raw('sum(nominal) as nominal'))

        ->whereBetween('created_at',[date("Y-m-d",strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date) - strtotime("now") + strtotime("+1 day"))])
        ->where('user_id',$id)
        ->groupBy('jenis_transaksi')
        ->get();


        $array[] = ['Jenis','Nominal'];

        foreach($data as $key => $value)
        {

            $array[++$key] = [strtoupper($value->jenis), intval($value->nominal)];
        }

        // dd($array);


       return view('laporanpemasukanpengeluaran')->with('chart', json_encode($array));



    }

    public function laporantrendpemasukan(Request $request)
    {

        $id = Auth::user()->id;

        $datanosub = DB::table('transaksis as t')
        ->join('kategoris as k', 'k.id', '=', 't.kategori_id')
        ->select(
            DB::raw('k.nama as kategori'),
            DB::raw('sum(t.nominal) as nominal'))
        ->whereBetween('t.created_at',[date("Y-m-d",strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date) - strtotime("now") + strtotime("+1 day"))])
        ->where('t.user_id',$id)
        ->where('k.user_id', $id)
        ->where('t.jenis_transaksi', 'pemasukan')
        ->where('t.subkategori_id','=',null)
        ->groupBy('kategori')
        ->get();

        // dd($datanosub);

        $data = DB::table('transaksis as t')
        ->join('kategoris as k', 'k.id', '=', 't.kategori_id')
        ->join('subkategoris as s', 's.id','=','t.subkategori_id')
        ->select(
            DB::raw('k.nama as kategori,s.nama as subkategori'),
            DB::raw('sum(t.nominal) as nominal'))
        ->whereBetween('t.created_at',[date("Y-m-d",strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date) - strtotime("now") + strtotime("+1 day"))])
        ->where('t.user_id',$id)
        ->where('k.user_id', $id)
        ->where('t.jenis_transaksi', 'pemasukan')
        ->groupBy('kategori','subkategori')
        ->get();

        // dd($data);


        


        $datanull = DB::table('transaksis')
        ->select(
            DB::raw('kategori_id as kategori'),
            DB::raw('sum(nominal) as nominal'))
        ->whereBetween('created_at',[date("Y-m-d",strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date) - strtotime("now") + strtotime("+1 day"))])
        ->where('user_id',$id)
        ->where('kategori_id', '=', null)
        ->where('jenis_transaksi', 'pemasukan')
        ->groupBy('kategori')
        ->get(); 

      


        $array[] = ['Kategori','Nominal'];

        $key = 0;

        foreach($data as $key => $value)
        {
            $subkat  = $value->kategori." - ".$value->subkategori;
            $array[++$key] = [$subkat, intval($value->nominal)];
        }

        

        

        foreach($datanull as $value)
        {
            $array[++$key] = ["Kategori Lain", intval($value->nominal)];
        }

        foreach($datanosub as $value)
        {
            $array[++$key] = [$value->kategori, intval($value->nominal)];
        }


        // dd($array);

        


       return view('laporantrendpemasukan')->with('chart', json_encode($array));

    }


    public function laporantrendpengeluaran(Request $request)
    {
        $id = Auth::user()->id;


            $datanosub = DB::table('transaksis as t')
        ->join('kategoris as k', 'k.id', '=', 't.kategori_id')
        ->select(
            DB::raw('k.nama as kategori'),
            DB::raw('sum(t.nominal) as nominal'))
        ->whereBetween('t.created_at',[date("Y-m-d",strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date) - strtotime("now") + strtotime("+1 day"))])
        ->where('t.user_id',$id)
        ->where('k.user_id', $id)
        ->where('t.jenis_transaksi', 'pengeluaran')
        ->where('t.subkategori_id','=',null)
        ->groupBy('kategori')
        ->get();


        $data = DB::table('transaksis as t')
        ->join('kategoris as k', 'k.id', '=', 't.kategori_id')
         ->join('subkategoris as s', 's.id','=','t.subkategori_id')
        ->select(
            DB::raw('k.nama as kategori,s.nama as subkategori'),
            DB::raw('sum(t.nominal) as nominal'))
        ->whereBetween('t.created_at',[date("Y-m-d",strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date) - strtotime("now") + strtotime("+1 day"))])
        ->where('t.user_id',$id)
        ->where('k.user_id', $id)
        ->where('t.jenis_transaksi', 'pengeluaran')
        ->groupBy('kategori','subkategori')
        ->get();


        $datanull = DB::table('transaksis')
        ->select(
            DB::raw('kategori_id as kategori'),
            DB::raw('sum(nominal) as nominal'))
        ->whereBetween('created_at',[date("Y-m-d",strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date) - strtotime("now") + strtotime("+1 day"))])
        ->where('user_id',$id)
        ->where('kategori_id', '=', null)
        ->where('jenis_transaksi', 'pengeluaran')
        ->groupBy('kategori')
        ->get();

      


        $array[] = ['Kategori','Nominal'];

        $key = 0;

        foreach($data as $key => $value)
        {
            $subkat  = $value->kategori." - ".$value->subkategori;
            $array[++$key] = [$subkat, intval($value->nominal)];
        }

        // dd($array);

        

        foreach($datanull as $value)
        {
            $array[++$key] = ["Kategori Lain", intval($value->nominal)];
        }

          foreach($datanosub as $value)
        {
            $array[++$key] = [$value->kategori, intval($value->nominal)];
        }


        


       return view('laporantrendpengeluaran')->with('chart', json_encode($array));
    }


    public function config()
    {
        $id = Auth::user()->id;

        $kategoripemasukan = Kategori::where('user_id', $id)
        ->where('jenis_kategori','pemasukan')
        ->get();

        $kategoripengeluaran =  Kategori::where('user_id', $id)
        ->where('jenis_kategori','pengeluaran')
        ->get();


        $reminder = User::find($id);

        $saldo = Auth::user()->saldo;

        return view('konfigurasi', compact('kategoripemasukan','kategoripengeluaran', 'saldo', 'reminder'));
    }


    public function subkategori($id)
    {
        $subkategori = Subkategori::where('kategori_id', $id)->paginate(3);

        $kategori = Kategori::find($id);
        

        return view('subkategori', compact('subkategori','kategori'));
    }




    public function laporan()
    {
        return view('laporan');
    }

    public function tabunganberencana()
    {   
        $datapersen = [];
        $id = Auth::user()->id;
        $tabunganberencana = TabunganBerencana::where('user_id', $id)
        ->get();

        foreach($tabunganberencana as $tb)
        {
            $nominal = $tb->nominal_sekarang;
            $target  = $tb->target;
            $percentage = $nominal / $target * 100;
            array_push($datapersen,$percentage);
        }

        return view('tabunganberencana', compact('tabunganberencana','datapersen'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storekategoripemasukan(Request $request)
    {
        $id = Auth::user()->id;
        $newKategoriPemasukan = new Kategori;
        $newKategoriPemasukan->nama= $request->get('kategoripemasukan');
        $newKategoriPemasukan->user_id= $id;
        $newKategoriPemasukan->jenis_kategori= 'pemasukan';

        $newKategoriPemasukan->save();

        return redirect('konfigurasi');
    }

    public function storekategoripengeluaran(Request $request)
    {
        $id = Auth::user()->id;
        $newKategoriPengeluaran = new Kategori;
        $newKategoriPengeluaran->nama= $request->get('kategoripengeluaran');
        $newKategoriPengeluaran->user_id= $id;
        $newKategoriPengeluaran->jenis_kategori= 'pengeluaran';
        $newKategoriPengeluaran->save();

        return redirect('konfigurasi');
    }


 public function storesubkategori(Request $request, $id)
    {
        
        $newSubKategoriPemasukan = new Subkategori;
        $newSubKategoriPemasukan->nama= $request->get('subkategori');
        $newSubKategoriPemasukan->kategori_id= $id;
        $newSubKategoriPemasukan->save();

        return redirect('/konfigurasi/subkategori/'.$id);
    }

    public function storetabunganberencana(Request $request)
    {
        $id = Auth::user()->id;
        $newTabunganBerencana = new TabunganBerencana;
        $newTabunganBerencana->nama= $request->get('namatarget');
        $newTabunganBerencana->target= $request->get('targettabungan');
        $newTabunganBerencana->user_id = $id;
        $newTabunganBerencana->save();

        return redirect('/tabunganberencana');
    }

    public function storetransaksipemasukan(Request $request)
    {
        $id = Auth::user()->id;
        $saldo = Auth::user()->saldo;
     
       
        	$explode = explode("-",$request->kategori);
        	if(count($explode) > 1)
        	{
        		   $kate = (int)$explode[0];
        		   $sub = (int)$explode[1];

        		    $dbsub = DB::table('subkategoris')
                ->where('id', '=', $sub)
                ->where('kategori_id','=',$kate)
                ->get();

                if($request->hasFile('uploadfoto'))
        {

            $file = $request->file('uploadfoto');
            $nama_file = $file->getClientOriginalName();
            $target_directory = 'images';
            $file->move($target_directory,$nama_file); 



            $TransaksiPemasukan = new Transaksi;
            $TransaksiPemasukan->keterangan= $request->get('keterangan');
            $TransaksiPemasukan->nominal = $request->get('nominal');
            $TransaksiPemasukan->jenis_transaksi = 'pemasukan';
            $TransaksiPemasukan->user_id= $id;
            
            if($dbsub->isEmpty())
            {
                $TransaksiPemasukan->kategori_id = $request->get('kategori'); 
            }
            else
            {
                $TransaksiPemasukan->subkategori_id = $dbsub[0]->id;
                $TransaksiPemasukan->kategori_id = $dbsub[0]->kategori_id;
            }
            $TransaksiPemasukan->foto = $nama_file;
            $TransaksiPemasukan->save();
         }
        else
        {
            $TransaksiPemasukan = new Transaksi;
            $TransaksiPemasukan->keterangan= $request->get('keterangan');
            $TransaksiPemasukan->nominal = $request->get('nominal');
            $TransaksiPemasukan->jenis_transaksi = 'pemasukan';
            $TransaksiPemasukan->user_id= $id;
            $TransaksiPemasukan->foto = null;

            if($dbsub->isEmpty())
            {
                $TransaksiPemasukan->kategori_id = $request->get('kategori'); 
            }
            else
            {
                $TransaksiPemasukan->subkategori_id = $dbsub[0]->id;
                $TransaksiPemasukan->kategori_id = $dbsub[0]->kategori_id;
            }
            $TransaksiPemasukan->save();
        }

            $saldoskg = $saldo + $TransaksiPemasukan->nominal;
            $saldoo = User::find($id);
            $saldoo->saldo = $saldoskg;
            $saldoo->save();

             $user = User::find($id);
            $user->jumlahtransaksi = $user->jumlahtransaksi + 1;
            $user->save();

            if($user->jumlahtransaksi % $user->reminder == 0)
            {
                session()->flash('menabung', Auth::user()->pesanreminder);
            }    

            return redirect('dashboard');



        	}
        	else
        	{
        			$kate = (int)$explode[0];
        			$sub = 0;

        			 $dbsub = DB::table('subkategoris')
                ->where('id', '=', $sub)
                ->where('kategori_id','=',$kate)
                ->get();

                if($request->hasFile('uploadfoto'))
        {

            $file = $request->file('uploadfoto');
            $nama_file = $file->getClientOriginalName();
            $target_directory = 'images';
            $file->move($target_directory,$nama_file); 



            $TransaksiPemasukan = new Transaksi;
            $TransaksiPemasukan->keterangan= $request->get('keterangan');
            $TransaksiPemasukan->nominal = $request->get('nominal');
            $TransaksiPemasukan->jenis_transaksi = 'pemasukan';
            $TransaksiPemasukan->user_id= $id;
            
            if($dbsub->isEmpty())
            {
                $TransaksiPemasukan->kategori_id = $request->get('kategori'); 
            }
            else
            {
                $TransaksiPemasukan->subkategori_id = $dbsub[0]->id;
                $TransaksiPemasukan->kategori_id = $dbsub[0]->kategori_id;
            }
            $TransaksiPemasukan->foto = $nama_file;
            $TransaksiPemasukan->save();
         }
        else
        {
            $TransaksiPemasukan = new Transaksi;
            $TransaksiPemasukan->keterangan= $request->get('keterangan');
            $TransaksiPemasukan->nominal = $request->get('nominal');
            $TransaksiPemasukan->jenis_transaksi = 'pemasukan';
            $TransaksiPemasukan->user_id= $id;
            $TransaksiPemasukan->foto = null;

            if($dbsub->isEmpty())
            {
                $TransaksiPemasukan->kategori_id = $request->get('kategori'); 
            }
            else
            {
                $TransaksiPemasukan->subkategori_id = $dbsub[0]->id;
                $TransaksiPemasukan->kategori_id = $dbsub[0]->kategori_id;
            }
            $TransaksiPemasukan->save();
        }

            $saldoskg = $saldo + $TransaksiPemasukan->nominal;
            $saldoo = User::find($id);
            $saldoo->saldo = $saldoskg;
            $saldoo->save();

             $user = User::find($id);
            $user->jumlahtransaksi = $user->jumlahtransaksi + 1;
            $user->save();

            if($user->jumlahtransaksi % $user->reminder == 0)
            {
                session()->flash('menabung', Auth::user()->pesanreminder);
            }    

            return redirect('dashboard');


        	}

        	







        
    }

     public function storetransaksipengeluaran(Request $request)
    {
        $id = Auth::user()->id;
        $saldo = Auth::user()->saldo;

              
        	$explode = explode("-",$request->kategori);
        	if(count($explode) > 1)
        	{
        		   $kate = (int)$explode[0];
        		   $sub = (int)$explode[1];

        		    $dbsub = DB::table('subkategoris')
                ->where('id', '=', $sub)
                ->where('kategori_id','=',$kate)
                ->get();

                if($request->hasFile('uploadfoto'))
        {

            $file = $request->file('uploadfoto');
            $nama_file = $file->getClientOriginalName();
            $target_directory = 'images';
            $file->move($target_directory,$nama_file); 


            $TransaksiPemasukan = new Transaksi;
            $TransaksiPemasukan->keterangan= $request->get('keterangan');
            $TransaksiPemasukan->nominal = $request->get('nominal');
            $TransaksiPemasukan->jenis_transaksi = 'pengeluaran';
            $TransaksiPemasukan->user_id= $id;
            if($dbsub->isEmpty())
            {
                $TransaksiPemasukan->kategori_id = $request->get('kategori'); 
            }
            else
            {
                $TransaksiPemasukan->subkategori_id = $dbsub[0]->id;
                $TransaksiPemasukan->kategori_id = $dbsub[0]->kategori_id;
            }
            $TransaksiPemasukan->foto = $nama_file;
            $TransaksiPemasukan->save();
         }
        else
        {
            $TransaksiPemasukan = new Transaksi;
            $TransaksiPemasukan->keterangan= $request->get('keterangan');
            $TransaksiPemasukan->nominal = $request->get('nominal');
            $TransaksiPemasukan->jenis_transaksi = 'pengeluaran';
            $TransaksiPemasukan->user_id= $id;
            if($dbsub->isEmpty())
            {
                $TransaksiPemasukan->kategori_id = $request->get('kategori'); 
            }
            else
            {
                $TransaksiPemasukan->subkategori_id = $dbsub[0]->id;
                $TransaksiPemasukan->kategori_id = $dbsub[0]->kategori_id;
            }
            $TransaksiPemasukan->foto = null;
            $TransaksiPemasukan->save();
        }
            $saldoskg = $saldo - $TransaksiPemasukan->nominal;
            $saldoo = User::find($id);
            $saldoo->saldo = $saldoskg;
            $saldoo->save();

             $user = User::find($id);
            $user->jumlahtransaksi = $user->jumlahtransaksi + 1;
            $user->save();

        
      

            if($user->jumlahtransaksi % $user->reminder == 0)
            {
                session()->flash('menabung', Auth::user()->pesanreminder);
            }    

            return redirect('dashboard');
            }
            else
            {
            	 $kate = (int)$explode[0];
        		   $sub = 0;

        		    $dbsub = DB::table('subkategoris')
                ->where('id', '=', $sub)
                ->where('kategori_id','=',$kate)
                ->get();

                if($request->hasFile('uploadfoto'))
        {

            $file = $request->file('uploadfoto');
            $nama_file = $file->getClientOriginalName();
            $target_directory = 'images';
            $file->move($target_directory,$nama_file); 


            $TransaksiPemasukan = new Transaksi;
            $TransaksiPemasukan->keterangan= $request->get('keterangan');
            $TransaksiPemasukan->nominal = $request->get('nominal');
            $TransaksiPemasukan->jenis_transaksi = 'pengeluaran';
            $TransaksiPemasukan->user_id= $id;
            if($dbsub->isEmpty())
            {
                $TransaksiPemasukan->kategori_id = $request->get('kategori'); 
            }
            else
            {
                $TransaksiPemasukan->subkategori_id = $dbsub[0]->id;
                $TransaksiPemasukan->kategori_id = $dbsub[0]->kategori_id;
            }
            $TransaksiPemasukan->foto = $nama_file;
            $TransaksiPemasukan->save();
         }
        else
        {
            $TransaksiPemasukan = new Transaksi;
            $TransaksiPemasukan->keterangan= $request->get('keterangan');
            $TransaksiPemasukan->nominal = $request->get('nominal');
            $TransaksiPemasukan->jenis_transaksi = 'pengeluaran';
            $TransaksiPemasukan->user_id= $id;
            if($dbsub->isEmpty())
            {
                $TransaksiPemasukan->kategori_id = $request->get('kategori'); 
            }
            else
            {
                $TransaksiPemasukan->subkategori_id = $dbsub[0]->id;
                $TransaksiPemasukan->kategori_id = $dbsub[0]->kategori_id;
            }
            $TransaksiPemasukan->foto = null;
            $TransaksiPemasukan->save();
        }
            $saldoskg = $saldo - $TransaksiPemasukan->nominal;
            $saldoo = User::find($id);
            $saldoo->saldo = $saldoskg;
            $saldoo->save();

             $user = User::find($id);
            $user->jumlahtransaksi = $user->jumlahtransaksi + 1;
            $user->save();

        
      

            if($user->jumlahtransaksi % $user->reminder == 0)
            {
                session()->flash('menabung', Auth::user()->pesanreminder);
            }    

            return redirect('dashboard');


            }
            


       



        
    }


    public function addreminder(Request $request)
    {
         $id = Auth::user()->id;

         $user = User::find($id);
         $user->reminder = $request->get('reminder');
         $user->jumlahtransaksi = 0;
         $user->pesanreminder = $request->get('remindermessage');
         $user->save();

         return redirect('konfigurasi');

    }










    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    public function updatenominaltabungan(Request $request)
    {
        $idtabungan = $request->get('tabunganid');
        $tabungan =  TabunganBerencana::find($idtabungan);
        $id = Auth::user()->id;
        $saldo = Auth::user()->saldo;
        $checker = $tabungan->nominal_sekarang + $request->get('tambahnominal');

        if($saldo >= $request->get('tambahnominal') && $checker <= $tabungan->target)
        {
                 $tabungan->nominal_sekarang = $tabungan->nominal_sekarang + $request->get('tambahnominal');
                $tabungan->save();   

                $TransaksiPengeluaran = new Transaksi;
                    $TransaksiPengeluaran->keterangan= "Menabung ".$tabungan->nama;
                    $TransaksiPengeluaran->nominal = $request->get('tambahnominal');
                    $TransaksiPengeluaran->jenis_transaksi = 'pengeluaran';
                    $TransaksiPengeluaran->user_id= $id;
                    $TransaksiPengeluaran->foto = null;
                    $TransaksiPengeluaran->save();

                    $saldoskg = $saldo - $TransaksiPengeluaran->nominal;
                    $saldoo = User::find($id);
                    $saldoo->saldo = $saldoskg;
                    $saldoo->save();

                    session()->flash('berhasil', 'Anda berhasil menambah nominal tabungan! Ayo nabung lagi!');


        }
        else if($checker > $tabungan->target)
        {
            session()->flash('gagal', 'Anda menabung lebih besar dari target!');
        }
        else
        {
             session()->flash('gagal', 'Saldo anda tidak mencukupi untuk menabung!');
        }

        


        
         
        
        return redirect('tabunganberencana');
    }

    public function updatetabungan(Request $request)
    {


        $idtabungan = $request->get('tabungan_id');
        $tabunganberencana =  TabunganBerencana::find($idtabungan);

        $tabunganberencana->nama = $request->get('namatarget');
        $tabunganberencana->target = $request->get('targettabungan');
        $tabunganberencana->save();
        
        return redirect('tabunganberencana');
    }

    public function updatesaldo(Request $request)
    {
        $id = Auth::user()->id;
        $user =  User::find($id);
        $user->saldo = $request->get('saldo');
        $user->save();

        return redirect('konfigurasi');
    }

    public function updatekategoripemasukan(Request $request)
    {


        $idkategori = $request->get('idpemasukanhidden');
        $kategoripemasukan =  Kategori::find($idkategori);

        $kategoripemasukan->nama = $request->get('kategoripemasukan');
        $kategoripemasukan->save();
        
        return redirect('konfigurasi');
    }
    public function updatesubkategori(Request $request)
    {


        $idkategori = $request->get('kategoriid');
        $idsubkategori = $request->get('subid');
        $subkategori =  Subkategori::find($idsubkategori);

        $subkategori->nama = $request->get('subkategori');
        $subkategori->save();
        
        return redirect('konfigurasi/subkategori/'.$idkategori);
    }
    public function updatekategoripengeluaran(Request $request)
    {


        $idsubkategori = $request->get('idpengeluaranhidden');
        $kategoripemasukan =  Kategori::find($idsubkategori);

        // dd($kategoripemasukan);
        $kategoripemasukan->nama = $request->get('kategoripengeluaran');
        $kategoripemasukan->save();
        
        return redirect('konfigurasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function deletekategori($id)
    {


        $transaksi =  Transaksi::where('kategori_id', $id)->get();

        if($transaksi->count() > 0)
        {
        	  foreach($transaksi as $t)
        	{
	        	$t->kategori_id = null;
	        	$t->subkategori_id = null;
	        	$t->save();
        	}

        }

      
       
        $subkategori= Subkategori::where('kategori_id', $id);

        $subkategori->delete();

        $kategori = Kategori::find($id);

        $kategori->delete();

        return redirect('/konfigurasi');
    }

    public function deletesubkategori($id , $kid)
    {


        $transaksi =  Transaksi::where('subkategori_id', $id)->get();


        if($transaksi->count() > 0)
        {
        	  foreach($transaksi as $t)
        	{

	        	$t->subkategori_id = null;
	        	$t->save();
	        	
        	}

        }

        $subkategori = Subkategori::find($id);
        $subkategori->delete();

        return redirect('/konfigurasi/subkategori/'.$kid);


    }

    public function deletetabungan($id)
    {
        $tabungan = TabunganBerencana::find($id);
        $tabungan->delete();

        return redirect('tabunganberencana');
    }


    public function cetakpdf()
    {
        $id = Auth::user()->id;
        $transaksi = Transaksi::All();
        
        $pdf = PDF::loadview('laporan_pdf',['transaksi'=>$transaksi]);
        return $pdf->download('laporan-transaksi-pdf.pdf');
        return redirect('/dashboard');
        
    }

    public function cetakexcel()
    {
        return Excel::download(new TransaksiExport, 'transaksi.xlsx');
    }
}
