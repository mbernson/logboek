% {{ $title."\n" }}
% Projectgroep 2, INF1G

# {{ $title."\n" }}

## Project forensisch onderzoek

@foreach($logbooks as $logbook)

# {{{ $logbook->title }}}

Eigenaar: {{{ $logbook->owner->first_name }}} {{{ $logbook->owner->last_name }}}

@foreach($logbook->entries as $entry)

# {{{ $entry->title }}}


Begonnen op: {{ $entry->started_at }}


Geëindigd op: {{ $entry->finished_at }}


{{ $entry->body }}	

--------------------------------
@endforeach

@endforeach
