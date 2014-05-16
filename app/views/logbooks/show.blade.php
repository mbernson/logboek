@extends('layouts.application')

@section('content')

<h1>{{{ $logbook->title }}}</h1>

<p>
	<a class="btn btn-primary btn-lg" href="{{ action('logbooks.entries.create', [$logbook->id]) }}">Nieuwe entry</a>
</p>

@foreach($entries as $entry)

	@include('entries.panel', ['entry' => $entry])

@endforeach

{{ $entries->links() }}

@stop
