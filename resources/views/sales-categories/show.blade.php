@extends('layout')



@section('title', 'Quipper | View Sales Category')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Sales Categories')
@section('link-1-location', '/sales-categories')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Sales Category')
@section('link-2-location', '/sales-categories/create')


@section('link-3-title', 'View Sales items')
@section('link-3-location', '/sales-items')



@section('panel-title', 'View Sales Category')

@section('content')
	
	<div class="sales-categories">
		
		<h2><?php echo $salesCategory->category; ?></h2>
		
	</div>

@endsection
