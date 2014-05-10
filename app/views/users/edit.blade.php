@extends('layouts.application')

@section('content')

{{ Form::open(['route' => ['logbooks.entries.store', $logbook->id]]) }}

<div class="form-group">
	{{ Form::label('title', 'Titel') }}
	{{ Form::text('title', $entry->title, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('body', 'Inhoud') }}
	{{ Form::textarea('body', $entry->body, ['class' => 'form-control', 'rows' => 10]) }}
	<p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/syntaxleiden/statuten/blob/master/README.md">Markdown</a></em></p>
</div>

<div class="form-group">
	{{ Form::label('started_at', 'Begonnen om') }}
	{{ Form::text('started_at', $entry->started_at, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('finished_at', 'Afgemaakt om') }}
	{{ Form::text('finished_at', $entry->finished_at, ['class' => 'form-control', 'placeholder' => 'Als je dit leeg laat wordt het de datum dat je op "Opslaan" drukt']) }}
</div>

<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

{{ Form::close() }}

@stop
