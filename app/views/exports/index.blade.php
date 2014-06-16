@extends('layouts.application')

@section('content')

<h1>Exports</h1>

<p>
	{{ link_to_action('ExportsController@create', 'Nieuwe CSV export', ['csv'], ['class' => 'btn btn-primary btn-large']) }}
	{{ link_to_action('ExportsController@create', 'Nieuw PDF verslag', ['pdf'], ['class' => 'btn btn-primary btn-large']) }}
	{{ link_to('./exports/create/pdf?save=0', 'Bekijk PDF verslag', ['class' => 'btn btn-primary btn-large']) }}
	{{ link_to('./exports/create/markdown?save=0', 'Bekijk Markdown verslag', ['class' => 'btn btn-primary btn-large']) }}
</p>

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

{{ $exports->links() }}

@stop
