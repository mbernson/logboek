<!DOCTYPE html>

<html lang="{{ Lang::locale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico">

	<title>{{ Lang::get('messages.log_in') }}</title>

	<!-- Bootstrap core CSS -->
	<link href="/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/css/signin.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>

	<div class="container">

		<form class="form-signin" role="form" action="/login" method="post">
			<h2 class="form-signin-heading">{{ Lang::get('messages.please_log_in') }}</h2>

			@include('partials.alert')

			<input type="text" name="username" class="form-control" placeholder="{{ Lang::get('messages.username') }}" required autofocus>
			<input type="password" name="password" class="form-control" placeholder="{{ Lang::get('messages.password') }}" required>
			<label class="checkbox">
				<input type="checkbox" name="remember" value="true"> {{ Lang::get('messages.remember_me') }}
			</label>
			<button class="btn btn-lg btn-primary btn-block" type="submit">{{ Lang::get('messages.log_in') }}</button>
		</form>

	</div> <!-- /container -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
</body>
</html>
