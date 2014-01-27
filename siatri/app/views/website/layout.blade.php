@extends('layout')

@section('styles')
{{ HTML::style('css/twitter.css') }}
@stop

@section('title')
Siatri - General page
@stop
@section('menubuttons')
<div class="buttonsContainer">
	<a class="btn btn-success btn-md" role="button" href="/"><i class="fa fa-home fa-lg"></i> <span >Home</span></a>
	<a class="btn btn-success btn-md" role="button" href="/top"><i class="fa fa-list fa-lg"></i> <span >Top 15</span></a>
	@if (Session::has('user'))
		<a class="btn btn-success btn-md" role="button" href="/gamecreation"><i class="fa fa-gamepad fa-lg"></i> <span>Create Game</span></a>
	@endif
	@parent
</div>
@stop