@extends('layouts.application')

@section('content')

@include('partials.modals')

<div class="panel panel-default">
  <div class="panel-heading"><h1 class="panel-title">Overview - Chain of Custody</h1></div>
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

    @if($custody->signed == 1)
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

      <hr />
      <h4 style="text-decoration:underline;">Ondertekening opdrachtgever</h4>

    @endif

    @if($custody->signed == 1 && $custody->signature == 1)

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
          <td><img style="border:1px solid black;" style="border:1px;" alt="" src="<?php echo $custody->signature_sign; ?>" /></td>
        </tr>
      </table>

    @elseif($custody->signed == 1 && $custody->signature == 0)

      <p>Opdrachtgever heeft nog niet getekend. Klik op onderstaande button 'onderteken' om de link te ontvangen.</p>

    @endif
  </div>
  <div class="panel-footer">
    <p>
      @if($custody->signed == 1 && $custody->signature == 1)
        Chain of custody met succes ingenomen. Wijzigingen / verwijderingen zijn niet meer mogelijk.
      @else
        {{ link_to_action('custody.edit', 'Bewerken', [$custody->id], ['class' => 'btn btn-success']) }}

        @if($custody->signed == '0')
          {{ link_to('custody/'.$custody->id.'/sign', 'Onderteken', ['class' => 'btn btn-info']) }}
        @elseif($custody->signed == '1')
          <?php
            $link = Request::root().'/custody/'.$custody->id.'/signature/'.$custody->signed_hash;
          ?>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-title="{{ $custody->name }}" data-content="Opdrachtgever dient Chain of Custody te ondertekenen. Geef volgende link om opdrachtgever te laten tekenen." data-url="{{ $link }}">Onderteken</button>
        @endif
      @endif
    </p>
  </div>
</div>
@stop
