@extends('layouts.application')

@section('content')

<div class="panel panel-default">
  <div class="panel-heading"><h1 class="panel-title">Ondertekening - Chain of Custody</h1></div>
  <div class="panel-body">
    <table>
      <tr>
        <th width="175px;">Naam</th>
        <td>{{ $custody->name }}</td>
      </tr>
      <tr>
        <th>Kenmerk</th>
        <td>{{ $custody->characteristic }}</td>
      </tr>
      <tr>
        <th>Locatie</th>
        <td>{{ $custody->location }}</td>
      </tr>
      <tr>
        <th>In beslag genomen door</th>
        <td>{{ $custody->responsible }}</td>
      </tr>
      <tr>
        <th>In beslag genomen van</th>
        <td>{{ $custody->seized }}</td>
      </tr>
      <tr>
        <th>Datum</th>
        <td>{{ $custody->date }}</td>
      </tr>
      <tr>
        <th>Timestamp</th>
        <td>{{ $custody->time }}</td>
      </tr>
      <tr>
        <th valign="top">Beschrijving</th>
        <td>{{ empty($custody->description) ? '<i>Geen beschrijving gevonden.</i>' : $custody->html_description }}</td>
      </tr>
      <tr>
        <th valign="top">Details</th>
        <td>{{ empty($custody->details) ? '<i>Geen details gevonden.</i>' : $custody->html_details }}</td>
      </tr>
    </table>
  </div>
  <div class="panel-footer">
    <p>
      <div id="signature-pad" class="m-signature-pad">
  	    <div class="m-signature-pad--body">
  				<canvas style="background-color:gray; max-width:300px; height:150px;"></canvas>
  	    </div>
  	    <div class="m-signature-pad--footer">
  	      <div class="description">Onderteken in bovenstaand venster.</div>
  	      <button class="btn btn-info btn-xs" data-action="clear">Opnieuw</button>
  	      <button class="btn btn-info btn-xs" data-action="save">Opslaan</button>
  	    </div>
    	</div>
    </p>
    <p>
      {{ Form::open(['route' => ['custodySignUpdate', $custody->id], 'method' => 'post']) }}
        <input type="hidden" value="sign" id="sign" name="signed_sign" />
        <button type="submit" class="btn btn-success" id="submit" style="visibility:hidden;">Ondertekenen</button>
      {{ Form::close() }}
    </p>
  </div>
</div>
@stop
