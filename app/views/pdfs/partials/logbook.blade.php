<h2>{{ $logbook->title }}</h2>

<p>Eigenaar: {{ $logbook->user->username }}</p>

@foreach($entries as $entry)

<h2>{{ $entry->title }}</h2>

@if(empty($entry->html_body))
<p><em>Geen inhoud.</em></p>
@else
{{ $entry->html_body }}
@endif

@endforeach

<hr>
