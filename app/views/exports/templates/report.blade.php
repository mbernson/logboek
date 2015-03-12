<!doctype html>

<html>
<head>

	<title>{{ $project_name }}</title>

	<link rel="stylesheet" type="text/css" href="css/pdf.css" />

</head>

<body>

<div id="header">
	<table>

	<tr>
		<td>{{ $project_name }}</td>
		<td style="text-align: right;"></td>
	</tr>

	</table>
</div>

<div id="footer">
	<div class="page-number"></div>
</div>

<div id="voorblad">
	<h1>{{ $project_name }}</h1>
	<h2>{{ $settings['title'] }}</h2>

	<h2>Logboek</h2>

	<table>

	<tr>
		<td>Opdrachtgever</td>
		<td>{{ $settings['customer'] }}</td>
	</tr>
	<tr>
		<td>Datum</td>
		<td>{{ $settings['date'] }}</td>
	</tr>
	<tr>
		<td>Versie</td>
		<td>{{ $settings['version'] }}</td>
	</tr>

	</table>

	<h3>Projectleden</h2>

	<table id="projectleden">

	<tr>
		@for($i = 0; $i < count($users); $i++)
		<td>
			{{-- <img src="{{ $users[$i]->picture->downloadPath() }}" height="240" /> --}}
			{{{ $users[$i]->first_name }}} {{{ $users[$i]->last_name }}}<br>
			{{{ $users[$i]->student_number }}}
		</td>
		@if(($i+1) % 3 === 0)
		</tr><tr>
		@endif
		@endfor
	</tr>

	</table>
</div>

<div id="disclaimer">

	<h1>Disclaimer</h1>
	<p>{{ $settings['disclaimer'] }}</p>

</div>

@if(count($legals) > 0 && Setting::get('ex_pdf_sh_legals') == 1)
	<div id="legals">
		<h1>Juridische kader</h1>
		@foreach($legals as $legal)
			<h3>{{ $legal->name }}</h3>
			<h4>{{ $legal->abbreviation }}</h4>
			<p>{{ $legal->html_body }}</p>
		@endforeach
	</div>
@endif

<div id="inhhoudsopgave">

	<h1>Inhoudsopgave</h1>

		<ol>
			@foreach($logbooks as $logbook)
				<li>{{ $logbook->title }}</li>
			@endforeach

			@if(count($attachmentsAll) > 0 && Setting::get('ex_pdf_sh_attachments') == 1)
				<li>Bestanden</li>
			@endif

			@if(count($evidences) > 0 && Setting::get('ex_pdf_sh_evidences') == 1)
				<li>Bewijzen</li>
			@endif

			@if(count($custody) > 0 && Setting::get('ex_pdf_sh_coc') == 1)
				<li>Chain of Custody</li>
			@endif

			@if(count($suspects) > 0 && Setting::get('ex_pdf_sh_suspects') == 1)
				<li>Verdachten</li>
			@endif
		</ol>

</div>

<h1>Logboeken</h1>


@foreach($logbooks as $logbook)

@include('exports.templates.partials.logbook', ['logbook' => $logbook, 'entries' => $logbook->entries])

@endforeach

@if(count($attachments) > 0 && Setting::get('ex_pdf_sh_attachments') === 1)
	<div id="bestanden">
		<h1>Bestanden</h1>

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
@endif

@if(count($attachmentsAll) > 0 && Setting::get('ex_pdf_sh_attachments') == 1)
	<div id="attachments">
		<h1>Bestanden</h1>

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
@endif

@if(count($evidences) > 0 && Setting::get('ex_pdf_sh_evidences') == 1)
	<div id="evidences">
		<h1>Bewijzen</h1>

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
@endif

@if(count($custody) > 0 && Setting::get('ex_pdf_sh_coc') == 1)
	<div id="coc">
		<h1>Chain of Custody</h1>
			@foreach($custody as $key)
			<table>
				<tr>
					<th colspan="2">Algemeen</th>
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
					<th colspan="2">Ondertekening</th>
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
				<tr>
					<th colspan="2">Ondertekening opdrachtgever</th>
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
          <th>Handtekening</th>
          <td><img style="border:1px solid black;" style="border:1px;" width="300px;" alt="" src="<?php echo $key->signature_sign; ?>" /></td>
        </tr>
			</table>
			@endforeach
	</div>
@endif

@if(count($suspects) > 0 && Setting::get('ex_pdf_sh_suspects') == 1)
	<div id="suspects">
		<h1>Verdachten</h1>

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
@endif

</body>
</html>
