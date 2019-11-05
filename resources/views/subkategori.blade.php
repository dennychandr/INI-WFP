
@extends('adminlayout.app')
@section('content')
<div class="container">
  <div>
    <div class="col-sm">
     <h1 class="display-4 mt-5 text-center">Atur Sub Kategori</h1>
   </div>
 </div>
 <div >
  <div class="col-sm">
    
    <h1 class="display-4 mt-3 text-center">{{$kategori->nama}}</h1> <br>
    

    <table class="table">
      <thead>
        <tr>
          <th scope="col">Nama Sub Kategori</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($subkategori as $sk)
        <tr>
          <td>{{$sk->nama}}</td>
          <td>
            <a class="btn btn-primary" href="{{url('/konfigurasi/updatepemasukan/'.$sk->id)}}">Update</a>
            <a class="btn btn-danger"  href="{{url('/konfigurasi/deletepemasukan/'.$sk->id)}}">Delete</a>
          </td>
        </tr>

        @endforeach
      </tbody>
    </table>

    {{$subkategori->links("pagination::bootstrap-4")}}




    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalSubKategoriPemasukan">
      Tambahkan Sub Kategori
    </button>

    <!-- Modal -->
    <div class="modal fade" id="ModalSubKategoriPemasukan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Sub Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ url('/konfigurasi/tambahsubkategori/'.$kategori->id) }}">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="exampleFormControlInput1">Tambah Sub Kategori {{$kategori->nama}}</label>
                <input type="text" class="form-control" id="kategori" name="subkategori" placeholder="Ovo,dll" required> <br>
                <button type="submit" class="btn btn-primary">Submit Sub Kategori</button>

              </div>

            </form>
            
          </div>
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

</body>
</html>





<!-- <form method="POST" action="">
        <div class="form-group">
          <label for="exampleFormControlInput1"> Tambah Kategori Pengeluaran</label>
          <input type="text" class="form-control" id="kategori" name="kategoripengeluaran" placeholder="Makanan"> <br>
          <button type="submit" class="btn btn-primary">Submit Kategori</button>

        </div>

      </form> -->

@endsection