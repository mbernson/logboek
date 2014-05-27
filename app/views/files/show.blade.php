@extends('layouts.application')

@section('content')

<h1>Bestandsinformatie</h1>

<table class="table table-hover">
	<tr>
		<th>ID</th>
		<td>{{ $file->id }}</td>
	</tr>
	<tr>
		<th>Titel</th>
		<td>{{ $file->title }} </td>
	</tr>
	<tr>
		<th>Beschrijving</th>
		<td>{{ $file->description }} </td>
	</tr>
	<tr>
		<th>Bestandsnaam</th>
		<td>{{ $file->filename }} </td>
	</tr>
	<tr>
		<th>Bestandsklasse</th>
		<td>{{ $file->type }} </td>
	</tr>
	<tr>
		<th>Eigenaar</th>
		<td>{{ $file->user->username }}</td>
	</tr>
	<tr>
		<th>Grootte</th>
		<td>{{ format_bytes($file->filesize) }}</td>
	</tr>
	<tr>
		<th>Hash</th>
		@if($file->validateHash())
		<td class="success">
			{{ $file->hash }}
			<br>
			<span class="glyphicon glyphicon-ok"></span> Hash klopt
		</td>
		@else
		<td class="danger">
			<strong>Opgegeven</strong>: {{ $file->hash }}
			<br>
			<strong>Werkelijk</strong>: {{ $file->calculatedHash() }}
			<br>
			<span class="glyphicon glyphicon-remove"></span> Hash komt niet overeen!
		</td>
		@endif
	</tr>
	<tr>
		<th>Hashing algoritme</th>
		<td>{{ $file->hash_algorithm }}</td>
	</tr>
	<tr>
		<th>Geupload op</th>
		<td>{{ $file->created_at }}</td>
	</tr>
	<tr>
		<th></th>
		<td>{{ link_to($file->downloadPath(), 'Dowload', ['class' => 'btn btn-primary']) }}</td>
	</tr>
</table>

{{-- link_to_action('files.edit', 'Bewerken', [$file->id], ['class' => 'btn btn-success']) --}}

{{ Form::open(['route' => ['files.destroy', $file->id], 'method' => 'delete']) }}
	<button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
{{ Form::close() }}

@stop
