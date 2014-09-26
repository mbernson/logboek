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

<div class="form-group">
	{{ Form::label('first_name', 'Voornaam') }}
	{{ Form::text('first_name', $user->first_name, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('last_name', 'Achternaam') }}
	{{ Form::text('last_name', $user->last_name, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('rights', 'Gebruikers rechten') }}
	@if(Auth::user()->rights === 0)
		<p>Voor deze wijziging zijn <b>administrator</b> rechten nodig.</p>
	@else
		{{ Form::select('rights', ['0' => 'gebruiker', '1' => 'administrator'], $user->rights, ['class' => 'form-control']) }}
	@endif
</div>

<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

{{ Form::close() }}

{{ Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) }}

	<div class="pull-right">
		<button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
	</div>

{{ Form::close() }}

@stop
