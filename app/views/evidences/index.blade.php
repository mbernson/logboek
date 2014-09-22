@extends('layouts.application')

@section('content')

<h1>Bewijzen</h1>

<p>
<a class="btn btn-primary btn-lg" href="{{ action('evidences.create') }}">Nieuw bewijs</a>
</p>

	@if($evidences->count() == 0)
		<p>Er zijn <b>geen</b> bewijzen gevonden!</p>
	@else

<table class="table table-hover">
	<tr>
		<th>ID</th>
		<th>Titel</th>
		<th>Hash</th>
		<th>Datum verzending</th>
		<th>Verzender</th>
	</tr>

	 @foreach($evidences as $evidence)
	<tr>
		<td>{{ $evidence->id }}</td>
		<td>{{ link_to_action('evidences.show', $evidence->title, [$evidence->id]) }}</td>
		<td>{{ $evidence->hash }}</td>
		<td>{{ $evidence->date_received }}</td>
		<td>{{ $evidence->sender }}</td>
	</tr>
	@endforeach
</table>

	@endif

{{ $evidences->links() }}

@stop
