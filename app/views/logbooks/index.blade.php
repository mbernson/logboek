@extends('layouts.application')

@section('content')

<h1>Logboeken</h1>

<p><a class="btn btn-primary btn-lg" href="{{ action('logbooks.create') }}">Nieuw logboek</a></p>

<table class="table table-hover">
	<tr>
		<th>ID</th>
		<th>Titel</th>
		<th>Eigenaar</th>
		<th>Aantal entries</th>
		<th>Laatst bijgewerkt</th>
		<th>Bewerken</th>
	</tr>

	@foreach($logbooks as $logbook)
	<tr>
		<td>{{ $logbook->id }}</td>
		<td>{{ link_to_action('logbooks.show', $logbook->title, [$logbook->id]) }}</td>
		@if($logbook->user_id == 0)
			<td>Systeem</td>
		@else
			<td> {{ link_to_action('users.show', $logbook->user->username, [$logbook->user->id]) }} </td>
		@endif
		<td>{{ $logbook->entries->count() }}</td>
		<td>{{ ($entry = $logbook->entries->last()) ? $entry->started_at : 'Nog nooit' }}</td>
		<td>{{ link_to_action('logbooks.edit', 'Bewerken', [$logbook->id], ['class' => 'btn btn-sm btn-success']) }}</td>
	</tr>
	@endforeach

</table>

@stop
