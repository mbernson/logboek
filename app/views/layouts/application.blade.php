<!DOCTYPE html>
<html lang="{{ Lang::locale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico">

	<title>IPFIT1</title>

	<!-- Bootstrap core CSS -->
	<link href="/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/css/offcanvas.css" rel="stylesheet">

	<link href="/css/application.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
	</head>

	<body>
		<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">IPFIT1 Logboek</a>
				</div>
				<div class="collapse navbar-collapse">

					<ul class="nav navbar-nav">
						<li {{ Request::is('entries') || Request::is('/') ? 'class="active"' : '' }}>{{ link_to('/entries', 'Entries') }}</li>
						<li {{ Request::is('logbooks') ? 'class="active"' : '' }}>{{ link_to_route('logbooks.index', 'Logboeken') }}</li>
						<li {{ Request::is('users') ? 'class="active"' : '' }}>{{ link_to_route('users.index', 'Gebruikers') }}</li>
						<li {{ Request::is('tasks') ? 'class="active"' : '' }}>{{ link_to_route('tasks.index', 'Taken') }}</li>
						<li {{ Request::is('attachments') ? 'class="active"' : '' }}>{{ link_to_route('attachments.index', 'Bestanden') }}</li>
						<li {{ Request::is('evidences') ? 'class="active"' : '' }}>{{ link_to_route('evidences.index', 'Bewijzen') }}</li>
						<li {{ Request::is('intro') ? 'class="active"' : '' }}>{{ link_to('/intro', 'Over') }}</li>
					</ul>

					@if(Auth::check())
					<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hallo, {{ Auth::user()->username }} <b class="caret"></b></a>
						<ul class="dropdown-menu">
						<li>{{ link_to_route('users.edit', 'Profiel bewerken', array(Auth::user()->id)) }}</li>
						<li class="divider"></li>
						<li>{{ link_to('/logout', 'Uitloggen') }}</li>
					</ul>
				</li>
			</ul>
			@endif

			</div><!-- /.nav-collapse -->
		</div><!-- /.container -->
	</div><!-- /.navbar -->

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">

		<div class="col-xs-12 col-sm-9">
			<p class="pull-right visible-xs">
				<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
			</p>

			@include('partials.alert')

			@yield('content')
		</div><!--/span-->

		<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">

			@section('sidebar')

			<h3>Logboeken</h3>
			<div class="list-group">
				@foreach($logbooks as $logbook)
				{{ link_to_action('logbooks.show', $logbook->title, [$logbook->id], [
				'class' => 'list-group-item '.(Request::is('logbooks/'.$logbook->id, 'logbooks/'.$logbook->id.'/*') ? 'active' : '')
				]) }}
				@endforeach
			</div>

			@if(isset($user_logbook))
			<p>
			<a class="btn btn-primary btn-lg" href="{{ action('logbooks.entries.create', [$user_logbook->id]) }}">Schrijf in je logboek</a>
			</p>
			@endif

	  <h3>Recente taken</h3>

	  @if(count($recent_tasks) === 0)
		  <p>Geen openstaande taken gevonden.</p>
	  @else
		  <div class="list-group">
			@foreach($recent_tasks as $task)
	          	{{ link_to_action('tasks.show', $task->name, [$task->id], [
        	          	'class' =>  'list-group-item '.(Request::is('tasks/'.$task->id.'*') ? 'active' : '')
          		]) }}
	          	@endforeach
		  </div>
	  @endif
		@show

	</div><!--/span-->
</div><!--/row-->

<hr>

<footer class="muted">
	<p class="pull-left">&copy; <a href="http://duckson.nl">Mathijs Bernson</a>, <a href="http://bartmauritz.nl">Bart Mauritz</a>, 2014</p>
	<p class="pull-right"><a href="https://git.duckson.nl/hsleiden/logboek">Source</a> | <a href="https://git.duckson.nl/hsleiden/logboek/blob/master/LICENSE.md">MIT License</a></p>
</footer>

</div><!--/.container-->

<!-- Bootstrap core JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/offcanvas.js"></script>
<script src="/js/entry.js"></script>
<script src="/js/tasks.js"></script>

@if(App::environment('production') && Config::get('app.piwik_enabled') == true)

{{-- This must be on one line, otherwise blade will not parse it --}}
@include('partials.piwik_tag', ['tracker_url' => Config::get('app.piwik_tracker_url'), 'site_id' => Config::get('app.piwik_site_id')])

@endif

</body>
</html>
