@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

@section('title', 'Quipper | New Rental')


@section('main-nav-active-1', 'main-nav-active')


@section('link-1-icon')
	<i class="far fa-calendar-alt"></i>
@endsection
@section('link-1-title', 'Dashboard')
@section('link-1-location', '/')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'New Rental')
@section('link-2-location', '/create')
@section('link-2-active-class', 'sub-nav-active')


<?php 
	$todayDate = date("Y-m-d");
	$todayLink = "/rentals-day?date=" . $todayDate;
?>

@section('link-3-title', 'View Today')
@section('link-3-location', $todayLink)



@section('panel-title', 'Rental Dashboard')

@section('content')
	<h1>New Rental</h1>

	<form method="POST" action="/rentals">
		
		<input name="hidden" type="text" style="display:none;">
		
		{{ csrf_field() }}
		
		
		
		<!-- Customer Input -->
		
		<label style="display:block;margin-bottom:2px;">Search for a Customer</label>
		<input type="text" name="customer" id="customer-input" list="customer_list">
		<datalist id="customer_list">
			@foreach ($customers as $customer)
				<option value="{{ $customer->name }}"></option>
			@endforeach
		</datalist>
		
		
		
		<!-- Start Date Input -->
		
		<label style="display:block;margin-bottom:2px;margin-top:30px;">Select a start date</label>
		<div class="startDatePickerDay"></div>
		<input style="border:none;" class="startDatePicker" name="startDate"></input>
		<i class="startDateTrigger fas fa-edit"></i>
		
		

		<!-- End Date Input -->

		<label style="display:block;margin-bottom:2px;margin-top:30px;">Select an end date</label>
		<div class="endDatePickerDay"></div>
		<input style="border:none;" class="endDatePicker" name="endDate"></input>
		<i class="endDateTrigger fas fa-edit"></i>
		



		<!-- Items Input -->

		<input class="itemsFormInput" type="text" name="items" value="">
		
		<label style="display:block;margin-top:30px;margin-bottom:2px;" >Search for Items</label>
		<input type="text" id="myInput" onkeyup="myFunction()">
		
		<table id="myTable">
			<tr class="header">
				<th>Item</th>
				<th>Rate</th>
				<th>#Available</th>
				<th>Quantity:</th>
				<th>Add to cart</th>
			</tr>
			@foreach ($rentalItems as $rentalItem)
				<tr>
					<td>{{ $rentalItem->title }}</td>
					<input type="hidden" class="itemsListInputTitle" value="{{ $rentalItem->title }}">
					<td>${{ $rentalItem->firstDayRate }}</td>
					<input type="hidden" class="itemRate" value="{{ $rentalItem->firstDayRate }}">
					<td>4</td>
					<td><input type="number" placeholder="Quantity" class="itemsListInputQuantity"></td>
					<td><p style="display:inline;color:blue;margin:0px;margin-left: 15px;" class="addItemToList">Add Item</p></td>
  				</tr>
			@endforeach
		</table>

		<input type="hidden" class="itemsSum" type="number" name="itemsSum" value="">



		<!-- Display Items as they're being added -->
		
		<ul class="itemsList"></ul>



		<!-- Submit form button -->
		
		<button class="createNewRentalSubmit" style="margin-top:25px;" type="submit">Create Reservation</button>
		
	</form>

@endsection


