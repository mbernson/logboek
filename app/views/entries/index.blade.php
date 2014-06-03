@extends('layouts.application')

@section('content')

@if(isset($title))
	<h1>{{{ $title }}}</h1>
@endif

@foreach($entries as $entry)

	@include('entries.panel', ['entry' => $entry])

@endforeach

{{ $entries->links() }}

@stop
