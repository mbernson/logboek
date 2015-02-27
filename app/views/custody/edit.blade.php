@extends('layouts.application')

@section('content')

@if($custody->isNew())
  {{ Form::open(['route' => ['custody.store', $custody->id]]) }}
@else
  {{ Form::open(['route' => ['custody.update', $custody->id], 'method' => 'put']) }}
@endif

@if($custody->signature == 1)
  <div class="alert alert-danger" role="alert">
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">Error:</span>
      Chain of Custody is al door opdrachtgever getekend. Wijzigingen of verwijderingen niet mogelijk!
  </div>
@endif

<div class="form-group">
  {{ Form::label('name', 'Naam') }}
  {{ Form::text('name', $custody->name, ['class' => 'form-control']) }}
</div>

<div class="form-group">
  {{ Form::label('characteristic', 'Kenmerk') }}
  {{ Form::text('characteristic', $custody->characteristic, ['class' => 'form-control']) }}
</div>

<div class="form-group">
  {{ Form::label('location', 'Locatie') }}
  {{ Form::text('location', $custody->location, ['class' => 'form-control']) }}
</div>

<div class="form-group">
  {{ Form::label('responsible', 'In beslag genomen door') }}
	{{ Form::select('responsible', $responsible, empty($custody->responsible) ? $authUser : $custody->responsible, ['class' => 'form-control']) }}
</div>

<div class="form-group">
  {{ Form::label('seized', 'In beslag genomen van') }}
  {{ Form::text('seized', $custody->seized, ['class' => 'form-control']) }}
</div>

<div class="form-group">
  {{ Form::label('date', 'Datum') }}
  {{ Form::text('date', empty($custody->date) ? date('Y-m-d') : $custody->date, ['class' => 'form-control']) }}
</div>

<div class="form-group">
  {{ Form::label('time', 'Timestamp') }}
  {{ Form::text('time', empty($custody->time) ? date('Y-m-d H:m:s') : $custody->time, ['class' => 'form-control', 'disabled' => 'disabled']) }}
</div>

<div class="form-group">
  {{ Form::label('description', 'Omschrijving') }}
  {{ Form::textarea('description', $custody->description, ['data-provide' => 'markdown', 'id' => 'markdown-lang', 'class' => 'form-control markdown', 'rows' => 20]) }}
  <p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
</div>

<div class="form-group">
  {{ Form::label('details', 'Details') }}
  {{ Form::textarea('details', $custody->details, ['data-provide' => 'markdown', 'id' => 'markdown-lang', 'class' => 'form-control markdown', 'rows' => 20]) }}
  <p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
</div>

@if($custody->signature == 0)
  <button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

{{ Form::close() }}

  @if($custody->isNew() == false)

    {{ Form::open(['route' => ['custody.destroy', $custody->id], 'method' => 'delete']) }}

      <div class="pull-right">
        <button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
      </div>

    {{ Form::close() }}

  @endif

@endif

@stop
