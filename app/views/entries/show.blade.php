@extends('layouts.application')

@section('content')

@include('entries.panel', ['entry' => $entry, 'collapse' => false])

{{ link_to_action('logbooks.entries.edit', 'Bewerken', [$entry->logbook->id, $entry->id], ['class' => 'btn btn-success pull-left']) }}

<div class="pull-right">
	@include('entries.delete_form', ['entry' => $entry])
</div>

@stop
