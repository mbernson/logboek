@extends('layouts.application')

@section('content')

<h1>{{ $logbook->title }}</h1>

<p>
<a class="btn btn-primary btn-lg" href="{{ action('logbooks.entries.create', [$logbook->id]) }}">Nieuwe entry</a>
</p>

<table class="table table-hover">
	<tr>
		<th>ID</th>
		<th>Titel</th>
		<th>Aantal woorden</th>
		<th>Begonnen op</th>
		<th>Opgeslagen op</th>
	</tr>

	@foreach($entries as $entry)

	<tr>
		<td>{{ $entry->id }}</td>
		<td>{{ link_to_action('logbooks.entries.edit', $entry->title, [$logbook->id, $entry->id]) }}</td>
		<td>Ongeveer {{ str_word_count($entry->body) }} woorden</td>
		<td>{{ $entry->started_at }}</td>
		<td>{{ $entry->finished_at }}</td>
	</tr>
	@endforeach

</table>

@stop
