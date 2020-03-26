@extends('layout')



@section('title', 'Quipper | View Booking Category')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Booking Categories')
@section('link-1-location', '/booking-categories')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Booking Category')
@section('link-2-location', '/booking-categories/create')


@section('link-3-title', 'View Booking items')
@section('link-3-location', '/booking-items')



@section('panel-title', 'View Booking Category')

@section('content')
	
	<div class="booking-categories">
		
		<h2><?php echo $bookingCategory->category; ?></h2>
		
	</div>

@endsection
