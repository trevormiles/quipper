@extends('layout')



@section('title', 'Quipper | View Booking Item')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Booking Items')
@section('link-1-location', '/booking-items')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Booking Item')
@section('link-2-location', '/booking-items/create')


@section('link-3-title', 'Edit Booking Categories')
@section('link-3-location', '/booking-categories')



@section('panel-title', 'View Booking Item')

@section('content')

	<div class="show-booking-item">

		<h1 class="show-booking-item__title">{{ $bookingItem->title }}</h1>
		<div class="show-booking-item__divider"></div>
		
		<h5><span class="show-booking-item__bold">Booking Category:</span> {{ $bookingItem->category }}</h5>
		
		<h5><span class="show-booking-item__bold">First Hour Rate:</span> ${{ $bookingItem->firstHourRate }}</h5>
		<h5><span class="show-booking-item__bold">Additional Hour Rate:</span> ${{ $bookingItem->additionalHourRate }}</h5>
		
		<div class="show-booking-item__button-container">
			<a class="show-booking-item__edit" href="/booking-items/{{ $bookingItem->id }}/edit">Edit</a>

			<form method="POST" action="/booking-items/{{ $bookingItem->id }}">

				@method('DELETE')
				@csrf

				<button class="show-booking-item__delete" type="submit">Delete Booking Item</button>

			</form>
		</div>
		
	</div>


@endsection
