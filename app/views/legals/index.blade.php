@extends('layouts.application')

@section('content')

<h1>Juridische kader</h1>

<!-- Code used for tab system -->
  <script>
  $(function () {
    $('#myTab a:last').tab('show')
  })
  </script>

  <ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#all" role="tab" data-toggle="tab">Alle wetten <span class="badge">{{ $all }}</span></a></li>
    <li><a href="#criminallaw" role="tab" data-toggle="tab">Wetboek van Strafrecht <span class="badge">{{ $criminalLaw }}</span></a></li>
    <li><a href="#criminalprocedure" role="tab" data-toggle="tab">Wetboek van Strafvordering <span class="badge">{{ $criminalProcedure }}</span></a></li>
    <li><a href="#europeanrights" role="tab" data-toggle="tab">RVDM <span class="badge">{{ $europeanRights }}</span></a></li>
  </ul>
<!-- end code used for tab system -->

<div class="tab-content">
  <div class="tab-pane active" id="all">

    @if($all == 0)
      <p style="margin-top:1em;">Er zijn <b>geen</b> wetten gevonden m.b.t. het juridische kader!</p>
    @else

      @foreach($legals as $legal)
        <h3>{{ $legal->name }}</h3>
        <h5>{{ $legal->abbreviation }} (<i>{{ $legal->code }}</i>)</h5>
        <p>{{ $legal->html_body }}</p>
      @endforeach

      {{ $legals->links() }}

    @endif

  </div>
  <div class="tab-pane" id="criminallaw">

    @if($criminalLaw == 0)
      <p style="margin-top:1em;">Er zijn <b>geen</b> wetten gevonden m.b.t. het juridische kader (<i>Wetboek van Strafrecht</i>)!</p>
    @else

      @foreach($legals as $legal)
        @if($legal->code == 'Wetboek van Strafrecht')
          <h3>{{ $legal->name }}</h3>
          <h5>{{ $legal->abbreviation }} (<i>{{ $legal->code }}</i>)</h5>
          <p>{{ $legal->html_body }}</p>
        @endif
      @endforeach

      {{ $legals->links() }}

    @endif

  </div>
  <div class="tab-pane" id="criminalprocedure">

    @if($criminalProcedure == 0)
      <p style="margin-top:1em;">Er zijn <b>geen</b> wetten gevonden m.b.t. het juridische kader (<i>Wetboek van Strafvordering</i>)!</p>
    @else

      @foreach($legals as $legal)
        @if($legal->code == 'Wetboek van Strafvordering')
          <h3>{{ $legal->name }}</h3>
          <h5>{{ $legal->abbreviation }} (<i>{{ $legal->code }}</i>)</h5>
          <p>{{ $legal->html_body }}</p>
        @endif
      @endforeach

      {{ $legals->links() }}

    @endif

  </div>
  <div class="tab-pane" id="europeanrights">

    @if($europeanRights == 0)
      <p style="margin-top:1em;">Er zijn <b>geen</b> wetten gevonden m.b.t. het juridische kader (<i>Europees Verdrag</i>)!</p>
    @else

      @foreach($legals as $legal)
        @if($legal->code == 'Europees Verdrag')
          <h3>{{ $legal->name }}</h3>
          <h5>{{ $legal->abbreviation }} (<i>{{ $legal->code }}</i>)</h5>
          <p>{{ $legal->html_body }}</p>
        @endif
      @endforeach

      {{ $legals->links() }}

    @endif

  </div>
</div>

@stop
