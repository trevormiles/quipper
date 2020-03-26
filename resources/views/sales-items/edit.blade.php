@extends('layout')



@section('title', 'Quipper | Edit Sales Item')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Sales Items')
@section('link-1-location', '/sales-items')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Sales Item')
@section('link-2-location', '/sales-items/create')
@section('link-2-active-class', 'sub-nav-active')


@section('link-3-title', 'Edit Sales Categories')
@section('link-3-location', '/sales-categories')



@section('panel-title', 'Edit Sales Item')

@section('content')

	<div class="edit-sales-item">
		
		<h3 class="edit-sales-item__title">Edit Sales Item</h3>
		
		<form method="POST" action="/sales-items/{{ $salesItem->id }}" id="submitEditSalesItemForm">
			
			@method('PATCH')
			{{ csrf_field() }}
			
			<div class="edit-sales-item__box-container">
				<p class="edit-sales-item__label">Sales Category:</p>
				<select class="edit-sales-item__select form-control" name="category">
					<?php foreach ($salesCategories as $salesCategory) : ?>
						<option value="<?php echo $salesCategory->category; ?>" <?php if ($salesCategory->category == $salesItem->category) {echo "selected";} ?> ><?php echo $salesCategory->category; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			
				
			<div class="edit-sales-item__box-container">
				<p class="edit-sales-item__label">Item Name:</p>
				<input class="edit-sales-item__input form-control" type="text" name="title" placeholder="Title of item" value="{{$salesItem->title}}" id="editSalesItemName">
			</div>

			
			
			<div class="edit-sales-item__flex">
				
				<div class="edit-sales-item__box-container edit-sales-item__half">
					<p class="edit-sales-item__label">Quantity:</p>
					<div class="input-group">
						<input type="number" class="edit-sales-item__number form-control" name="quantity" min="0" value="{{$salesItem->quantity}}" id="editSalesItemQuantity">
					</div>
				</div>

				<div class="edit-sales-item__box-container edit-sales-item__half">
					<p class="edit-sales-item__label">Price:</p>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">$</span>
						</div>
						<input type="text" class="edit-sales-item__number form-control" name="price" placeholder="0.00" value="{{$salesItem->price}}" id="editSalesItemPrice">
					</div>
				</div>

			</div>

			<div class="edit-sales-item__submit__container">
				<a class="edit-sales-item__submit">Submit Edit</a>
			</div>

		</form>
		
		
		<div class="edit-sales-item__errors__container">

			<div class="edit-sales-item__errors alert alert-danger" id="no-name" role="alert">
				The name field is required.
			</div>
			
			<div class="edit-sales-item__errors alert alert-danger" id="no-quantity" role="alert">
				The quantity field is required.
			</div>
			
			<div class="edit-sales-item__errors alert alert-danger" id="no-price" role="alert">
				The price field is required.
			</div>
			
		</div>
		
		
	</div>


	@section('script')
		<script type="text/javascript" src="/js/edit-sales-item.js"></script>
	@endsection

@endsection
