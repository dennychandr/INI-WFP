@extends('adminlayout.app')
@section('title','Laporan')
@section('content')

<div class="container">
	<div>
		<div class="col-md-12">
			<div id="piechart" style="width: 750px; height: 750px;"></div>
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
          title: 'Rasio Pemasukan dan Pengeluaran'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

@endsection






