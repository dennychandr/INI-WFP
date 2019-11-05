
@extends('adminlayout.app')
@section('content')
<div class="container">
  <div>
    <div class="col-md-12">
     <h1 class="display-4 mt-5 text-center">Atur Kategori Pemasukan dan Pengeluaran Anda</h1>
    </div>
  </div>
 
  <div class="col-md-6">
    <h1 class="display-4 mt-3 text-center">Pemasukan</h1> <br>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">Nama Kategori</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($kategoripemasukan as $kp)
        <tr>
          <td>{{$kp->nama}}</td>
           <td>
          <a class="btn btn-success" href="{{url('/konfigurasi/subkategori/'.$kp->id)}}">Sub Kategori</a>
            <a class="btn btn-primary" href="{{url('/konfigurasi/updatepemasukan/'.$kp->id)}}">Update</a>
            <form action="{{url('/konfigurasi/deletekategori/'.$kp->id)}}" method="post">
              {{ csrf_field() }}
              <button class="btn btn-danger" style="color: white">Delete</button>
            </form>

          </td>
        </tr>

        @endforeach
      </tbody>
    </table>



    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPemasukan">
      Tambahkan Kategori
    </button>

    <!-- Modal -->
    <div class="modal fade" id="ModalPemasukan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ url('/konfigurasi/tambahpemasukan') }}">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="exampleFormControlInput1">Tambah Kategori Pemasukan</label>
                <input type="text" class="form-control" id="kategori" name="kategoripemasukan" placeholder="Uang saku dari mama" required> <br>
                <button type="submit" class="btn btn-primary">Submit Kategori</button>

              </div>

            </form>
            
          </div>
        </div>
      </div>
    </div>

  </div>
  


  <div class="col-md-6">
   <h1 class="display-4 mt-3 text-center">Pengeluaran</h1> <br>
   <table class="table">
    <thead>
      <tr>
        <th scope="col">Nama Kategori</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($kategoripengeluaran as $kp)
        <tr>
          <td>{{$kp->nama}}</td>
          <td>
            <a class="btn btn-success" href="{{url('/konfigurasi/subkategori/'.$kp->id) }}">Sub Kategori</a>
            <a class="btn btn-primary" href="{{url('/konfigurasi/updatepengeluaran/'.$kp->id) }}">Update</a>
            <form action="{{url('/konfigurasi/deletekategori/'.$kp->id)}}" method="post">
              {{ csrf_field() }}
              <button class="btn btn-danger" style="color: white">Delete</button>
            </form>
            

          </td>
        </tr>


        @endforeach
    </tbody>
  </table>



  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPengeluaran">
    Tambahkan Kategori
  </button>

  <!-- Modal -->
  <div class="modal fade" id="ModalPengeluaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('/konfigurasi/tambahpengeluaran') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="exampleFormControlInput1">Tambah Kategori Pengeluaran</label>
              <input type="text" class="form-control" id="kategori" name="kategoripengeluaran" placeholder="Makanan" required> <br>
              <button type="submit" class="btn btn-primary">Submit Kategori</button>

            </div>

          </form>

        </div>
      </div>
    </div>

  </div>
</div>
</div>






















  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>








@endsection