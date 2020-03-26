@extends('layout')



@section('title', 'Quipper | Edit Customer')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Customers')
@section('link-1-location', '/customers')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'New Customer')
@section('link-2-location', '/customers/create')


@section('link-3-title', '')
@section('link-3-location', '')



@section('panel-title', 'Edit Customer')

@section('content')
	
	<div class="edit-customer">
		
		<h3 class="edit-customer__title">Edit Customer</h3>
		
		<form method="POST" action="/customers/{{ $customer->id }}" id="editCustomerForm">

			@method('PATCH')
			{{ csrf_field() }}
			
			<input type="hidden" value="{{ $customer->name }}" name="oldCustomerName">
			
			<div class="edit-customer__box-container">
				<p class="edit-customer__label">Full Name:</p>
				<input class="edit-customer__input form-control" type="text" name="name" value="{{ $customer->name }}" id="editCustomerName">
			</div>
			
			
			<div class="edit-customer__flex">
				
				<div class="edit-customer__box-container edit-customer__half">
					<p class="edit-customer__label">Phone Number:</p>
					<input class="edit-customer__input form-control" type="text" name="phonenumber" value="{{ $customer->phonenumber }}" id="editCustomerPhone">
				</div>

				<div class="edit-customer__box-container edit-customer__half">
					<p class="edit-customer__label">Email:</p>
					<input class="edit-customer__input form-control" type="text" name="email" value="{{ $customer->email }}" id="editCustomerEmail">
				</div>

			</div>

			<div class="edit-customer__submit__container">
				<a class="edit-customer__submit">Submit Edit</a>
			</div>

		</form>
		
		
		<div class="edit-customer__errors__container">

			<div class="edit-customer__errors alert alert-danger" id="no-name" role="alert">
				The name field is required.
			</div>
			
			<div class="edit-customer__errors alert alert-danger" id="new-customer-name-already-exists" role="alert">
				There is already a customer with that name. Please include a middle initial or choose a different name.
			</div>
			
			<div class="edit-customer__errors alert alert-danger" id="customer-name-no-space" role="alert">
				The customer name must include a first and last name
			</div>
			
			<div class="edit-customer__errors alert alert-danger" id="customer-name-length" role="alert">
				The customer name must be longer than 4 characters
			</div>
			
			<div class="edit-customer__errors alert alert-danger" id="there-are-forbidden-characters" role="alert">
				You are not allowed to use the characters "@", ":", "/", "-" or "?" in the name.
			</div>
			
			<div class="edit-customer__errors alert alert-danger" id="no-phone" role="alert">
				The phone number field is required.
			</div>
			
			<div class="edit-customer__errors alert alert-danger" id="non-valid-email" role="alert">
				The email address is non valid. An email address must contain an @ symbol.
			</div>
			
			<div class="edit-customer__errors alert alert-danger" id="no-email" role="alert">
				The email field is required.
			</div>
			
			<div class="edit-customer__errors alert alert-danger" id="phone-not-long-enough" role="alert">
				The full phone number is required.
			</div>
			
		</div>
		
	</div>


	<ul id="customerOptions" style="display: none;">
		
		@foreach ($customers as $customer)
			<li>{{ $customer->name }}</li>
		@endforeach
		
	</ul>


	@section('script')
		<script type="text/javascript" src="/js/edit-customer.js"></script>
	@endsection


@endsection
