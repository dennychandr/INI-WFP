
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




<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#updatenominaltabungan" data-subkategoriid="{{$sk->id}}" data-subnama="{{$sk->nama}}" data-kategoriid="{{$kategori->id}}">
                                Update
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="updatenominaltabungan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Sub Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ url('/konfigurasi/updatesubkategori')}}">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="exampleFormControlInput1">Tambah Sub Kategori {{$kategori->nama}}</label>
                <input type="text" class="form-control" id="subkategori" name="subkategori" placeholder="Ovo,dll" required> <br>
                        <input type="hidden" name="subid" id="subid" value="">
                        <input type="hidden" name="kategoriid" id="kategoriid" value="">
                <button type="submit" class="btn btn-primary">Submit Sub Kategori</button>

              </div>

            </form>
            
          </div>
        </div>
      </div>
    </div>






            <form action="{{url('/konfigurasi/deletesubkategori/'.$sk->id.'/'.$kategori->id)}}" method="post">
              {{ csrf_field() }}
              <button class="btn btn-danger" style="color: white">Delete</button>
            </form>
          </td>
        </tr>

        @endforeach
      </tbody>
    </table>





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

@endsection

@section('js')

<script>

  $('#updatenominaltabungan').on('show.bs.modal', function (event) {
    
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('subkategoriid') // Extract info from data-* attributes
  var nama = button.data('subnama') // Extract info from data-* attributes
  var kategoriid = button.data('kategoriid') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-body #subkategori').val(nama);
  modal.find('.modal-body #subid').val(id);
  modal.find('.modal-body #kategoriid').val(kategoriid);

  
  // modal.find('.modal-title').text('New message to ' + recipient)
  // modal.find('.modal-body input').val(recipient)
})


</script>

@endsection