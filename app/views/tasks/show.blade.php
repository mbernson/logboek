@extends('layouts.application')

@section('content')

<h1><em>Taak informatie</em></h1>

<table class="table table-hover">
        <tr>
                <td>ID</td>
                <td>{{ $task->id }}</td>
        </tr>
        <tr>
                <td>Naam</td>
		<td>{{ $task->name }} </td>
        </tr>
        <tr>
                <td>Eigenaar</td>
                <td>{{ $task->user->username }}</td>
        </tr>
        <tr>
                <td>Start</td>
                <td>{{ $task->created_at }}</td>
        </tr>
</table>

{{ link_to_action('tasks.edit', 'Bewerken', [$task->id], ['class' => 'btn btn-success']) }}

{{ Form::open(['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) }}
	<button type="submit" class="btn btn-danger pull-right">Verwijderen</button>
{{ Form::close() }}

@stop
