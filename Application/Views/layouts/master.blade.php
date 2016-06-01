@inject('settings', '\Foundation\Data\Config')
@inject('generator', 'http.generator')
<!DOCTYPE html>
<html class="no-js" lang="en-US">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{ $settings->get('title') }}</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{{ $generator->generate('home') }}static/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ $generator->generate('home') }}static/css/main.css">
	<script src="{{ $generator->generate('home') }}static/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ $generator->generate('home') }}">{{ $settings->get('title') }}</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="{{ $generator->generate('home') }}">Home</a></li>
				<li><a href="{{ $generator->generate('test') }}">Test</a></li>
				<li><a href="{{ $generator->generate('test') }}/lol">TestRoute</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Snopboy<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="{{ $generator->generate('home') }}">Placeholder</a></li>
						<li class="divider"></li>
						<li><a href="{{ $generator->generate('home') }}">Log Out</a></li>
					</ul>
				</li>
			</ul>
		{{--<form class="navbar-form navbar-right" role="form">
				<div class="form-group">
					<input type="text" placeholder="Email" class="form-control">
				</div>
				<div class="form-group">
					<input type="password" placeholder="Password" class="form-control">
				</div>
				<button type="submit" class="btn btn-success">Sign in</button>
			</form>--}}
		</div>
{{-- /navbar-collapse --}}
	</nav>

{{-- Main jumbotron for a primary marketing message or call to action --}}
	<div class="jumbotron">
		<div class="container">
			<h1>Hello, {{ $name or 'Guest' }}!</h1>
			<p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
			<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="well well2">This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</div>
			</div>
			<div class="col-sm-8">
				<?php isset($_SESSION['flashes']) ?: $_SESSION['flashes'] = array(); ?>
				@foreach($_SESSION['flashes'] as $flash => $value)
					<div class="alert alert-{{ $value['type'] }}">{{ $value['message'] }}</div>
				@endforeach
				@yield('content')
			</div>
		</div>

		<footer class="well well2">
			<div>Copyright &copy; {{ date('Y') }} {{ $settings->get('title') }}, all rights reserved.</div>
		</footer>
	</div>
{{-- /container --}}
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="{{ $generator->generate('home') }}static/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
	<script src="{{ $generator->generate('home') }}static/js/vendor/bootstrap.min.js"></script>
	<script src="{{ $generator->generate('home') }}static/js/main.js"></script>
{{-- Google Analytics: change UA-XXXXX-X to be your site's ID. --}}
	<script>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga('create','UA-XXXXX-X','auto');ga('send','pageview');
	</script>
</body>
</html>