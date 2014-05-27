@extends('layouts.application')

@section('content')

@if($file->isNew())
	{{ Form::open(['route' => ['files.store'], 'files' => true]) }}
@else
	{{ Form::open(['route' => ['files.update', $file->id], 'method' => 'put', 'files' => true]) }}
@endif

<div class="form-group">
	{{ Form::label('title', 'Titel') }}
	{{ Form::text('title', $file->title, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('description', 'Beschrijving') }}
	{{ Form::textarea('description', $file->description, ['class' => 'form-control markdown', 'rows' => 10]) }}
	<p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet">Markdown</a>.</em></p>
</div>

<div class="form-group">
	{{ Form::label('file', 'Bestand') }}
	{{ Form::file('upload') }}
	@if($max_size = ini_get('upload_max_filesize'))
	<p><em>Je mag bestanden uploaden van maximaal {{ $max_size }} groot.</em></p>
	@endif
</div>

<div class="form-group">
	{{ Form::label('hash', 'Hash') }}
	{{ Form::text('hash', $file->hash, ['class' => 'form-control', 'placeholder' => 'a28h2b1337fafa42a28h2b1337fafa42']) }}
</div>
<div class="form-group">
	{{ Form::label('hash_algorithm', 'Hashing algoritme') }}
	{{ Form::select('hash_algorithm', File::hashAlgorithmChoices(), $file->hash_algorithm, ['class' => 'form-control']) }}
</div>

<button type="submit" class="btn btn-primary btn-lg">Uploaden</button>

{{ Form::close() }}

@stop
