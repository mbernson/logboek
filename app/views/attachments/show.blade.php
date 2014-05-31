@extends('layouts.application')

@section('content')

<h1>Bestandsinformatie</h1>

<table class="table table-hover">
	<tr>
		<th>ID</th>
		<td>{{ $attachment->id }}</td>
	</tr>
	<tr>
		<th>Titel</th>
		<td>{{ $attachment->title }} </td>
	</tr>
	<tr>
		<th>Beschrijving</th>
		<td>{{ $attachment->description }} </td>
	</tr>
	<tr>
		<th>Bestandsnaam</th>
		<td>{{ $attachment->filename }} </td>
	</tr>
	@if($attachment->public)
	<tr>
		<th>URL</th>
		<td><input type="text" value="{{ $attachment->downloadPath() }}" class="form-control" /></td>
	</tr>
	@endif
	<tr>
		<th>Bestandsklasse</th>
		<td>{{ $attachment->type }} </td>
	</tr>
	<tr>
		<th>Eigenaar</th>
		<td>{{ $attachment->user->username }}</td>
	</tr>
	<tr>
		<th>Grootte</th>
		<td>{{ format_bytes($attachment->filesize) }}</td>
	</tr>
	<tr>
		<th>Hash</th>
		@if($attachment->validateHash())
		<td class="success">
			{{ $attachment->hash }}
			<br>
			<span class="glyphicon glyphicon-ok"></span> Hash klopt
		</td>
		@else
		<td class="danger">
			<strong>Opgegeven</strong>: {{ $attachment->hash }}
			<br>
			<strong>Werkelijk</strong>: {{ $attachment->calculatedHash() }}
			<br>
			<span class="glyphicon glyphicon-remove"></span> Hash komt niet overeen!
		</td>
		@endif
	</tr>
	<tr>
		<th>Hashing algoritme</th>
		<td>{{ $attachment->hash_algorithm }}</td>
	</tr>
	<tr>
		<th>Geupload op</th>
		<td>{{ $attachment->created_at }}</td>
	</tr>
	<tr>
		<th></th>
		<td>{{ link_to($attachment->downloadPath(), 'Dowload', ['class' => 'btn btn-primary']) }}</td>
	</tr>
</table>

{{ link_to_action('attachments.edit', 'Bewerken', [$attachment->id], ['class' => 'btn btn-success']) }}

{{ Form::open(['route' => ['attachments.destroy', $attachment->id], 'method' => 'delete']) }}
	<button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
{{ Form::close() }}

@stop
