@extends('layouts.application')

@section('content')

<h1>{{{ $logbook->title }}}</h1>

<p>
	@if ($logbook->user_id == (Auth::user()->id) || $logbook->user_id == 0)
		<a class="btn btn-primary btn-lg" href="{{ action('logbooks.entries.create', [$logbook->id]) }}">Nieuwe entry</a>
	@else
		<a class="btn btn-primary btn-lg" disabled="disabled">Nieuwe entry</a>
	@endif
</p>

@if($logbook->entries->count() == 0)
	<p>Er zijn geen logboek entries gevonden voor het logboek <strong>{{ $logbook->title }}</strong>!</p>
@endif

@foreach($entries as $entry)

	@include('entries.panel', ['entry' => $entry, 'collapse' => true])

@endforeach

{{ $entries->links() }}

@stop
