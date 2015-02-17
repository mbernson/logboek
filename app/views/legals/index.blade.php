@extends('layouts.application')

@section('content')

<h1>Juridische kader</h1>
<hr />

@if($legals->count() == 0)
  <p>Er zijn <b>geen</b> wetten gevonden m.b.t. het juridische kader!</p>
@else

  @foreach($legals as $legal)
    <h3>{{ $legal->name }}</h3>
    <h5>{{ $legal->abbreviation }}</h5>
    <p>{{ $legal->body }}</p>
  @endforeach

@endif

{{ $legals->links() }}

@stop
