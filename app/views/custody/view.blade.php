@extends('layouts.application_signature')

@section('content')

<div class="panel panel-default">
  <div class="panel-heading"><h1 class="panel-title">Overzicht - Chain of Custody</h1></div>
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
        <td><img style="border:1px solid black;" style="border:1px;" width="300px;" alt="" src="<?php echo $custody->signed_sign; ?>" /></td>
      </tr>
    </table>

    <hr />
    <h4 style="text-decoration:underline;">Ondertekening opdrachtgever</h4>
    <table>
      <tr >
        <th width="175px;">Naam</th>
        <td>{{ $custody->signature_name }}</td>
      </tr>
      <tr >
        <th>IP</th>
        <td>{{ $custody->signature_ip }}</td>
      </tr>
      <tr>
        <th>Datum</th>
        <td>{{ $custody->signature_date }}</td>
      </tr>
      <tr>
        <th>Timestamp</th>
        <td>{{ $custody->signature_time }}</td>
      </tr>
        @if($custody->signature_remark)
          <tr>
            <th>Opmerking</th>
            <td>{{ $custody->html_signature_remark }}
          </tr>
        @endif
      <tr>
        <th valign="top">Handtekening</th>
        <td><img style="border:1px solid black;" style="border:1px;" width="300px;" alt="" src="<?php echo $custody->signature_sign; ?>" /></td>
      </tr>
    </table>

    @if($custody->returned == 1)
      @if(!empty($custody->log))
        <hr />
        <h4 style="text-decoration:underline;">Log</h4>
        <p>{{ $custody->html_log }}</p>
      @endif

      <hr />
      <h4 style="text-decoration:underline;">Ondertekening retour opdrachtgever</h4>
      <table>
        <tr >
          <th>IP</th>
          <td>{{ $custody->returned_ip }}</td>
        </tr>
        <tr>
          <th>Datum</th>
          <td>{{ $custody->returned_date }}</td>
        </tr>
        <tr>
          <th>Timestamp</th>
          <td>{{ $custody->returned_time }}</td>
        </tr>
          @if($custody->returned_remark)
            <tr>
              <th>Opmerking</th>
              <td>{{ $custody->html_returned_remark }}
            </tr>
          @endif
        <tr>
          <th valign="top">Handtekening</th>
          <td><img style="border:1px solid black;" style="border:1px;" width="300px;" alt="" src="<?php echo $custody->signature_sign; ?>" /></td>
        </tr>
      </table>
    @endif

  </div>
  <div class="panel-footer">
    <p>
      Deze pagina zal maar eenmalig worden getoond. Print de pagina om deze op te slaan.
    </p>
  </div>
</div>
@stop
