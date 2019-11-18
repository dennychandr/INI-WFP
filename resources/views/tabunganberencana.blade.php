
@extends('adminlayout.app')
@section('content')
@section('title', 'Tabungan Berencana')

<div class="container">


        <div class="col-md-12">

    <div >
       @if(session()->has('berhasil'))
<div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>  {{ session('berhasil') }}</strong>
      </div>

</div>
@elseif(session()->has('gagal'))
<div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ session('gagal') }}</strong>
      </div>
  
</div>
  
@endif
            <h1 class="display-4 mt-3 text-center">Daftar Tabungan Anda</h1> <br>
            <button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#tabunganberencana">
              Tambah Tabungan Baru
          </button><br>

          <!-- Modal -->
          <div class="modal fade" id="tabunganberencana" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tabungan Berencana</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{url('/tabunganberencana/tambahtabunganberencana')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label >Nama Target</label>
                        <input type="text" class="form-control" name="namatarget" placeholder="Nama Tabungan" required>
                    </div>
                    <div class="form-group">
                        <label >Target Tabungan</label>
                        <input type="number" class="form-control" name="targettabungan" placeholder="Nominal Target Tabungan" required>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>


                </form>

            </div>

        </div>
    </div>
</div>
@foreach($tabunganberencana as $index =>$tb)
    <div >
        <div class="col-md-12">
          
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{$tb->nama}}</h5>
                <div class="progress">
                  <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width:{{$datapersen[$index]}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$datapersen[$index]}}%/Rp {{number_format($tb->nominal_sekarang)}}</div><br>
                  
                </div>
                <p class="float-left">Rp {{number_format($tb->nominal_sekarang)}}</p>
                <p class="float-right" >Rp {{number_format($tb->target)}}</p> <br>
                <form class="float-right" action="{{url('/konfigurasi/deletetabungan/'.$tb->id)}}" method="post">
                      {{ csrf_field() }}
                        <button class="btn btn-danger" style="color: white">Delete</button>
                   </form>
                   
                    <!-- <a class="btn btn-primary float-right mr-3" href="{{url('/konfigurasi/updatepemasukan/')}}">Update</a> -->


                  <button type="button" class="btn btn-primary float-right mr-3" data-updatetabungan="{{$tb->id}}" data-toggle="modal" data-target="#updatenominaltabungan" data-nama="{{$tb->nama}}" data-targett="{{$tb->target}}">
                                Update Tabungan
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="updatenominaltabungan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Update Data Tabungan</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <form method="POST" action="{{url('/tabunganberencana/updatetabungan')}}">
                                      {{ csrf_field() }}
                                      <div class="form-group">
                                    <label >Nama Target</label>
                                    <input type="text" class="form-control" id ="namatarget"name="namatarget" placeholder="Nama Tabungan" required>
                                </div>
                                <div class="form-group">
                                    <label >Target Tabungan</label>
                                    <input type="number" class="form-control" id="targettabungan"name="targettabungan" placeholder="Nominal Target Tabungan" required>
                                </div>
                                    <input type="hidden" name="tabungan_id" id="tabungan_id" value="">
                                <button type="submit" class="btn btn-success">Submit</button>


                                  </form>

                              </div>

                          </div>
                      </div>
                  </div>

<!-- <a class="btn btn-success float-right mr-3" href="{{url('/konfigurasi/subkategoripemasukan/')}}">Tambah Nominal Tabungan</a> -->
        <button type="button" class="btn btn-success float-right mr-3" data-tabunganid="{{$tb->id}}"  data-toggle="modal" data-target="#tambahnominaltabungan">
              Menabung
          </button>

          <!-- Modal -->
          <div class="modal fade" id="tambahnominaltabungan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Nominal Tabungan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{url('/tabunganberencana/updatenominaltabungan')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label >Tambah Nominal</label>
                        <input type="number" class="form-control" name="tambahnominal" placeholder="Tambah Nominal" required>
                        <input type="hidden" name="tabunganid" id="tabungan_id" value="">
                        
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
                </div>
              </div>
          </div>                   

                    
              </div>
                    
            </div>
        </div>
    </div>
    <br>
    @endforeach
    

</div>
</div>
</div>











<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

@endsection

@section('js')

<script>

  $('#tambahnominaltabungan').on('show.bs.modal', function (event) {
    
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('tabunganid') // Extract info from data-* attributes
  
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-body #tabungan_id').val(id);
  // modal.find('.modal-title').text('New message to ' + recipient)
  // modal.find('.modal-body input').val(recipient)
})


 var timeout = 3000;

$('#notification').delay(timeout).fadeOut(300);

</script>



<script>

  $('#updatenominaltabungan').on('show.bs.modal', function (event) {
    
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('updatetabungan') // Extract info from data-* attributes
  var nama = button.data('nama')
  var target = button.data('targett')
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-body #tabungan_id').val(id);
  modal.find('.modal-body #namatarget').val(nama);
  modal.find('.modal-body #targettabungan').val(target);

  
  // modal.find('.modal-title').text('New message to ' + recipient)
  // modal.find('.modal-body input').val(recipient)
})


</script>





@endsection


