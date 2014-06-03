@extends('layouts.application')

@section('content')

@if(isset($title))
	<h1>{{{ $title }}}</h1>
@endif

<p>
	<a class="btn btn-primary" href="/entries/export">Exporteren</a>
</p>

@foreach($entries as $entry)

	@include('entries.panel', ['entry' => $entry])

@endforeach

{{ $entries->links() }}

@stop
