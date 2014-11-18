@extends('layouts.application')

@section('content')

<h1>Instellingen</h1>
<h1>{{ Auth::user()->rights }}</h1>

<script>
$(function () {
	$('#myTab a:last').tab('show')
})
</script>

<ul class="nav nav-tabs" role="tablist" id="myTab">
	<li class="active"><a href="#default" role="tab" data-toggle="tab">Standaard</a></li>
	<li><a href="#menu" role="tab" data-toggle="tab">Menu</a></li>
	<li><a href="#suspects" role="tab" data-toggle="tab">Verdachten</a></li>
	<li><a href="#export" role="tab" data-toggle="tab">Export</a></li>
	<li><a href="#users" role="tab" data-toggle="tab">Gebruikers</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="default">

		@if(Auth::user()->rights === 0)
			<p><br />Voor deze instellingen zijn <b>administrator</b> rechten nodig.</p>
		@else

		<br />
		{{ Form::open(['route' => ['settings.update', 'project_name'], 'method' => 'put', 'settings' => true]) }}
			<div class="form-group">
				{{ Form::label('project_name', 'Project naam') }}
				{{ Form::text('project_name', Setting::get('project_name'), ['class' => 'form-control']) }}
			</div>

			<button type="submit" class="btn btn-primary btn-lg">Opslaan</button>
		{{ Form::close() }}

		@endif

	</div>

	<div class="tab-pane" id="menu">

		@if(Auth::user()->rights === 0)
			<p><br />Voor deze instellingen zijn <b>administrator</b> rechten nodig.</p>
		@else

		<br />
		{{ Form::open(['route' => ['settings.update', 'menu'], 'method' => 'put', 'settings' => true]) }}
			<p>Aangevinkte onderdelen worden zichtbaar gemaakt in het menu.</p>

			<div class="form-group">
				@foreach($features as $feature)
					@if($feature != 'settings' && $feature != 'intro')
						{{ Form::checkbox($feature, 1, Setting::contains('menu', $feature)) }}
						{{ Form::label('vw_menu_entries', ucfirst($feature)) }}
					@endif
					<br />
				@endforeach

				<input type="submit" class="btn btn-primary btn-lg" value="Opslaan" />
			</div>
		{{ Form::close() }}

		@endif

	</div>
	<div class="tab-pane" id="suspects">
		@if(Auth::user()->rights === 0)
			<p><br />Voor deze instellingen zijn <b>administrator</b> rechten nodig.</p>
		@else
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
		@endif

	</div>
	<div class="tab-pane" id="export">

		@if(Auth::user()->rights === 0)
			<p><br />Voor deze instellingen zijn <b>administrator</b> rechten nodig.</p>
		@else

		<br />
		{{ Form::open(['route' => ['settings.update', 'export'], 'method' => 'put', 'settings' => true]) }}
			<div class="form-group">
				<div class="form-group">
					{{ Form::label('ex_pdf_title', 'PDF Titel') }}
					{{ Form::text('ex_pdf_title', Setting::get('ex_pdf_title'), ['class' => 'form-control']) }}
				</div>

				<div class="form-group">
					{{ Form::label('ex_pdf_customer', 'PDF Opdrachtgever') }}
					{{ Form::text('ex_pdf_customer', Setting::get('ex_pdf_customer'), ['class' => 'form-control']) }}
				</div>

				<div class="form-group">
					{{ Form::label('ex_pdf_date', 'PDF Datum') }}
					{{ Form::text('ex_pdf_date', Setting::get('ex_pdf_date'), ['class' => 'form-control']) }}
				</div>

				<div class="form-group">
					{{ Form::label('ex_pdf_version', 'PDF Versie') }}
					{{ Form::text('ex_pdf_version', Setting::get('ex_pdf_version'), ['class' => 'form-control']) }}
				</div>

				<div class="form-group">
					{{ Form::label('ex_pdf_disclaimer', 'Inhoud') }}
					{{ Form::textarea('ex_pdf_disclaimer', Setting::get('ex_pdf_disclaimer'), ['class' => 'form-control markdown', 'rows' => 20]) }}
					<p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
				</div>
				<input type="submit" class="btn btn-primary btn-lg" value="Opslaan" />
			</div>
		{{ Form::close() }}

		@endif

	</div>
	<div class="tab-pane" id="users">

		@if(Auth::user()->rights === 0)
			<p><br />Voor deze instellingen zijn <b>administrator</b> rechten nodig.</p>
		@else
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
		@endif
		</table>
	</div>
</div>

@stop
