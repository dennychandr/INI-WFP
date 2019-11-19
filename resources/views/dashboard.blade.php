@extends('adminlayout.app')

@section('title', 'Dashboard')
@section('content')

<div class="container">
    <div>
        <div class="col-md-12">
          
            <h1 class="display-4 mt-3 bold">Selamat Datang,{{Auth::user()->name}}</h1> <br>
            <div class="tile_count">
            <div class="col-md-4 col-sm-4  tile_stats_count">
              <span class="count_top"><i class="fa fa-money"></i> Saldo Anda</span>
              <div class="count">Rp.{{number_format(Auth::User()->saldo)}}</div>
            </div>
            <div class="col-md-4 col-sm-4  tile_stats_count">
              <span class="count_top"><i class="fa fa-money"></i> Pemasukan anda hari ini</span>
              <div class="count">Rp.{{number_format($pemasukan_hari_ini)}}</div>
            </div>
            <div class="col-md-4 col-sm-4  tile_stats_count">
              <span class="count_top"><i class="fa fa-money"></i> Pengeluaran anda hari ini</span>
              <div class="count">Rp.{{number_format($pengeluaran_hari_ini)}}</div>
            </div>
          </div>
             <a class="btn btn-primary mb-3 mt-3" href="{{url('/transaksi/cetakpdf')}}">Cetak Laporan format PDF</a>
               <a class="btn btn-success mb-3 mt-3" href="{{url('/transaksi/cetakexcel')}}">Cetak Laporan format Excel</a>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#pemasukanmodal">
              Tambah Pemasukan
          </button><br>

          <!-- Modal -->
          <div class="modal fade" id="pemasukanmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pemasukan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" action="{{url('transaksi/tambahtransaksipemasukan')}}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label >Nominal</label>
                        <input type="number" class="form-control" name="nominal" placeholder="Nominal" required>
                    </div>
                    <div class="form-group">
                        <label >Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" placeholder="Keterangan">
                    </div>
                    <div class="form-group">
                        <label >Upload Foto</label>
                        <input type="file" name="uploadfoto" class="form-control-file" id="exampleFormControlFile1" accept=".png, .jpg, .jpeg">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Kategori</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="kategori">
                            @foreach($kategoripemasukan as $kp)
                            <option value="{{$kp->id}}">{{$kp->nama}}</option>
                            @endforeach

                        </select>
                    </div>
                   <!--  <div class="form-group">
                        <label for="exampleFormControlSelect1">Sub Kategori</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            @foreach($kategoripemasukan as $kp)
                            <option>{{$kp->nama}}</option>
                            @endforeach

                        </select>
                    </div> -->
                    <button type="submit" class="btn btn-success">Submit</button>


                </form>

            </div>

        </div>
    </div>
</div>


<!-- Button trigger modal -->
<button type="button" class="btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#pengeluaranmodal">
  Tambah Pengeluaran
</button> <br>

<!-- Modal -->
<div class="modal fade" id="pengeluaranmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengeluaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
     <form method="POST" enctype="multipart/form-data" action="{{url('transaksi/tambahtransaksipengeluaran')}}">
        {{ csrf_field() }}
        <div class="form-group">
            <label >Nominal</label>
            <input type="number" class="form-control" name="nominal" placeholder="Nominal" required>
        </div>
        <div class="form-group">
            <label >Keterangan</label>
            <input type="text" class="form-control" name="keterangan" placeholder="Keterangan">
        </div>
        <div class="form-group">
            <label >Upload Foto</label>
            <input type="file" name="uploadfoto" class="form-control-file" id="exampleFormControlFile1" accept=".png, .jpg, .jpeg">
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Kategori</label>
            <select class="form-control" id="exampleFormControlSelect1" name="kategori">
                @foreach($kategoripengeluaran as $kp)
                            <option value="{{$kp->id}}">{{$kp->nama}}</option>
                            @endforeach

            </select>
        </div>
        <!-- <div class="form-group">
                        <label for="exampleFormControlSelect1">Sub Kategori</label>
                        <select name="kategori" class="form-control" id="exampleFormControlSelect1">
                            @foreach($kategoripemasukan as $kp)
                            <option value="{{$kp->id}}">{{$kp->nama}}</option>
                            @endforeach

                        </select>
                    </div> -->
        <button type="submit" class="btn btn-success">Submit</button>


    </form>
</div>

</div>

</div>

</div>

</div>
</div>
<div>
    <div class="col-md-12">
        <h3 class="display-5 mt-2">Lihat berdasarkan</h3>
        <form method="POST" enctype="multipart/form-data" action="{{url('dashboard/filter')}}">
        {{ csrf_field() }}
        Bulan : <select name="bulan" >
                            <option selected value="1" >Januari</option>
                            <option value="2" >Februari</option>
                            <option value="3" >Maret</option>
                            <option value="4" >April</option>
                            <option value="5" >Mei</option>
                            <option value="6" >Juni</option>
                            <option value="7" >Juli</option>
                            <option value="8" >Agustus</option>
                            <option value="9" >September</option>
                            <option value="10" >Oktober</option>
                            <option value="11" >November</option>
                            <option value="12" >Desember</option>
                        </select>
                        Tahun : <input type="text" size="4" maxlength="4" value="2019" name="tahun">
         <br> <br>
                        Filter bulan & tahun &nbsp;<button type="submit" value="terapkan_bln_thn" name="terapkan">Terapkan</button>
                        <br><br>
                        Filter tahun saja &nbsp;<button type="submit" value="terapkan_thn" name="terapkan">Terapkan</button>
         <br> <br>

         
         <h1 class="display-5 mt-2 bold">{{$string}}</h1>
       </form>
         @foreach($transaksi as $t)
            <div class="card text-black bg-light mb-3" style="max-width: 100%;">
              <div class="card-body">
                <h1 class="card-title text-dark">{{$t->created_at}}</h1>
                @if($t->jenis_transaksi == "pemasukan")
                <h1 class="card-title float-right" style="color: green">Rp. {{number_format($t->nominal)}}</h1>
                @else
                <h1 class="card-title float-right" style="color: red">Rp. {{number_format($t->nominal)}}</p>
                @endif
                <p class="card-text"></p>
                <h1 class="card-text float-left text-dark">{{$t->keterangan}}</h1>
                @if($t->foto != null)
<img src="{{asset('images/'.$t->foto)}}" style="width: 100px; height: 100px;">

                @endif
                



                
            </div>
            </div>
            @endforeach



    </div>
    
</div>
</div>











<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>


@endsection




