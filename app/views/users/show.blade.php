@extends('layouts.application')

@section('content')

<div class="form-group">
	{{ Form::label('username', 'Gebruikersnaam') }}
	{{ Form::text('username', $user->username, ['class' => 'form-control', 'disabled' => 1]) }}
</div>

<div class="form-group">
	{{ Form::label('email', 'E-mail adres') }}
	{{ Form::text('email', $user->email, ['class' => 'form-control', 'disabled' => 1]) }}
</div>

@stop
