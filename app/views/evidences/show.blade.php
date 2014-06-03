@extends('layouts.application')

@section('content')

<h1><em>Bewijs informatie</em></h1>

<table class="table table-hover">
	<tr>
		<td>ID</td>
		<td>{{ $evidence->id }}</td>
	</tr>
	<tr>
		<td>Titel</td>
		<td>{{ $evidence->title }}</td>
	</tr>
	<tr>
		<td>Hash</td>
		<td>{{ $evidence->hash }}</td>
	</tr>
	<tr>
		<td>Datum ontvangen</td>
		<td>{{ $evidence->date_received }}</td>
	</tr>
	<tr>
		<td>Verzender</td>
		<td>{{ $evidence->sender }}</td>
	</tr>
	<tr>
		<td>Origineel bericht</td>
		<td>{{ $evidence->html_original_message }}</td>
	</tr>
	<tr>
		<td>Encrypted bericht</td>
		<td>{{ $evidence->html_encrypted_message }}</td>
	</tr>
	<tr>
		<td>Gebruikte software / attributen</td>
		<td>{{ $evidence->software }}</td>
	</tr>
</table>

{{ link_to_action('evidences.edit', 'Bewerken', [$evidence->id], ['class' => 'btn btn-success']) }}

{{ Form::open(['route' => ['evidences.destroy', $evidence->id], 'method' => 'delete']) }}
	<button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
{{ Form::close() }}

@stop
