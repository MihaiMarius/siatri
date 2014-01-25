@extends('website.layout')

@section('title')
Siatri - Login
@stop

@section('content')

<div id="top" class="header">
	<div class="vert-text">
		<h1>Welcome to SIATRI</h1>
		<h3>You like challenges ? Sign in and challenge your friends!</h3>
		<a class="btn btn-success btn-lg " role="button" href="/login"><i class="fa fa-twitter fa-3x"></i> <span class="sign-in-text">Sign in with Twitter</span></a>
	</div>
</div>
@stop

@section('menubuttons')
<span class="buttonsContainer">
	<a class="btn btn-success btn-xs" role="button" href="/top"><i class="fa fa-list fa-lg"></i> <span >Top 15</span></a>	
</span>
@stop