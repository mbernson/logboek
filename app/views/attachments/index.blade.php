@extends('layouts.application')

@section('content')

<h1>Bestanden</h1>

<p><a class="btn btn-primary btn-lg" href="{{ action('attachments.create') }}">Nieuw bestand</a></p>

	@if($attachments->count() == 0)
		<p>Er zijn <b>geen</b> bestanden gevonden!</p>
	@else

	<table class="table table-hover">
		<tr>
			<th>ID</th>
			<th>Naam</th>
			<th>Eigenaar</th>
			<th>Grootte</th>
			<th>Geupload op</th>
		</tr>

		@foreach($attachments as $attachment)
		<tr>
			<td>{{ $attachment->id }}</td>
			<td>{{ link_to_action('attachments.show', empty($attachment->title) ? $attachment->filename : $attachment->title, [$attachment->id]) }}</td>
			<td>{{ link_to_action('users.show', $attachment->user->username, [$attachment->user->id]) }}</td>
			<td>{{ format_bytes($attachment->filesize) }}</td>
			<td>{{ $attachment->created_at }}</td>
		</tr>
		@endforeach

	</table>

	@endif

{{ $attachments->links() }}

@stop
