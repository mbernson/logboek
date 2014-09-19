@extends('layouts.application')

@section('content')

@if($suspect->isNew())
  {{ Form::open(['route' => ['suspects.store', $suspect->id]]) }}
@else
  {{ Form::open(['route' => ['suspects.update', $suspect->id], 'method' => 'put']) }}
@endif

<div class="form-group">
  {{ Form::label('name', 'Naam') }}
  {{ Form::text('name', $suspect->name, ['class' => 'form-control', 'placeholder' => 'Naam verdachte']) }}
</div>

<div class="form-group">
  {{ Form::label('alias', 'Alias') }}
  {{ Form::text('alias', $suspect->alias, ['class' => 'form-control', 'placeholder' => 'Alias verdachte']) }}
</div>

<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

{{ Form::close() }}

{{ Form::open(['route' => ['suspects.destroy', $suspect->id], 'method' => 'delete']) }}

  <div class="pull-right">
    <button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
  </div>

{{ Form::close() }}

@stop
