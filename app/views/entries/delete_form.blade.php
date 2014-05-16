@if(!$entry->isNew())

{{ Form::open(['route' => ['logbooks.entries.destroy', $entry->logbook->id, $entry->id], 'method' => 'delete']) }}

<button type="submit" class="btn btn-danger pull-right">Verwijderen</button>

{{ Form::close() }}

@endif
