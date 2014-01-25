@extends('website.layout')

@section('title')
Siatri - Top Players
@stop

@section('styles')
    {{ HTML::style('css/top.css') }}
@stop
@section('scripts')
    {{ HTML::script('js/top.js') }}
@stop

@section('content')

<div data-bind="with: $data" id="koWrapper" class="top-wrapper">
	<table class="table table-hover table-bordered table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>User</th>
				<th>Games</th>
				<th>Points</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: players">
			<tr>
				<td>
					<span data-bind="text: $index() + 1"></span>
				</td>
				<td>
					<div>
						<span class="user-profile-img"><img data-bind="attr : {'src' : profileImageSrc}"></span>
						<span><a data-bind="text: username,attr : { 'href' : twitterUrl }"></a></span>
					</div>
				</td>
				<td><span data-bind="text: games"></span></td>
				<td><span data-bind="text: points"></span></td>
			</tr>
		</tbody>
	</table>
</div>
@stop