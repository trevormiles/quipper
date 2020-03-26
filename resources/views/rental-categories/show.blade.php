@extends('layout')



@section('title', 'Quipper | View Rental Category')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Rental Categories')
@section('link-1-location', '/rental-categories')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Rental Category')
@section('link-2-location', '/rental-categories/create')


@section('link-3-title', 'View Rental items')
@section('link-3-location', '/rental-items')



@section('panel-title', 'View Rental Category')

@section('content')
	
	<div class="rental-categories">
		
		<h2><?php echo $rentalCategory->category; ?></h2>
		
	</div>

@endsection
