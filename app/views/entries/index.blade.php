@extends('layouts.application')

@section('content')

@if(isset($title))
	<h1>{{{ $title }}}</h1>
@endif

@if($entries->count() == 0)
	<p>Er zijn <b>geen</b> recente entries gevonden!</p>
@else

@foreach($entries as $entry)

	@include('entries.panel', ['entry' => $entry, 'collapse' => true])

@endforeach

@endif

{{ $entries->links() }}

@stop
