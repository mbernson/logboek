<div class="logbook">
	<h2>{{ $logbook->title }}</h2>

	<p>Eigenaar: {{ $logbook->user->username }}</p>

	@foreach($entries as $entry)
	<div class="entry">
		<h2>{{ $entry->title }}</h2>

		<table class="meta">
		<tr>
			<th>Eigenaar</th>
			<td>{{{ $logbook->owner->username }}}</td>
		</tr>
		<tr>
			<th>Logboek</th>
			<td>{{{ $logbook->title }}}</td>
		</tr>
		<tr>
			<th>Begonnen om</th>
			<td>{{ $entry->started_at }}</td>
		</tr>
		<tr>
			<th>Afgemaakt om</th>
			<td>{{ $entry->finished_at }}</td>
		</tr>
		</table>

		@if(empty($entry->html_body))
			<p><em>Geen inhoud.</em></p>
		@else
			{{ stripslashes($entry->html_body) }}
		@endif
	</div>

	<hr />

	@endforeach
</div>
