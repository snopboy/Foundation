@extends('layouts.master')

@section('content')
	<?php isset($flash) ?: $flash = array(); ?>
	@foreach($flash as $flashes => $value)
		<div class="alert alert-{{ $value['type'] }}">{{ $value['message'] }}</div>
	@endforeach
	<div class="well well2">This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</div>
@stop