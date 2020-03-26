@extends('layout')



@section('title', 'Quipper | View Rental Item')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Rental Items')
@section('link-1-location', '/rental-items')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Item')
@section('link-2-location', '/rental-items/create')


@section('link-3-title', 'Edit Rental Categories')
@section('link-3-location', '/rental-categories')



@section('panel-title', 'View Rental Item')

@section('content')

	<div class="show-rental-item">

		<h1 class="show-rental-item__title">{{ $rentalItem->title }}</h1>
		<div class="show-rental-item__divider"></div>
		
		<h5><span class="show-rental-item__bold">Quantity:</span> {{ $rentalItem->quantity }}</h5>
		<h5><span class="show-rental-item__bold">Rental Category:</span> {{ $rentalItem->category }}</h5>
		
		<h5><span class="show-rental-item__bold">First Day Rate:</span> ${{ $rentalItem->firstDayRate }}</h5>
		<h5><span class="show-rental-item__bold">Second Day Rate:</span> ${{ $rentalItem->secondDayRate }}</h5>
		
		<div class="show-rental-item__button-container">
			<a class="show-rental-item__edit" href="/rental-items/{{ $rentalItem->id }}/edit">Edit</a>

			<form method="POST" action="/rental-items/{{ $rentalItem->id }}">

				@method('DELETE')
				@csrf

				<button class="show-rental-item__delete" type="submit">Delete Rental Item</button>

			</form>
		</div>
		
	</div>


@endsection
