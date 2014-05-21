@extends('layouts.application')

@section('content')

<h1>Export</h1>

<p>
	<a href="/entries/export/csv" class="btn btn-primary btn-large">Nieuwe CSV export</a>
</p>

<table class="table table-hover">
	<tr>
		<th>ID</th>
		<th>Gestart door</th>
		<th>Soort</th>
		<th>Datum</th>
		<th>Bestandsnaam</th>
		<th>Bestandsgrootte</th>
		<th></th>
	</tr>

	@foreach($exports as $export)
	<tr>
		<td>{{ $export->id }}</td>
		<td>{{ $export->user->username }}</td>
		<td>{{ $export->type }}</td>
		<td>{{ $export->created_at }}</td>
		<td>{{ $export->filename }}</td>
		<td>{{ $export->filesize }} Kb</td>
		<td>{{ link_to($export->downloadPath(), 'Downloaden', ['class' => 'btn btn-sm btn-success']) }}</td>
	</tr>
	@endforeach

</table>

{{ $exports->links() }}

@stop
