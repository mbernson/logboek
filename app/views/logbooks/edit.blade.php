@extends('layouts.application')

@section('content')

@if($logbook->isNew())
{{ Form::open(['route' => ['logbooks.store']]) }}
@else
{{ Form::open(['route' => ['logbooks.update', $logbook->id], 'method' => 'put']) }}
@endif

<div class="form-group">
	{{ Form::label('title', 'Titel') }}
	{{ Form::text('title', $logbook->title, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('user_id', 'Eigenaar') }}
	{{ Form::select('user_id', $users_options, $logbook->user_id, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('in_overview', 'Toon in overzicht') }}
	{{ Form::select('in_overview', ['1' => 'Ja', '0' => 'Nee'], $logbook->in_overview, ['class' => 'form-control']) }}
</div>

<button type="submit" class="btn btn-primary pull-left">Opslaan</button>

{{ Form::close() }}

@if($logbook->isNew() == false)
	{{ Form::open(['route' => ['logbooks.destroy', $logbook->id], 'method' => 'delete']) }}
		<button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
	{{ Form::close() }}
@endif

@stop
