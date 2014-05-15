@extends('layouts.application')

@section('content')

@if($task->isNew())
	{{ Form::open(['route' => ['tasks.store', $task->id]]) }}
@else
	{{ Form::open(['route' => ['tasks.update', $task->id], 'method' => 'put']) }}
@endif

<div class="form-group">
	{{ Form::label('name', 'Naam') }}
	{{ Form::text('name', $task->name, ['class' => 'form-control', 'placeholder' => 'Taaknaam']) }}
</div>

<div class="form-group">
        {{ Form::label('user_id', 'Toegewezen aan') }}
	{{ Form::select('user_id', $users_options, $task->user_id, ['class' => 'form-control']) }}
</div>

<div class="form-group">
        {{ Form::label('deadline', 'Deadline') }}
        {{ Form::text('deadline', $task->deadline, ['class' => 'form-control']) }}
</div>

<div class="form-group">
        {{ Form::label('description', 'Beschrijving') }}
        {{ Form::textarea('description', $task->description, ['class' => 'form-control markdown', 'rows' => 10]) }}
        <p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet">Markdown</a>.</em></p>
</div>

<div class="form-group">
	<?php $status = ["0" => "openstaand", "1" => "afgesloten"]; ?>

        {{ Form::label('status', 'Taak status') }}
        {{ Form::select('status', $status, null, ['class' => 'form-control']) }}
</div>

<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

{{ Form::close() }}

@stop
