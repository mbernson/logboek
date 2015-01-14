@extends('layouts.application')

@section('content')

<h1>Exports</h1>

<p>
	{{ link_to_action('ExportsController@create', 'Nieuwe CSV export', ['csv'], ['class' => 'btn btn-primary btn-large']) }}
	{{ link_to('./exports/create/markdown?save=0', 'Nieuwe Markdown export', ['class' => 'btn btn-primary btn-large']) }}
	{{ link_to('./exports/create/html?save=0', 'Nieuwe HTML export', ['class' => 'btn btn-primary btn-large']) }}
</p>

<p>
<form method="get" action="./exports/create/pdf">
	<label for="save">Opslaan</label>
	<select name="save">
		<option value="0">Nee</option>
		<option value="1">Ja</option>
	</select>
	<br />
	<label for="logbooks">Inbegrepen logboek(en)</label>
	<select name="logbooks">
		@foreach($logbooks as $logbook)
		<option value="{{ $logbook->id }}">{{{ $logbook->title }}}</option>
		@endforeach
		<option value="all">Alle logboeken</option>
	</select>
	<br />
	<input type="submit" value="Nieuwe PDF" class="btn btn-primary btn-large" />
</form>
</p>

@if($exports->count() == 0)
	<p>Er zijn <b>geen</b> exports gevonden!</p>
@else

<table class="table table-hover">
	<tr>
		<th>ID</th>
		<th>Soort</th>
		<th>Gestart door</th>
		<th>Datum</th>
		<th>Bestandsnaam</th>
		<th>Bestandsgrootte</th>
		<th>Downloaden</th>
		<th>Verwijderen</th>
	</tr>

	@foreach($exports as $export)
	<tr>
		<td>{{ $export->id }}</td>
		<td>{{ strtoupper($export->type) }}</td>
		<td>{{ $export->user->username }}</td>
		<td>{{ $export->created_at }}</td>
		<td>{{ $export->filename }}</td>
		<td>{{ $export->filesize }} Kb</td>
		<td>{{ link_to($export->downloadPath(), 'Downloaden', ['class' => 'btn btn-sm btn-success']) }}</td>
		<td>
			@include('exports.delete_form', ['export' => $export])
		</td>
	</tr>
	@endforeach

</table>

@endif
{{ $exports->links() }}

@stop
