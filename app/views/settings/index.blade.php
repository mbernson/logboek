@extends('layouts.application')

@section('content')

<h1>Instellingen</h1>

<ul class="nav nav-tabs" role="tablist" id="myTab">
	<li class="active"><a href="#default" role="tab" data-toggle="tab">Standaard</a></li>
	<li><a href="#menu" role="tab" data-toggle="tab">Menu</a></li>
	<li><a href="#suspects" role="tab" data-toggle="tab">Verdachten</a></li>
	<li><a href="#export" role="tab" data-toggle="tab">Export</a></li>
	<li><a href="#users" role="tab" data-toggle="tab">Gebruikers</a></li>
	<li><a href="#legals" role="tab" data-toggle="tab">Juridische kader</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="default">

		@if(Auth::user()['rights'] == 0)
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

		@if(Auth::user()['rights'] == 0)
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
		@if(Auth::user()['rights'] == 0)
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

		@if(Auth::user()['rights'] == 0)
			<p><br />Voor deze instellingen zijn <b>administrator</b> rechten nodig.</p>
		@else

		<br />

		{{ Form::open(['route' => ['settings.update', 'export'], 'method' => 'put', 'settings' => true]) }}

			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingOne">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
			          Algemeen
			        </a>
			      </h4>
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
			      <div class="panel-body">
							<div class="form-group">
							  <div class="form-group">
							    {{ Form::label('ex_title', 'Export Titel') }}
							    {{ Form::text('ex_title', Setting::get('ex_title'), ['class' => 'form-control']) }}
							  </div>

							  <div class="form-group">
							    {{ Form::label('ex_customer', 'Export Opdrachtgever') }}
							    {{ Form::text('ex_customer', Setting::get('ex_customer'), ['class' => 'form-control']) }}
							  </div>

							  <div class="form-group">
							    {{ Form::label('ex_date', 'Export Datum') }}
							    {{ Form::text('ex_date', Setting::get('ex_date'), ['class' => 'form-control']) }}
							  </div>

							  <div class="form-group">
							    {{ Form::label('ex_version', 'Export Versie') }}
							    {{ Form::text('ex_version', Setting::get('ex_version'), ['class' => 'form-control']) }}
							  </div>

							  <div class="form-group">
							    {{ Form::label('ex_disclaimer', 'Export Disclaimer') }}
							    {{ Form::textarea('ex_disclaimer', Setting::get('ex_disclaimer'), ['class' => 'form-control markdown', 'rows' => 20]) }}
							    <p><em>Je kunt bij het schrijven gebruik maken van <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet" target="_blank">Markdown</a>.</em></p>
							  </div>
							</div>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingTwo">
			      <h4 class="panel-title">
			        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
			          PDF Export
			        </a>
			      </h4>
			    </div>
			    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			      <div class="panel-body">
							<p>
								<i>Selecteer items voor export.</i>
							</p>

							<div class="form-group">
								{{ Form::label('ex_pdf_sh_legals', 'PDF Juridische kader') }}
								{{ Form::select('ex_pdf_sh_legals', ['0' => 'Exporteer niet', '1' => 'Exporteer wel'], Setting::get('ex_pdf_sh_legals'), ['class' => 'form-control']) }}
							</div>

							<div class="form-group">
								{{ Form::label('ex_pdf_sh_evidences', 'PDF Bewijzen') }}
								{{ Form::select('ex_pdf_sh_evidences', ['0' => 'Exporteer niet', '1' => 'Exporteer wel'], Setting::get('ex_pdf_sh_evidences'), ['class' => 'form-control']) }}
							</div>

							<div class="form-group">
								{{ Form::label('ex_pdf_sh_coc', 'PDF Chain of Custody') }}
								{{ Form::select('ex_pdf_sh_coc', ['0' => 'Exporteer niet', '1' => 'Exporteer wel'], Setting::get('ex_pdf_sh_coc'), ['class' => 'form-control']) }}
							</div>

							<div class="form-group">
								{{ Form::label('ex_pdf_sh_attachments', 'PDF Bestanden') }}
								{{ Form::select('ex_pdf_sh_attachments', ['0' => 'Exporteer niet', '1' => 'Exporteer wel'], Setting::get('ex_pdf_sh_attachments'), ['class' => 'form-control']) }}
							</div>

							<div class="form-group">
								{{ Form::label('ex_pdf_sh_suspects', 'PDF Verdachte') }}
								{{ Form::select('ex_pdf_sh_suspects', ['0' => 'Exporteer niet', '1' => 'Exporteer wel'], Setting::get('ex_pdf_sh_suspects'), ['class' => 'form-control']) }}
							</div>
			      </div>
			    </div>
			  </div>
				<div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingThree">
			      <h4 class="panel-title">
			        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
			          HTML Export
			        </a>
			      </h4>
			    </div>
			    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						<div class="panel-body">
							<p>
								<i>Selecteer items voor export.</i>
							</p>

							<div class="form-group">
								{{ Form::label('ex_html_sh_legals', 'HTML Juridische kader') }}
								{{ Form::select('ex_html_sh_legals', ['0' => 'Exporteer niet', '1' => 'Exporteer wel'], Setting::get('ex_html_sh_legals'), ['class' => 'form-control']) }}
							</div>

							<div class="form-group">
								{{ Form::label('ex_html_sh_evidences', 'HTML Bewijzen') }}
								{{ Form::select('ex_html_sh_evidences', ['0' => 'Exporteer niet', '1' => 'Exporteer wel'], Setting::get('ex_html_sh_evidences'), ['class' => 'form-control']) }}
							</div>

							<div class="form-group">
								{{ Form::label('ex_html_sh_coc', 'HTML Chain of Custody') }}
								{{ Form::select('ex_html_sh_coc', ['0' => 'Exporteer niet', '1' => 'Exporteer wel'], Setting::get('ex_html_sh_coc'), ['class' => 'form-control']) }}
							</div>

							<div class="form-group">
								{{ Form::label('ex_html_sh_attachments', 'HTML Bestanden') }}
								{{ Form::select('ex_html_sh_attachments', ['0' => 'Exporteer niet', '1' => 'Exporteer wel'], Setting::get('ex_html_sh_attachments'), ['class' => 'form-control']) }}
							</div>

							<div class="form-group">
								{{ Form::label('ex_html_sh_suspects', 'HTML Verdachte') }}
								{{ Form::select('ex_html_sh_suspects', ['0' => 'Exporteer niet', '1' => 'Exporteer wel'], Setting::get('ex_html_sh_suspects'), ['class' => 'form-control']) }}
							</div>
			      </div>
			    </div>
			  </div>
			</div>

			<input type="submit" class="btn btn-primary btn-lg" value="Opslaan" />
		{{ Form::close() }}

		@endif

	</div>
	<div class="tab-pane" id="users">

		@if(Auth::user()['rights'] == 0)
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
	<div class="tab-pane" id="legals">

		@if(Auth::user()['rights'] == 0)
			<p><br />Voor deze instellingen zijn <b>administrator</b> rechten nodig.</p>
		@else
			<br />
			<p>
				<a class="btn btn-primary btn-lg" href="{{ action('legals.create') }}">Nieuwe wet</a>
			</p>

			@if($legals->count() != 0)
				<table class="table table-hover">
					<tr>
						<th>ID</th>
						<th>Naam</th>
						<th>Afkorting</th>
						<th>Wetboek</th>
						<th>Actief</th>
					</tr>

					@foreach($legals as $legal)

					<tr>
						<td>{{ $legal->id }}</td>
						<td>{{ link_to_action('legals.edit', $legal->name, [$legal->id]) }}</td>
						<td>{{ $legal->abbreviation }}</td>
						<td>{{ $legal->code }}</td>
						@if($legal->active == 0)
							<td>Niet actief</td>
						@else
							<td>Actief</td>
						@endif
					</tr>

					@endforeach
				</table>
			@else
				<p>Er zijn geen wetten gevonden in de tabel <b>juridische kader</b>!</p>
			@endif
		@endif

	</div>
</div>

<script>
$(function () {
	$('#myTab a:last').tab('show')
})
</script>

@stop
