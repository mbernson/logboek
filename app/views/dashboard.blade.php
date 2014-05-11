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
	      <p><a class="btn btn-default" href="/logbooks/1/entries" role="button">Bekijken &raquo;</a></p>
	    </div><!--/span-->
	    <div class="col-6 col-sm-6 col-lg-4">
	      <h2>Gebruikers</h2>
	      <p>Gebruikersmanagement zal binnenkort worden toegevoegd.</p>
	      <!--
	      <p><a class="btn btn-default" href="{{ action('users.index') }}" role="button">Bekijken &raquo;</a></p>
	      -->
	    </div><!--/span-->

	  </div><!--/row-->

	  <div class="row">
	    <div class="col-12 col-sm-12 col-lg-12">

		<h1>Recente entries</h1>
		<table class="table table-hover">
		<tr>
			<th>Titel</th>
			<th>Aantal woorden</th>
			<th>Begonnen op</th>
			<th>Opgeslagen op</th>
		</tr>

		@foreach($entries as $entry)

		<tr>
			<td>{{ link_to_action('logbooks.entries.edit', empty($entry->title) ? 'Naamloos' : $entry->title, [$entry->logbook->id, $entry->id]) }}</td>
			<td>Ongeveer {{ str_word_count($entry->body) }} woorden</td>
			<td>{{ $entry->started_at }}</td>
			<td>{{ $entry->finished_at }}</td>
		</tr>
		@endforeach

		</table>

	    </div><!--/span-->
	  </div><!--/row-->

@stop
