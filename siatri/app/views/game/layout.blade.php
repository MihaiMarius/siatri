@extends('layout')

@section('scripts')
    {{ HTML::script('js/lib/autobahn.min.js') }} 
@stop

@section('title')
    Siatri - Game Area
@stop

@section('menubuttons')
<span class="buttonsContainer">
	<a class="btn btn-success btn-xs" role="button" href="/"><i class="fa fa-home fa-lg"></i> <span >Home</span></a>
	<a class="btn btn-success btn-xs" role="button" href="/top"><i class="fa fa-list fa-lg"></i> <span >Top 15</span></a>
</span>
@stop