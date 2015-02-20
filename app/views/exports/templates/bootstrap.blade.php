<!DOCTYPE html>
<html lang="{{ Lang::locale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>{{ $project_name }} - Export (HTML)</title>

	<!-- Bootstrap core CSS -->
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/application.css" rel="stylesheet">
</head>


<body>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">

		<div class="col-xs-12">


<div id="export">
	<div class="jumbotron" style="margin-top:2em">
		<h1>{{ $project_name }}</h1>
		<h2>{{ $settings['title'] }}</h2>
		<p>
			<table>
				<tr>
					<th width="125px">Opdrachtgever:</th>
					<td>{{ $settings['customer'] }}</td>
				</tr>
				<tr>
					<th>Datum:</th>
					<td>{{ $settings['date'] }}</td>
				</tr>
				<tr>
					<th>Versie:</th>
					<td>{{ $settings['version'] }}</td>
				</tr>
			</table>
		</p>
	</div>

	<!-- Disclaimer -->
	<div class="panel panel-default">
		<div class="panel-heading"><h1 class="panel-title">Disclaimer</h1></div>
		<div class="panel-body">
			<p>
				{{ $settings['disclaimer'] }}
			</p>
		</div>
	</div>
	<!-- Eind disclaimer -->

	<!-- Disclaimer -->
	<div class="panel panel-default">
		<div class="panel-heading"><h1 class="panel-title">Juridische kader</h1></div>
		<div class="panel-body">
			@foreach($legals as $legal)
        <h5>{{ $legal->name }}</h5>
        <h6>{{ $legal->abbreviation }} (<i>{{ $legal->code }}</i>)</h6>
        <p>{{ $legal->html_body }}</p>
      @endforeach
		</div>
	</div>
	<!-- Eind disclaimer -->

	<!-- Projectleden -->
	<div class="panel panel-default">
		<div class="panel-heading"><h1 class="panel-title">Projectleden</h1></div>
		<div class="panel-body">
			<table>
				@for($i = 0; $i < count($users); $i++)
					@if($users[$i]->first_name != '' || $users[$i]->lastname != '')
						<tr>
							<th>Naam:</th>
							<td>{{ $users[$i]->first_name }} {{ $users[$i]->last_name }}</td>
						</tr>
						@if($users[$i]->student_number != '')
							<tr>
								<th>Studentnummer:</th>
								<td>{{ $users[$i]->student_number }}</td>
							</tr>
						@endif
						@if($users[$i]->email != '')
							<tr>
								<th>E-mail:</th>
								<td>{{ $users[$i]->email }}</td>
							</tr>
						@endif
					@endif
				@endfor
			</table>
		</div>
	</div>
	<!-- Eind projectleden -->

	<!-- Inhoudsopgave -->
	<div class="panel panel-default">
		<div class="panel-heading"><h1 class="panel-title">Inhoudsopgave</h1></div>
		<div class="panel-body">
			<p>Inhoudsopgave HTML export:</p>

			<ol>
				@if(count($logbooksAll) == 1)
					@foreach($logbooks as $logbook)
						<li>{{ $logbook->title }}</li>
					@endforeach
				@else
					<li>Logboeken</li>
						<ul>
							@foreach($logbooksAll as $logbook)
								<li>{{ $logbook->title }}</li>
							@endforeach
						</ul>
					</li>
				@endif

				@if(count($attachments) > 0)
					<li>Bestanden</li>
				@endif

				@if(count($attachmentsAll) > 0)
					<li>Bestanden (uploads)</li>
				@endif

				@if(count($evidences) > 0)
					<li>Verdachten</li>
				@endif

				@if(count($suspects) > 0)
					<li>Verdachten</li>
				@endif
			</ol>
		</div>
	</div>
	<!-- Einde inhoudsopgave -->

	<!-- Logboeken -->
	<div class="panel panel-default">
		<div class="panel-heading"><h1 class="panel-title">Logboeken</h1></div>
		<div class="panel-body">
			<!-- Insert all logbooks -->
				@foreach($logbooksAll as $logbook)
				<div class="panel panel-default">
					<div class="panel-heading"><h2 class="panel-title">{{ $logbook->title }}</h2></div>
					<div class="panel-body">
						@foreach($entriesAll as $entry)
							@if($entry->logbook_id == $logbook->id)
								@include('entries.panel', ['entry' => $entry, 'logbook' => $logbook, 'collapse' => false])
							@endif
						@endforeach
					</div>
				</div>
				@endforeach
			<!-- einde insert all logbooks -->
		</div>
	</div>
	<!-- Eind logboeken -->

	<!-- Bestanden -->
	@if(count($attachments) > 0)
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title">Bestanden</h1></div>
			<div class="panel-body">
				<table class="table">
					<tr>
						<th>Titel</th>
							<th>Bestandsnaam</th>
							<th>Eigenaar</th>
							<th>Grootte</th>
							<th>Hash type</th>
							<th>Hash</th>
							<th>Geupload op</th>
						</tr>
					@foreach($attachments as $att)
						<tr>
							<td>{{ empty($att->title) ? '<em>Geen titel</em>' : $att->title }}</td>
							<td>{{ $att->filename }}</td>
							<td>{{ $att->user->username }}</td>
							<td>{{ format_bytes($att->filesize) }}</td>
							<td>{{ strtoupper($att->hash_algorithm) }}</td>
							<td>{{ $att->hash }}</td>
							<td>{{ $att->created_at }}</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	@endif
	<!-- Einde bestanden -->

	<!-- Alle geuploade bestanden -->
	@if(count($attachmentsAll) > 0)
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title">Bestanden (geupload)</h1></div>
			<div class="panel-body">
				<table class="table">
					<tr>
						<th>Titel</th>
						<th>Filename</th>
						<th>Hash</th>
					</tr>
					@foreach($attachmentsAll as $att)
						<tr>
							<td>{{ empty($att->title) ? '<em>Geen titel</em>' : $att->title }}</td>
							<td>{{ $att->filename }}</td>
							<td>{{ $att->hash }}</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	@endif
	<!-- Einde alle geuploade bestanden -->

	<!-- Bewijzen -->
	@if(count($evidences) > 0)
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title">Bewijzen</h1></div>
			<div class="panel-body">
				<table class="table">
						<tr>
							<th>Titel</th>
							<th>Hash</th>
							<th>Ontvangen op</th>
							<th>Orgineel bericht</th>
						</tr>
					@foreach($evidences as $att)
						<tr>
							<td>{{ empty($att->title) ? '<em>Geen titel</em>' : $att->title }}</td>
							<td>{{ $att->hash }}</td>
							<td>{{ $att->date_received }}</td>
							<td>{{ $att->original_message }}</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	@endif
	<!-- Einde bewijzen -->

	<!-- Verdachten -->
	@if(count($suspects) > 0)
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title">Verdachten</h1></div>
			<div class="panel-body">
				<table class="table">
					<tr>
							<th>Naam</th>
							<th>Alias</th>
							<th>Straat</th>
							<th>Woonplaats</th>
							<th>E-mail</th>
							<th>telefoon</th>
					</tr>
					@foreach($suspects as $att)
					<tr>
							<td>{{ $att->name }}</td>
							<td>{{ $att->alias }}</td>
							<td>{{ $att->street }}</td>
							<td>{{ $att->city }}</td>
							<td>{{ $att->email }}</td>
							<td>{{ $att->phone }}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	@endif
	<!-- Einde verdachten -->

</div>

</div>
</body>
</html>
