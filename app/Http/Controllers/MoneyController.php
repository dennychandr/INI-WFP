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


    public function config()
    {
        $id = Auth::user()->id;

        $kategoripemasukan = Kategori::where('user_id', $id)
        ->where('jenis_kategori','pemasukan')
        ->get();

        $kategoripengeluaran =  Kategori::where('user_id', $id)
        ->where('jenis_kategori','pengeluaran')
        ->get();

        return view('konfigurasi', compact('kategoripemasukan','kategoripengeluaran'));
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
        $newTabunganBerencana->nominal_sekarang= $request->get('nominalsekarang');
        $newTabunganBerencana->user_id = $id;
        $newTabunganBerencana->save();

        return redirect('/tabunganberencana');
    }

    public function storetransaksipemasukan(Request $request)
    {
        $id = Auth::user()->id;
            // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('file');
        $nama = $file->getClientOriginalName();
        $ekstensi = $file->getClientOriginalExtension();
;     $target_upload = asset('images');
        $nama_foto = $nama.".".$ekstensi;
        $file->move($target_upload,$nama_foto);    

        $newTransaksi = new Transaksi;
        $newTransaksi->nominal = $request->get('nominal');
        $newTransaksi->keterangan = $request->get('keterangan');
        $newTransaksi->foto = $nama_foto;
        $newTransaksi->jenis_transaksi = "pemasukan";
        $newTransaksi->user_id = $id;
        $newTransaksi->kategori_id = $request->get('kategori') ;
    }

     public function storetransaksipengeluaran(Request $request)
    {
        $id = Auth::user()->id;
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
