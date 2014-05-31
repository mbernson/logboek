@extends('layouts.application')

@section('content')

@if($attachment->isNew())
	{{ Form::open(['route' => ['attachments.store'], 'files' => true]) }}
@else
	{{ Form::open(['route' => ['attachments.update', $attachment->id], 'method' => 'put', 'attachments' => true]) }}
@endif

<div class="form-group">
	{{ Form::label('title', 'Titel') }}
	{{ Form::text('title', $attachment->title, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('description', 'Beschrijving') }}
	{{ Form::textarea('description', $attachment->description, ['class' => 'form-control markdown', 'rows' => 10]) }}
	<p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet">Markdown</a>.</em></p>
</div>

@if($attachment->isNew())
<div class="form-group">
	{{ Form::label('upload', 'Bestand') }}
	{{ Form::file('upload') }}
	@if($max_size = ini_get('upload_max_filesize'))
	<p><em>Je mag bestanden uploaden van maximaal {{ $max_size }} groot.</em></p>
	@endif
</div>
@endif

@if($attachment->isNew())
<div class="form-group">
	{{ Form::checkbox('public', 1, $attachment->public) }}
	{{ Form::label('public', 'Publiek') }}
	<p><em>Vink dit aan om het bestand vanaf een publieke URL te kunnen benaderen.</em></p>
</div>
@endif

<div class="form-group">
	{{ Form::label('hash', 'Hash') }}
	{{ Form::text('hash', $attachment->hash, ['class' => 'form-control', 'placeholder' => 'a28h2b1337fafa42a28h2b1337fafa42']) }}
</div>
<div class="form-group">
	{{ Form::label('hash_algorithm', 'Hashing algoritme') }}
	{{ Form::select('hash_algorithm', Attachment::hashAlgorithmChoices(), $attachment->hash_algorithm, ['class' => 'form-control']) }}
</div>

@if($attachment->isNew())
<button type="submit" class="btn btn-primary btn-lg">Uploaden</button>
@else
<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>
@endif

{{ Form::close() }}

@stop
