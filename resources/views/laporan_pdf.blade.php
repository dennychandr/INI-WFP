<!DOCTYPE html>
<html>
<head>
	<title>Laporan Transaksi</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Laporan Transaksi</h4>
	</center>

	<div class="container">
		<div class="row">
			<p>User : {{Auth::user()->name}} </p>
			<p>Bulan : </p> 
		</div>
	</div>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Transaksi</th>
				<th>Nominal</th>
				<th>Kategori</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach($pemasukan as $p)
			<tr>
				<td>{{$p->created_at}}</td>
				<td>{{$p->keterangan}}</td>
				<td>Rp {{number_format($p->nominal)}}</td>
				<td>{{$p->kategoripemasukan->nama}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>