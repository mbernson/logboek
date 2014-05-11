@extends('layouts.application')

@section('content')

@if($user->isNew())
{{ Form::open(['route' => ['users.store', $user->id]]) }}
@else
{{ Form::open(['route' => ['users.update', $user->id], 'method' => 'put']) }}
@endif

<div class="form-group">
	{{ Form::label('username', 'Gebruikersnaam') }}
	{{ Form::text('username', $user->username, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('email', 'E-mail adres') }}
	{{ Form::text('email', $user->email, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('password', 'Wachtwoord') }}
	{{ Form::password('password', ['class' => 'form-control']) }}
</div>

<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

{{ Form::close() }}

@stop
