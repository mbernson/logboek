<!doctype html>

<html>
<head>

<title>IPFIT1 Forensisch</title>

<style type="text/css">
@page {
	margin: 1.5cm;
}

body {
	font-family: sans-serif;
	font-size: 11pt;
	margin: 0.5cm 0;
	text-align: justify;
}

#header,
#footer {
	position: fixed;
	left: 0;
	right: 0;
	color: #aaa;
	font-size: 0.9em;
}

#header {
	top: 0;
	border-bottom: 0.1pt solid #aaa;
}

#footer {
	bottom: 0;
	border-top: 0.1pt solid #aaa;
}

#header table,
#footer table {
	width: 100%;
	border-collapse: collapse;
	border: none;
}

#header td,
#footer td {
	padding: 0;
	width: 50%;
}

.page-number {
	text-align: center;
}

.page-number:before {
	content: "Pagina " counter(page);
}

hr {
	page-break-after: always;
	border: 0;
}

pre, code {
	font-size: 8pt;
}

#voorblad {
	text-align: center;
}

#voorblad table {
	margin: 0 auto;
}
#voorblad table tr {
margin: 32px;
}
</style>

</head>

<body>

<div id="header">
	<table>

	<tr>
		<td>{{ $title }}</td>
		<td style="text-align: right;">Tekst</td>
	</tr>

	</table>
</div>

<div id="footer">
	<div class="page-number"></div>
</div>

<div id="voorblad">
	<h1>{{ $title }}</h1>
	<h2>Project forensisch onderzoek</h2>

	<h2>Logboek</h2>

	<table>

	<tr>
		<td>Module</td>
		<td>IPFIT1</td>
	</tr>
	<tr>
		<td>Moduleleider</td>
		<td>Peter van der Wijden</td>
	</tr>
	<tr>
		<td>Datum</td>
		<td>06-05-2014</td>
	</tr>
	<tr>
		<td>Versie</td>
		<td>0.1 (concept)</td>
	</tr>

	</table>

	<h3>Projectleden</h2>

	<table id="projectleden">

	<tr>
		<td>
			<img src="http://placekitten.com/200/240" />
			Mathijs Bernson<br>s1082020
		</td>
		<td>
			<img src="http://placekitten.com/200/240" />
			Mathijs Bernson<br>s1082020
		</td>
		<td>
			<img src="http://placekitten.com/200/240" />
			Mathijs Bernson<br>s1082020
		</td>
	</tr>
	<tr>
		<td>
			<img src="http://placekitten.com/200/240" />
			Mathijs Bernson<br>s1082020
		</td>
		<td></td>
		<td>
			<img src="http://placekitten.com/200/240" />
			Mathijs Bernson<br>s1082020
		</td>
	</tr>

	</table>
</div>

<hr>

<div id="inhhoudsopgave">

<h1>Inhoudsopgave</h1>

<ul>
@foreach($logbooks as $logbook)
	<li>{{ $logbook->title }}</li>
@endforeach
</ul>

</div>

<hr>

<h1>Logboeken</h1>

@foreach($logbooks as $logbook)

@include('pdfs.partials.logbook', ['logbook' => $logbook, 'entries' => $logbook->entries])

@endforeach

</body>
</html>
