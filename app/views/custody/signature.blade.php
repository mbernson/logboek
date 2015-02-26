@extends('layouts.application_signature')

@section('content')

<div class="panel panel-default">
  <div class="panel-heading"><h1 class="panel-title">Ondertekening - Chain of Custody</h1></div>
  <div class="panel-body">
    <h4 style="text-decoration:underline;">Algemeen</h4>
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

    <hr />
    <h4 style="text-decoration:underline;">Ondertekening</h4>
    <table>
      <tr >
        <th width="175px;">IP</th>
        <td>{{ $custody->signed_ip }}</td>
      </tr>
      <tr >
        <th>Datum</th>
        <td>{{ $custody->signed_date }}</td>
      </tr>
      <tr >
        <th width="125px;">Timestamp</th>
        <td>{{ $custody->signed_time }}</td>
      </tr>
      <tr>
        <th valign="top">Handtekening</th>
        <td><img style="border:1px solid black;" style="border:1px;" alt="" src="<?php echo $custody->signed_sign; ?>" /></td>
      </tr>
    </table>
  </div>
  <div class="panel-footer">
    <p>
      <i>Er zal ten alle tijden volgens het forensische proces gewerkt worden. Informeer naar de werkwijze of
      raadpleeg het plan van aanpak of forensische rapport. Het juridische kader zal hierbij een hoofdrol spelen.</i>
    </p>
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
      {{ Form::open(['route' => ['custodySignatureUpdate', $custody->id, $custody->signed_hash], 'method' => 'post']) }}
        <div class="form-group">
          {{ Form::label('signature_name', 'Naam ondertekenaar') }}
          {{ Form::text('signature_name', empty($custody->signature_name) ? $custody->seized : $custody->signature_name, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
          {{ Form::label('signature_remark', 'Opmerking') }}
          {{ Form::textarea('signature_remark', $custody->signature_remark, ['style' => 'background-color:white;', 'class' => 'form-control markdown', 'rows' => 5]) }}
          <p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
        </div>
      </p>
      <p>
        <input type="hidden" value="sign" id="sign" name="signed_sign" />
        <button type="submit" class="btn btn-success" id="submit" style="visibility:hidden;">Ondertekenen</button>
      {{ Form::close() }}
    </p>
  </div>
</div>
@stop
