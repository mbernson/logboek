@extends('layouts.application')

@section('content')

<h1>Bestanden</h1>

<p><a class="btn btn-primary btn-lg" href="{{ action('files.create') }}">Nieuw bestand</a></p>

	<table class="table table-hover">
		<tr>
			<th>ID</th>
			<th>Naam</th>
			<th>Eigenaar</th>
			<th>Grootte</th>
			<th>Geupload op</th>
		</tr>

		@foreach($files as $file)
		<tr>
			<td>{{ $file->id }}</td>
			<td>{{ link_to_action('files.show', empty($file->title) ? $file->filename : $file->title, [$file->id]) }}</td>
			<td>{{ link_to_action('users.show', $file->user->username, [$file->user->id]) }}</td>
			<td>{{ format_bytes($file->filesize) }}</td>
			<td>{{ $file->created_at }}</td>
		</tr>
		@endforeach

	</table>

{{ $files->links() }}

@stop
