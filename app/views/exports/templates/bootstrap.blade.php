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

	<!-- Juridische kader -->
	@if(count($legals) > 0 && Setting::get('ex_html_sh_legals') == 1)
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
	@endif
	<!-- Eind Juridische kader -->

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

				@if(count($attachments) > 0 && Setting::get('ex_html_sh_attachments') == 1)
					<li>Bestanden</li>
				@endif

				@if(count($attachmentsAll) > 0 && Setting::get('ex_html_sh_attachments') == 1)
					<li>Bestanden (uploads)</li>
				@endif

				@if(count($evidences) > 0 && Setting::get('ex_html_sh_evidences') == 1)
					<li>Bewijzen</li>
				@endif

				@if(count($custody) > 0 && Setting::get('ex_html_sh_coc') == 1)
					<li>Chain of Custody</li>
				@endif

				@if(count($suspects) > 0 && Setting::get('ex_html_sh_suspects') == 1)
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
	@if(count($attachments) > 0 && Setting::get('ex_html_sh_attachments') == 1)
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
	@if(count($attachmentsAll) > 0 && Setting::get('ex_html_sh_attachments') == 1)
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
	@if(count($evidences) > 0 && Setting::get('ex_html_sh_evidences') == 1)
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

	<!-- Chain of Custody -->
	@if(count($custody) > 0 && Setting::get('ex_html_sh_coc') == 1)
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title">Chain of Custody</h1></div>
			<div class="panel-body">
				@foreach($custody as $key)
				<table>
					<tr>
						<th colspan="2"><h4><u>Algemeen</u></h4></th>
					</tr>
					<tr>
						<th width="175px;">Naam</th>
						<td>{{ $key->name }}</td>
					</tr>
					<tr>
						<th>Kenmerk</th>
						<td>{{ $key->characteristic }}</td>
					</tr>
					<tr>
						<th>Locatie</th>
						<td>{{ $key->location }}</td>
					</tr>
					<tr>
						<th>In beslag genomen door</th>
						<td>{{ $key->responsible }}</td>
					</tr>
					<tr>
						<th>In beslag genomen van</th>
						<td>{{ $key->seized }}</td>
					</tr>
					<tr>
						<th>Datum</th>
						<td>{{ $key->date }}</td>
					</tr>
					<tr>
						<th>Timestamp</th>
						<td>{{ $key->time }}</td>
					</tr>
					<tr>
						<th valign="top">Beschrijving</th>
						<td>{{ empty($key->description) ? '<i>Geen beschrijving gevonden.</i>' : $key->html_description }}</td>
					</tr>
					<tr>
						<th valign="top">Details</th>
						<td>{{ empty($key->details) ? '<i>Geen details gevonden.</i>' : $key->html_details }}</td>
					</tr>
					<tr>
						<th colspan="2"><h4><u>Ondertekening</u></h4></th>
					</tr>
					<tr >
	          <th width="175px;">IP</th>
	          <td>{{ $key->signed_ip }}</td>
	        </tr>
	        <tr >
	          <th>Datum</th>
	          <td>{{ $key->signed_date }}</td>
	        </tr>
	        <tr >
	          <th width="125px;">Timestamp</th>
	          <td>{{ $key->signed_time }}</td>
	        </tr>
	        <tr>
	          <th valign="top">Handtekening</th>
	          <td><img style="border:1px solid black;" style="border:1px;" width="300px;" alt="" src="<?php echo $key->signed_sign; ?>" /></td>
	        </tr>
					@if($key->signature == 1)
						<tr>
							<th colspan="2"><h4><u>Ondertekening opdrachtgever</u></h4></th>
						</tr>
						<tr >
		          <th width="175px;">Naam</th>
		          <td>{{ $key->signature_name }}</td>
		        </tr>
		        <tr >
		          <th>IP</th>
		          <td>{{ $key->signature_ip }}</td>
		        </tr>
		        <tr>
		          <th>Datum</th>
		          <td>{{ $key->signature_date }}</td>
		        </tr>
		        <tr>
		          <th>Timestamp</th>
		          <td>{{ $key->signature_time }}</td>
		        </tr>
						<tr>
		          <th valign="top">Handtekening</th>
		          <td><img style="border:1px solid black;" style="border:1px;" width="300px;" alt="" src="<?php echo $key->signature_sign; ?>" /></td>
		        </tr>
						@if(!empty($key->log))
							<tr>
								<th colspan="2"><h4><u>Logs</u></h4></th>
							</tr>
							<tr >
								<td colspan="2">{{ $key->html_log }}</td>
							</tr>
						@endif
						@if($key->returned == 1)
						<tr>
							<th colspan="2"><h4><u>Ondertekening retour opdrachtgever</u></h4></th>
						</tr>
						<tr >
		          <th>IP</th>
		          <td>{{ $key->returned_ip }}</td>
		        </tr>
		        <tr>
		          <th>Datum</th>
		          <td>{{ $key->returned_date }}</td>
		        </tr>
		        <tr>
		          <th>Timestamp</th>
		          <td>{{ $key->returned_time }}</td>
		        </tr>
						<tr>
		          <th valign="top">Handtekening</th>
		          <td><img style="border:1px solid black;" style="border:1px;" width="300px;" alt="" src="<?php echo $key->returned_sign; ?>" /></td>
		        </tr>
						@endif
					@endif
				</table>
				<hr />
				@endforeach
			</div>
		</div>
	@endif
	<!-- Einde Chain of Custody -->

	<!-- Verdachten -->
	@if(count($suspects) > 0 && Setting::get('ex_html_sh_suspects') == 1)
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
							<td>{{ empty($att->street) ? '-' : $att->street }}</td>
							<td>{{ empty($att->city) ? '-' : $att->city }}</td>
							<td>{{ empty($att->email) ? '-' : $att->email }}</td>
							<td>{{ count($att->phone) ? '-' : $att->phone }}</td>
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
