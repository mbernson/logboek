@extends('layouts.application')

@section('content')

<div class="jumbotron">
	<h1>IPFIT1 Logboek</h1>
	<p>Welkom bij de logboek-applicatie van project IPFIT1! In deze applicatie kan alle informatie met betrekking tot het forensisch onderzoek op een veilige, centrale plek worden opgeslagen. Aangezien het nog in de ontwikkelfase zit, is de applicatie nog niet helemaal af en compleet.<br />Mocht je tegen dingen aanlopen of idee&euml;n hebben, meld dit dan s.v.p. op <a href="//git.duckson.nl/hsleiden/logboek/issues">GitLab</a>.</p>
</div>

<div class="row">
	<div class="col-6 col-sm-6 col-lg-4">
		<h2>Logboeken</h2>
		<p>Er kunnen meerdere logboeken worden bijgehouden in deze applicatie. Standaard is er &eacute;&eacute;n algemeen logboek gemaakt, en voor iedere gebruiker een individueel logboek.</p>
		<p><a class="btn btn-default" href="{{ action('logbooks.index') }}" role="button">Bekijken &raquo;</a></p>
	</div><!--/span-->
	<div class="col-6 col-sm-6 col-lg-4">
		<h2>Entries</h2>
		<p>Ieder log boek kan een onbeperkt aantal <em>entries</em> bevatten. <em>Entries</em> zijn de daadwerkelijke informatie in je logboek. Ze bestaan uit een titel, tekstuele inhoud (geschreven met Markdown), en start/eind-data.</p>
		<p><a class="btn btn-default" href="/entries" role="button">Bekijken &raquo;</a></p>
	</div><!--/span-->
	<div class="col-6 col-sm-6 col-lg-4">
		<h2>Gebruikers</h2>
		<p>De applicatie beschikt over eenvoudig gebruikersmanagement. Via de profiel-link rechtsboven kun je je wachtwoord veranderen, en er kunnen nieuwe gebruikers toegevoegd worden.</p>
		<p><a class="btn btn-default" href="{{ action('users.index') }}" role="button">Bekijken &raquo;</a></p>
	</div><!--/span-->
</div><!--/row-->

@stop
