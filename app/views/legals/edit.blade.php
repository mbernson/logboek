@extends('layouts.application')

@section('content')

@if($legal->isNew())
  {{ Form::open(['route' => ['legals.store', $legal->id]]) }}
@else
  {{ Form::open(['route' => ['legals.update', $legal->id], 'method' => 'put']) }}
@endif

<div class="form-group">
  {{ Form::label('name', 'Naam') }}
  {{ Form::text('name', $legal->name, ['class' => 'form-control']) }}
</div>

<div class="form-group">
  {{ Form::label('body', 'Omschrijving') }}
  {{ Form::textarea('body', $legal->body, ['class' => 'form-control markdown', 'rows' => 20]) }}
  <p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
</div>

<div class="form-group">
  {{ Form::label('abbreviation', 'Afkorting') }}
  {{ Form::text('abbreviation', $legal->abbreviation, ['class' => 'form-control']) }}
</div>

<div class="form-group">
  {{ Form::label('active', 'Actief') }}
  {{ Form::select('active', ['0' => 'Niet actief', '1' => 'Actief'], $legal->active, ['class' => 'form-control']) }}
</div>

<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

{{ Form::close() }}

{{ Form::open(['route' => ['legals.destroy', $legal->id], 'method' => 'delete']) }}

  <div class="pull-right">
    <button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
  </div>

{{ Form::close() }}

@stop
