<div class="panel panel-default entry-panel">
	<div class="panel-heading">
		<h3 class="panel-title">{{ link_to_action('logbooks.entries.show', empty($entry->title) ? 'Naamloos' : $entry->title, [$entry->logbook->id, $entry->id]) }}</h3>
		<span class="pull-right">{{ link_to_action('logbooks.show', $entry->logbook->title, [$entry->logbook->id]) }}</span>
	</div>

	<div class="panel-body">
		{{ $entry->html_body or '<p><em>Geen inhoud</em></p>' }}

		<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#metadata-{{ $entry->id }}">Toon metadata</button>
	</div>

	<div class="panel-footer collapse" id="metadata-{{ $entry->id }}">
		<table class="table">
		<tr>
			<th>Eigenaar</th>
			<td>{{ link_to_action('users.show', $entry->logbook->user->username, [$entry->logbook->user->id]) }}</td>
		</tr>
		<tr>
			<th>Logboek</th>
			<td>{{ link_to_action('logbooks.edit', $entry->logbook->title, [$entry->logbook->id]) }}</td>
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
		
		@if($entry->evidence_id != 0)
		<h3>Bewijs</h3>
		<?php $evidence = $entry->getEvidence($entry->evidence_id); ?>
		<table class="table">
			<tr>
				<th>Naam</th>
				<td>{{ link_to_action('evidences.show', $evidence->title, [$entry->evidence_id]) }}</td>
			</tr>
			<tr>
				<th>Afzender</th>
				<td>{{ $evidence->sender; }} </td>
			</tr>
			<tr>
				<th>Datum ontvangen</th>
				<td>{{ $evidence->date_received; }}</td>
			</tr>
		</table>
		@endif

		@if($entry->hasWs())
		<h3>7 W's</h3>
		<table class="table">
		@foreach($entry->get7Ws() as $title => $value)
			@if(!empty($value))
			<tr>
				<th>{{ ucfirst(Lang::get("messages.$title")) }}</th>
				<td>{{{ $value }}}</td>
			</tr>
			@endif
		@endforeach
		</table>
		@endif
	</div>
</div>
