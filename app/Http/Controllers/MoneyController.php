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
        ->whereBetween('created_at',[$request->start_date,$request->end_date])
        ->where('user_id',$id)
        ->groupBy('jenis_transaksi')
        ->get();


        $array[] = ['Jenis','Nominal'];

        foreach($data as $key => $value)
        {
            $array[++$key] = [$value->jenis, intval($value->nominal)];
        }

        // dd($array);


       return view('laporankeuangan')->with('chart', json_encode($array));



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

        $saldo = Auth::user()->saldo;

        return view('konfigurasi', compact('kategoripemasukan','kategoripengeluaran', 'saldo'));
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
            $TransaksiPemasukan->kategori_id = $request->get('kategori');
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
            $TransaksiPemasukan->kategori_id = $request->get('kategori');
            $TransaksiPemasukan->foto = null;
            $TransaksiPemasukan->save();
        }

            $saldoskg = $saldo + $TransaksiPemasukan->nominal;
            $saldoo = User::find($id);
            $saldoo->saldo = $saldoskg;
            $saldoo->save();

            return redirect('dashboard');
    }

     public function storetransaksipengeluaran(Request $request)
    {
        $id = Auth::user()->id;
        $saldo = Auth::user()->saldo;

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
            $TransaksiPemasukan->kategori_id = $request->get('kategori');
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
            $TransaksiPemasukan->kategori_id = $request->get('kategori');
            $TransaksiPemasukan->foto = null;
            $TransaksiPemasukan->save();
        }
            $saldoskg = $saldo - $TransaksiPemasukan->nominal;
            $saldoo = User::find($id);
            $saldoo->saldo = $saldoskg;
            $saldoo->save();

            return redirect('dashboard');
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

        if($saldo >= $request->get('tambahnominal') && $checker < $tabungan->target)
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
        $kategoripemasukan =  Kategori::find($idkategori);

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


        // $Updatetransaksi =  Transaksi::where('kategori_id', $id)->first();
        // $Updatetransaksi->kategori_id = null;
        // $Updatetransaksi->subkategori_id = null;
        // $Updatetransaksi->save();

        $subkategori= Subkategori::where('kategori_id', $id);

        $subkategori->delete();
        $kategori = Kategori::find($id);

        $kategori->delete();

        return redirect('/konfigurasi');
    }

    public function deletesubkategori($id , $kid)
    {
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
        $pemasukan = Pemasukan::All();
        
        $pdf = PDF::loadview('laporan_pdf',['pemasukan'=>$pemasukan]);
        return $pdf->download('laporan-transaksi-pdf.pdf');
        return redirect('/dashboard');
        
    }

    public function cetakexcel()
    {
        return Excel::download(new TransaksiExport, 'transaksi.xlsx');
    }
}
