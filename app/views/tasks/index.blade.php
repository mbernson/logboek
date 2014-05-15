@extends('layouts.application')

@section('content')

<h1>Taken</h1>

<p>
<a class="btn btn-primary btn-lg" href="{{ action('tasks.create') }}">Nieuwe taak</a>
</p>


<table class="table table-hover">
        <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Eigenaar</th>
                <th>Deadline</th>
		<th>Status</th>
        </tr>

        @foreach($tasks as $task)
        <tr>
                <td>{{ $task->id }}</td>
		<td>{{ link_to_action('tasks.show', $task->name, [$task->id]) }}</td>
		<td>{{ link_to_action('users.show', $task->user->username, [$task->user->id]) }}</td>
		<td>{{ $task->deadline }}</td>
		@if($task->status == 0)
                        <td>Openstaand</td>
                @else
                        <td>Afgesloten</td>
                @endif
        </tr>
        @endforeach

</table>


@stop
