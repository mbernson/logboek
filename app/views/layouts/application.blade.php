<!DOCTYPE html>
<html lang="en">
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
	    <li {{ Request::is('logbooks') ? 'class="active"' : '' }}>{{ link_to_route('logbooks.index', 'Logboeken') }}</li>
	    <li {{ Request::is('users') ? 'class="active"' : '' }}>{{ link_to_route('users.index', 'Gebruikers') }}</li>
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

	@yield('content')
        </div><!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">

	@section('sidebar')

          <div class="list-group">
	  @foreach($logbooks as $logbook)
	  {{ link_to_action('logbooks.show', $logbook->title, [$logbook->id], [
		  'class' =>  'list-group-item '.(Request::is('logbooks/'.$logbook->id.'*') ? 'active' : '')
	  ]) }}
	  @endforeach
          </div>

	@show

        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
	<p>&copy; Hogeschool Leiden 2014</p>
      </footer>

    </div><!--/.container-->



    <!-- Bootstrap core JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/offcanvas.js"></script>
    <script src="/js/entry.js"></script>
  </body>
</html>
