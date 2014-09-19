@extends('layouts.application')

@section('content')

<h1>Instellingen</h1>

<script>
  $(function () {
    $('#myTab a:last').tab('show')
  })
</script>

<ul class="nav nav-tabs" role="tablist" id="myTab">
  <li class="active"><a href="#default" role="tab" data-toggle="tab">Standaard</a></li>
  <li><a href="#menu" role="tab" data-toggle="tab">Menu</a></li>
  <li><a href="#suspects" role="tab" data-toggle="tab">Verdachten</a></li>
  <li><a href="#users" role="tab" data-toggle="tab">Gebruikers</a></li>
</ul>

{{ Form::open(['route' => ['settings.update', $settings[0]->id], 'method' => 'put', 'settings' => true]) }}

<div class="tab-content">
  <div class="tab-pane active" id="default">

      @if(Auth::user()->rights === 0)
        <p><br />Voor deze instellingen zijn <b>administrator</b> rechten nodig.</p>
      @else

      <div class="form-group">
        {{ Form::label('project_name', 'Project naam') }}
        {{ Form::text('project_name', $settings[0]->project_name, ['class' => 'form-control']) }}
      </div>

      <button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

      @endif

  </div>
  <div class="tab-pane" id="menu">

      @if(Auth::user()->rights === 0)
        <p><br />Voor deze instellingen zijn <b>administrator</b> rechten nodig.</p>
      @else

      <p>Aangevinkte onderdelen worden zichtbaar gemaakt in het menu.</p>

      <div class="form-group">
          {{ Form::checkbox('vw_menu_entries', 1, $settings[0]->vw_menu_entries) }}
          {{ Form::label('vw_menu_entries', 'Entries') }}
        <br />
          {{ Form::checkbox('vw_menu_logbooks', 1, $settings[0]->vw_menu_logbooks) }}
          {{ Form::label('vw_menu_logbooks', 'Logboeken') }}
        <br />
          {{ Form::checkbox('vw_menu_tasks', 1, $settings[0]->vw_menu_tasks) }}
          {{ Form::label('vw_menu_tasks', 'Taken') }}
        <br />
          {{ Form::checkbox('vw_menu_attachments', 1, $settings[0]->vw_menu_attachments) }}
          {{ Form::label('vw_menu_attachments', 'Bestanden') }}
        <br />
          {{ Form::checkbox('vw_menu_evidences', 1, $settings[0]->vw_menu_evidences) }}
          {{ Form::label('vw_menu_evidences', 'Bewijzen') }}
        <br />
          {{ Form::checkbox('vw_menu_exports', 1, $settings[0]->vw_menu_exports) }}
          {{ Form::label('vw_menu_exports', 'Exports') }}
        <br />
          {{ Form::checkbox('vw_menu_cipher', 1, $settings[0]->vw_menu_cipher) }}
          {{ Form::label('vw_menu_cipher', 'Ciphertool') }}
        <br />
          {{ Form::checkbox('vw_menu_settings', 1, $settings[0]->vw_menu_settings, ['disabled' => 'disabled']) }}
          {{ Form::label('vw_menu_settings', 'Instellingen') }}
        <br />
          {{ Form::checkbox('vw_menu_intro', 1, $settings[0]->vw_menu_intro, ['disabled' => 'disabled']) }}
          {{ Form::label('vw_menu_intro', 'Over') }}
      </div>

      <button type="submit" class="btn btn-primary btn-lg">Opslaan</button>

      @endif

  </div>
  <div class="tab-pane" id="suspects">
      <br />
        <p>
            <a class="btn btn-primary btn-lg" href="{{ action('suspects.create') }}">Nieuwe verdachte</a>
        </p>

      @if(count($suspects) == 0)
        <p>Er zijn <b>geen</b> verdachten gevonden!</p>
      @else

      <table class="table table-hover">
        <tr>
          <th>ID</th>
          <th>Naam</th>
          <th>Alias</th>
          <th>Toegevoegd op</th>
        </tr>

        @foreach($suspects as $suspect)

          <tr>
            <td>{{ $suspect->id }}</td>
            <td>{{ link_to_action('suspects.edit', $suspect->name, [$suspect->id]) }}</td>
            <td>{{ $suspect->alias }}</td>
            <td>{{ $suspect->created_at }}</td>
          </tr>

        @endforeach

      </table>

      @endif

  </div>
  <div class="tab-pane" id="users">
      <br />
        <p>
            <a class="btn btn-primary btn-lg" href="{{ action('users.create') }}">Nieuwe gebruiker</a>
          </p>

      <table class="table table-hover">
      <tr>
        <th>ID</th>
        <th>Gebruikersnaam</th>
        <th>E-mail adres</th>
        <th>Toegevoegd op</th>
        <th>Rechten</th>
      </tr>

      @foreach($users as $user)

      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ link_to_action('users.edit', $user->username, [$user->id]) }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->created_at }}</td>
        @if($user->rights == 0)
          <td>Gebruiker</td>
        @else
          <td>Administrator</td>
        @endif
      </tr>

      @endforeach

      </table>
  </div>
</div>

{{ Form::close() }}

@stop
