@extends('layout')



@section('title', 'Quipper | New Rental Item')


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
@section('link-2-active-class', 'sub-nav-active')


@section('link-3-title', 'Edit Rental Categories')
@section('link-3-location', '/rental-categories')



@section('panel-title', 'New Rental Item')

@section('content')

	<div class="create-rental-item">
		
		<h3 class="create-rental-item__title">New Rental Item</h3>
		
		<form method="POST" action="/rental-items" id="createNewRentalItemForm">

			{{ csrf_field() }}
			
			<div class="create-rental-item__box-container">
				<p class="create-rental-item__label">Rental Category:</p>
				<select class="create-rental-item__select form-control" name="category">
					<?php foreach ($rentalCategories as $rentalCategory) : ?>
						<option value="<?php echo $rentalCategory->category; ?>"><?php echo $rentalCategory->category; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			
			<div class="create-rental-item__flex">
				
				<div class="create-rental-item__box-container create-rental-item__three-quarters">
					<p class="create-rental-item__label">Item Name:</p>
					<input class="create-rental-item__input form-control" type="text" name="title" placeholder="Title of item" id="createRentalItemName">
				</div>

				<div class="create-rental-item__box-container create-rental-item__one-quarter">
					<p class="create-rental-item__label">Quantity:</p>
					<input class="create-rental-item__number form-control" type="number" name="quantity" placeholder="0" min="0" id="createRentalItemQuantity">
				</div>

			</div>
			
			
			<div class="create-rental-item__flex">
				
				<div class="create-rental-item__box-container create-rental-item__half">
					<p class="create-rental-item__label">First Day Rate:</p>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">$</span>
						</div>
						<input type="text" class="create-rental-item__number form-control" name="firstDayRate" placeholder="0.00" id="createRentalItemFirstDayRate">
					</div>
				</div>

				<div class="create-rental-item__box-container create-rental-item__half">
					<p class="create-rental-item__label">Second Day Rate:</p>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">$</span>
						</div>
						<input type="text" class="create-rental-item__number form-control" name="secondDayRate" placeholder="0.00" id="createRentalItemSecondDayRate">
					</div>
				</div>

			</div>
			
			<div class="create-rental-item__submit__container">
				<a class="create-rental-item__submit">Create Rental Item</a>
			</div>

		</form>
		
		
		
		<div class="create-rental-item__errors__container">

			<div class="create-rental-item__errors alert alert-danger" id="no-name" role="alert">
				The name field is required.
			</div>
			
			<div class="create-rental-item__errors alert alert-danger" id="there-are-forbidden-characters" role="alert">
				You are not allowed to use the characters "@", ":" or "?" in the item name.
			</div>
			
			<div class="create-rental-item__errors alert alert-danger" id="no-quantity" role="alert">
				The quantity field is required.
			</div>
			
			<div class="create-rental-item__errors alert alert-danger" id="no-first-day-rate" role="alert">
				The first day rate field is required.
			</div>
			
			<div class="create-rental-item__errors alert alert-danger" id="no-second-day-rate" role="alert">
				The second day rate field is required.
			</div>
			
		</div>
		
		
	</div>

	
	@section('script')
		<script type="text/javascript" src="/js/create-rental-item.js"></script>
	@endsection


@endsection
