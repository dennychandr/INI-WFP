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
		</div>
	</div>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Keterangan</th>
				<th>Nominal</th>
				<th>Kategori</th>
				<th>Sub Kategori</th>
				<th>Jenis Transaksi</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach($transaksi as $t)
			<tr>
				<td>{{$t->created_at}}</td>
				<td>{{$t->keterangan}}</td>
				<td>Rp {{number_format($t->nominal)}}</td>
				@if($t->kategori == null)
				<td>Tanpa Kategori</td>
				@else
				<td>{{$t->kategori->nama}}</td>
				@endif
				@if($t->subkategori == null)
				<td>Tanpa Sub Kategori</td>
				@else
				<td>{{$t->subkategori->nama}}</td>
				@endif
				<td>{{ucfirst($t->jenis_transaksi)}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>