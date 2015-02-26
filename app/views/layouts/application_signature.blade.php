<!DOCTYPE html>
<html lang="{{ Lang::locale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico">

	<title>{{ Setting::get('project_name') }}</title>

	<!-- Bootstrap core CSS -->
	<link href="/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/css/offcanvas.css" rel="stylesheet">

	<link href="/css/application.css" rel="stylesheet">

	<link href="/css/cipher.css" rel="stylesheet">

	<link rel="stylesheet" href="/css/dropzone.css" media="all">

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
					<a class="navbar-brand" href="/">{{ Setting::get('project_name') }}</a>
				</div>
				<div class="collapse navbar-collapse">

					<ul class="nav navbar-nav">
						<li><a>Chain of Custody [{{ $custody->name }}]</a></li>
					</ul>

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

			@if($custody->signature == 0)
				<h3>Ondertekening</h3>
	      <h5>Chain of Custody</h5>

	      <p>
	        <ol>
	          <li>Controleer alle gegevens;</li>
	          <li>Plaats handtekening in grijs vlak:</li>
	          <ul>
	            <li>kies 'opslaan';</li>
	          </ul>
	          <li>Controleer en verbeter naam;</li>
	          <li>Plaats eventuele opmerking;</li>
	          <li>Kies 'ondertekenen' om af te ronden.</li>
	        </ol>
	      </p>
			@else
				<h3>Afronding</h3>
				<h5>Chain of Custody</h5>
				<h6>Met succes ondertekend.</h6>
			@endif

		@show

	</div><!--/span-->
</div><!--/row-->

<hr>

<footer class="muted">
	<p class="pull-left">&copy; 2014 <a href="http://duckson.nl">Mathijs Bernson</a>, <a href="http://bartmauritz.nl">Bart Mauritz</a></p>
	<p class="pull-right"><a href="https://github.com/l0ngestever/logboek/">Source</a> | <a href="https://github.com/l0ngestever/logboek/blob/master/LICENSE.txt">GPL License</a></p>
</footer>

</div><!--/.container-->

<!-- Bootstrap core JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/offcanvas.js"></script>
<script src="/js/entry.js"></script>
<script src="/js/tasks.js"></script>
<script src="/js/dropzone.js"></script>
<script src="/js/signature_pad.js"></script>
<script src="/js/signature_pad_app.js"></script>

</body>
</html>
