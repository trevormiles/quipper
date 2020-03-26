@extends('layout')



@section('title', 'Quipper | Edit Booking Category')


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



@section('panel-title', 'Edit Booking Category')

@section('content')
	
	<div class="booking-categories">
		
		<h3 class="booking-categories__create__title">Booking category name:</h3>
		
		<form method="POST" action="/booking-categories/{{ $bookingCategory->id }}">
			
			@method('PATCH')
			{{ csrf_field() }}

			<input class="booking-categories__create__input" type="text" name="category" placeholder="Category Name" value="{{ $bookingCategory->category }}">
			
			<input type="hidden" name="oldName" value="{{ $bookingCategory->category }}">
			
			<p><span class="booking-categories__create__bold">Note:</span> All items with this category name will be changed to have the new category name upon pressing submit.</p>

			<button class="booking-categories__create__button" type="submit">Submit Edit</button>
		
		</form>
		
	</div>

@endsection
