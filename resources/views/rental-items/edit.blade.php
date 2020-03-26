@extends('layout')



@section('title', 'Quipper | Edit Rental Item')


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



@section('panel-title', 'Edit Rental Item')

@section('content')

	<div class="edit-rental-item">
		
		<h3 class="edit-rental-item__title">Edit Rental Item</h3>
		
		<form method="POST" action="/rental-items/{{ $rentalItem->id }}" id="submitEditRentalItemForm">
			
			@method('PATCH')
			{{ csrf_field() }}
			
			<div class="edit-rental-item__box-container">
				<p class="edit-rental-item__label">Rental Category:</p>
				<select class="edit-rental-item__select form-control" name="category">
					<?php foreach ($rentalCategories as $rentalCategory) : ?>
						<option value="<?php echo $rentalCategory->category; ?>" <?php if ($rentalCategory->category == $rentalItem->category) {echo "selected";} ?> ><?php echo $rentalCategory->category; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			
			<div class="edit-rental-item__flex">
				
				<div class="edit-rental-item__box-container edit-rental-item__three-quarters">
					<p class="edit-rental-item__label">Item Name:</p>
					<input class="edit-rental-item__input form-control" type="text" name="title" placeholder="Title of item" value="{{$rentalItem->title}}" id="editRentalItemName">
				</div>

				<div class="edit-rental-item__box-container edit-rental-item__one-quarter">
					<p class="edit-rental-item__label">Quantity:</p>
					<input class="edit-rental-item__number form-control" type="number" name="quantity" placeholder="0" min="0" value="{{$rentalItem->quantity}}" id="editRentalItemQuantity">
				</div>

			</div>
			
			
			<div class="edit-rental-item__flex">
				
				<div class="edit-rental-item__box-container edit-rental-item__half">
					<p class="edit-rental-item__label">First Day Rate:</p>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">$</span>
						</div>
						<input type="text" class="edit-rental-item__number form-control" name="firstDayRate" placeholder="0.00" value="{{$rentalItem->firstDayRate}}" id="editRentalItemFirstDayRate">
					</div>
				</div>

				<div class="edit-rental-item__box-container edit-rental-item__half">
					<p class="edit-rental-item__label">Second Day Rate:</p>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">$</span>
						</div>
						<input type="text" class="edit-rental-item__number form-control" name="secondDayRate" placeholder="0.00" value="{{$rentalItem->secondDayRate}}" id="editRentalItemSecondDayRate">
					</div>
				</div>

			</div>

			<div class="edit-rental-item__submit__container">
				<a class="edit-rental-item__submit">Submit Edit</a>
			</div>

		</form>
		
		
		<div class="edit-rental-item__errors__container">

			<div class="edit-rental-item__errors alert alert-danger" id="no-name" role="alert">
				The name field is required.
			</div>
			
			<div class="edit-rental-item__errors alert alert-danger" id="there-are-forbidden-characters" role="alert">
				You are not allowed to use the characters "@", ":" or "?" in the item name.
			</div>
			
			<div class="edit-rental-item__errors alert alert-danger" id="no-quantity" role="alert">
				The quantity field is required.
			</div>
			
			<div class="edit-rental-item__errors alert alert-danger" id="no-first-day-rate" role="alert">
				The first day rate field is required.
			</div>
			
			<div class="edit-rental-item__errors alert alert-danger" id="no-second-day-rate" role="alert">
				The second day rate field is required.
			</div>
			
		</div>
		
		
	</div>


	@section('script')
		<script type="text/javascript" src="/js/edit-rental-item.js"></script>
	@endsection

@endsection
