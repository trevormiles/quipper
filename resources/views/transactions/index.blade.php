@extends('layout')


@section('title', 'Quipper | Accounting')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Transactions')
@section('link-1-location', '/accounting')
@section('link-1-active-class', 'sub-nav-active')


@section('panel-title', 'All Transactions')

@section('content')

	<div class="accounting__no-active">
		<h1 class="accounting__no-active__heading">Accounting functionality will be coming soon.</h1>
	</div>

@endsection
