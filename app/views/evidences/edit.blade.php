@extends('layouts.application')

@section('content')

@if($evidence->isNew())
	{{ Form::open(['route' => ['evidences.store', $evidence->id]]) }}
@else
	{{ Form::open(['route' => ['evidences.update', $evidence->id], 'method' => 'put']) }}
@endif

<div class="form-group">
	{{ Form::label('title', 'Titel') }}
	{{ Form::text('title', $evidence->title, ['class' => 'form-control', 'placeholder' => 'E-mail onderwerp']) }}
</div>

<div class="form-group">
	{{ Form::label('hash', 'hash') }}
	{{ Form::text('hash', $evidence->hash, ['class' => 'form-control', 'placeholder' => 'Controleer de hash eerst op validatie!']) }}
</div>

<div class="form-group">
	{{ Form::label('date_received', 'Datum ontvangen') }}
	{{ Form::text('date_received', $evidence->date_received, ['class' => 'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('sender', 'Verdachte') }}

	@if(count($suspects_options) > 0)
		{{ Form::select('sender', $suspects_options, $evidence->sender, ['class' => 'form-control']) }}
	@else
		<i>Geen verdachten gevonden.</i>
	@endif

</div>

<div class="form-group">
	{{ Form::label('original_message', 'Origineel bericht') }}
	{{ Form::textarea('original_message', $evidence->original_message, ['data-provide' => 'markdown', 'id' => 'markdown-lang', 'class' => 'form-control markdown', 'rows' => 10]) }}
	<p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
</div>

<div class="form-group">
	{{ Form::label('encrypted_message', 'Decrypted bericht') }}
	{{ Form::textarea('encrypted_message', $evidence->encrypted_message, ['data-provide' => 'markdown', 'id' => 'markdown-lang', 'class' => 'form-control markdown', 'rows' => 10]) }}
	<p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
</div>

<div class="form-group">
	{{ Form::label('software', 'Gebruikte software / attributen') }}
	{{ Form::textarea('software', $evidence->software, ['data-provide' => 'markdown', 'id' => 'markdown-lang', 'class' => 'form-control markdown', 'rows' => 10]) }}
	<p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
</div>

<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

{{ Form::close() }}

@stop
