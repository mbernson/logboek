@extends('layouts.application')

@section('content')

@if($custody->isNew())
  {{ Form::open(['route' => ['custody.store', $custody->id]]) }}
@else
  {{ Form::open(['route' => ['custody.update', $custody->id], 'method' => 'put']) }}
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
  {{ Form::label('responsible', 'Toegewezen aan') }}
	{{ Form::select('responsible', $responsible, empty($custody->responsible) ? $authUser : $custody->responsible, ['class' => 'form-control']) }}
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
  {{ Form::textarea('description', $custody->description, ['class' => 'form-control markdown', 'rows' => 20]) }}
  <p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
</div>

<div class="form-group">
  {{ Form::label('details', 'Details') }}
  {{ Form::textarea('details', $custody->details, ['class' => 'form-control markdown', 'rows' => 20]) }}
  <p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
</div>

<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

{{ Form::close() }}

@if($custody->isNew() == false)

  {{ Form::open(['route' => ['custody.destroy', $custody->id], 'method' => 'delete']) }}

    <div class="pull-right">
      <button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
    </div>

  {{ Form::close() }}

@endif

@stop
