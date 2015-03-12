@extends('layouts.application')

@section('content')

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
<h4 style="text-decoration:underline;">Log</h4>
  {{ Form::open(['route' => ['custodyLogUpdate', $custody->id], 'method' => 'post']) }}
    <div class="form-group">
      {{ Form::textarea('log', $custody->log, ['data-provide' => 'markdown', 'id' => 'markdown-lang', 'style' => 'background-color:white;', 'class' => 'form-control markdown', 'rows' => 20]) }}
      <p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
    </div>
    <button type="submit" class="btn btn-success" id="submit">Update log</button>
  {{ Form::close() }}
@stop
