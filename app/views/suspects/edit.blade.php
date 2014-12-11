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

<div class="form-group">
  {{ Form::label('street', 'Straat') }}
  {{ Form::text('street', $suspect->street, ['class' => 'form-control', 'placeholder' => 'Straat verdachte']) }}
</div>

<div class="form-group">
  {{ Form::label('city', 'Woonplaats') }}
  {{ Form::text('city', $suspect->city, ['class' => 'form-control', 'placeholder' => 'Woonplaats verdachte']) }}
</div>

<div class="form-group">
  {{ Form::label('email', 'E-mail') }}
  {{ Form::text('email', $suspect->email, ['class' => 'form-control', 'placeholder' => 'E-mail verdachte']) }}
</div>

<div class="form-group">
  {{ Form::label('phone', 'Telefoon') }}
  {{ Form::text('phone', $suspect->phone, ['class' => 'form-control', 'placeholder' => 'Telefoon nr. verdachte']) }}
</div>

<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

{{ Form::close() }}

{{ Form::open(['route' => ['suspects.destroy', $suspect->id], 'method' => 'delete']) }}

  <div class="pull-right">
    <button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
  </div>

{{ Form::close() }}

@stop
