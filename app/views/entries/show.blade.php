@extends('layouts.application')

@section('content')

@include('entries.panel', ['entry' => $entry, 'collapse' => false])

@if($logbook->user_id == (Auth::user()->id) || $logbook->user_id == 0)
	{{ link_to_action('logbooks.entries.edit', 'Bewerken', [$entry->logbook->id, $entry->id], ['class' => 'btn btn-success pull-left']) }}

	<div class="pull-right">
		@include('entries.delete_form', ['entry' => $entry])
	</div>
@endif

@stop
