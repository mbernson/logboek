@extends('layouts.application')

@section('content')

<div class="panel panel-default">
  <div class="panel-heading"><h1 class="panel-title">Overview - Chain of Custody</h1></div>
  <div class="panel-body">
    <h4 style="text-decoration:underline;">Algemeen</h4>
    <table>
      <tr>
        <th width="125px;">Naam</th>
        <td>{{ $custody->name }}</td>
      </tr>
      <tr>
        <th>Kenmerk</th>
        <td>{{ $custody->characteristic }}</td>
      </tr>
      <tr>
        <th>Verantwoordelijk</th>
        <td>{{ $custody->responsible }}</td>
      </tr>
      <tr>
        <th>Datum</th>
        <td>{{ $custody->date }}</td>
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
        <th width="125px;">IP</th>
        <td>{{ $custody->signed_ip }}</td>
      </tr>
      <tr>
        <th>Hash</th>
        <td>{{ $custody->signed_hash }}</td>
      </tr>
      <tr>
        <th valign="top">Handtekening</th>
        <td><img style="border:1px solid black;" style="border:1px;" alt="" src="<?php echo $custody->signed_sign; ?>" /></td>
      </tr>
    </table>
    @endif
  </div>
  <div class="panel-footer">
    <p>
      {{ link_to_action('custody.edit', 'Bewerken', [$custody->id], ['class' => 'btn btn-success']) }}

      @if($custody->signed == '0')
        {{ link_to('custody/'.$custody->id.'/sign', 'Onderteken', ['class' => 'btn btn-info']) }}
      @elseif($custody->signed == '1')
        TO DO
      @endif
    </p>
  </div>
</div>
@stop
