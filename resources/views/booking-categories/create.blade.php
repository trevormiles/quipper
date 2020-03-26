@extends('layout')



@section('title', 'Quipper | New Booking Category')


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
@section('link-2-active-class', 'sub-nav-active')


@section('link-3-title', 'View Booking items')
@section('link-3-location', '/booking-items')



@section('panel-title', 'New Booking Category')

@section('content')
	
	<div class="booking-categories">
		
		<h3 class="booking-categories__create__title">Booking category name:</h3>
		
		<form method="POST" action="/booking-categories">
		
			{{ csrf_field() }}

			<input class="booking-categories__create__input" type="text" name="category" placeholder="Category Name">

			<button class="booking-categories__create__button" type="submit">Create Booking Category</button>
		
		</form>
		
	</div>

@endsection
