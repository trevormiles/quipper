@extends('layout')



@section('title', 'Quipper | New Booking Item')


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
@section('link-2-active-class', 'sub-nav-active')


@section('link-3-title', 'Edit Booking Categories')
@section('link-3-location', '/booking-categories')



@section('panel-title', 'New Booking Item')

@section('content')

	<div class="create-booking-item">
		
		<h3 class="create-booking-item__title">New Booking Item</h3>
		
		<form method="POST" action="/booking-items" id="createNewBookingItemForm">

			{{ csrf_field() }}
			
			<div class="create-booking-item__box-container">
				<p class="create-booking-item__label">Booking Category:</p>
				<select class="create-booking-item__select form-control" name="category">
					<?php foreach ($bookingCategories as $bookingCategory) : ?>
						<option value="<?php echo $bookingCategory->category; ?>"><?php echo $bookingCategory->category; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			
			<div class="create-booking-item__flex">
				
				<div class="create-booking-item__box-container">
					<p class="create-booking-item__label">Item Name:</p>
					<input class="create-booking-item__input form-control" type="text" name="title" placeholder="Title of item" id="createBookingItemName">
				</div>

			</div>
			
			
			<div class="create-booking-item__flex">
				
				<div class="create-booking-item__box-container create-booking-item__half">
					<p class="create-booking-item__label">First Hour Rate:</p>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">$</span>
						</div>
						<input type="text" class="create-booking-item__number form-control" name="firstHourRate" placeholder="0.00" id="createBookingItemFirstHourRate">
					</div>
				</div>

				<div class="create-booking-item__box-container create-booking-item__half">
					<p class="create-booking-item__label">Additional Hour Rate:</p>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">$</span>
						</div>
						<input type="text" class="create-booking-item__number form-control" name="additionalHourRate" placeholder="0.00" id="createBookingItemAdditionalHourRate">
					</div>
				</div>

			</div>
			
			<div class="create-booking-item__submit__container">
				<a class="create-booking-item__submit">Create Booking Item</a>
			</div>

		</form>
		
		
		
		<div class="create-booking-item__errors__container">

			<div class="create-booking-item__errors alert alert-danger" id="no-name" role="alert">
				The name field is required.
			</div>
			
			<div class="create-booking-item__errors alert alert-danger" id="there-are-forbidden-characters" role="alert">
				You are not allowed to use the characters "@", ":" or "?" in the item name.
			</div>
			
			<div class="create-booking-item__errors alert alert-danger" id="no-first-hour-rate" role="alert">
				The first hour rate field is required.
			</div>
			
			<div class="create-booking-item__errors alert alert-danger" id="no-additional-hour-rate" role="alert">
				The additional hour rate field is required.
			</div>
			
		</div>
		
		
	</div>

	
	@section('script')
		<script type="text/javascript" src="/js/create-booking-item.js"></script>
	@endsection


@endsection
