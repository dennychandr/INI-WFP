@extends('adminlayout.app')
@section('title','Laporan Trend Pemasukan')
@section('content')

<div class="container">
  <div>
    <h1 class="display-5 mt-3">Laporan Trend Pemasukan</h1>
  </div>

  <div>
    <form action="{{url('laporantrendpemasukan')}}" method="get">
    <div class="col-md-6">
      <label>Tanggal Awal Laporan</label>
      <input type="date" name="start_date" class="form-control">
    </div>
    <div class="col-md-6">
       <label>Tanggal Akhir Laporan</label>
        <input type="date" name="end_date" class="form-control">
    </div>      
    <input type="submit" name="" class="form-control btn btn-primary mt-3" value="Terapkan">
      </form>
  </div>  
	

  <div>
		<div class="col-md-12">
			<div id="piechart" style="margin-left: 20%;"></div>
		</div>


	</div>
	
</div>











@endsection


@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

    	var transaksi = <?php echo $chart; ?>;


      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable(transaksi);

        console.log(data)
        var options = {
          
          is3D : true,
          width : 500,
          height : 500,
          backgroundColor: '#F7F7F7',
           'chartArea': {'width': '50%', 'height': '50%','left':'10',
            'right':'10',
            'bottom':'20', 
            'top':'20'},
           'legend': {'position': 'bottom'},
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }


     $(window).resize(function(){
  drawChart();


});




    </script>

@endsection






