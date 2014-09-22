@extends('layouts.application')

@section('content')

<h1>Gebruikers</h1>

<p>
<a class="btn btn-primary btn-lg" href="{{ action('users.create') }}">Nieuwe gebruiker</a>
</p>

<table class="table table-hover">
<tr>
	<th>ID</th>
	<th>Gebruikersnaam</th>
	<th>E-mail adres</th>
	<th>Toegevoegd op</th>
	<th>Rechten</th>
</tr>

@foreach($users as $user)

<tr>
	<td>{{ $user->id }}</td>
	<td>{{ link_to_action('users.edit', $user->username, [$user->id]) }}</td>
	<td>{{ $user->email }}</td>
	<td>{{ $user->created_at }}</td>
	<td>{{ $user->right }}</td>
</tr>

@endforeach

</table>

@stop
