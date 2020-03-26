@extends('layout')



@section('title', 'Quipper | New Customer')


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
@section('link-2-active-class', 'sub-nav-active')


@section('link-3-title', '')
@section('link-3-location', '')



@section('panel-title', 'New Customer')

@section('content')
	
	<div class="create-customer">
		
		<h3 class="create-customer__title">New Customer</h3>
		
		<form method="POST" action="/customers" id="createNewCustomerForm">

			{{ csrf_field() }}
			
			<div class="create-customer__box-container">
				<p class="create-customer__label">Full Name:</p>
				<input class="create-customer__input form-control" type="text" name="name" id="createCustomerName">
			</div>
			
			
			<div class="create-customer__flex">
				
				<div class="create-customer__box-container create-customer__half">
					<p class="create-customer__label">Phone Number:</p>
					<input class="create-customer__input form-control" type="text" name="phonenumber" id="createCustomerPhone">
				</div>

				<div class="create-customer__box-container create-customer__half">
					<p class="create-customer__label">Email:</p>
					<input class="create-customer__input form-control" type="text" name="email" id="createCustomerEmail">
				</div>

			</div>

			<div class="create-customer__submit__container">
				<a class="create-customer__submit">Create Customer</a>
			</div>

		</form>
		
		
		<div class="create-customer__errors__container">

			<div class="create-customer__errors alert alert-danger" id="no-name" role="alert">
				The name field is required.
			</div>
			
			<div class="create-customer__errors alert alert-danger" id="new-customer-name-already-exists" role="alert">
				There is already a customer with that name. Please include a middle initial or choose a different name.
			</div>
			
			<div class="create-customer__errors alert alert-danger" id="customer-name-no-space" role="alert">
				The customer name must include a first and last name
			</div>
			
			<div class="create-customer__errors alert alert-danger" id="customer-name-length" role="alert">
				The customer name must be longer than 4 characters
			</div>
			
			<div class="create-customer__errors alert alert-danger" id="there-are-forbidden-characters" role="alert">
				You are not allowed to use the characters "@", ":", "/", "-" or "?" in the name.
			</div>
			
			<div class="create-customer__errors alert alert-danger" id="no-phone" role="alert">
				The phone number field is required.
			</div>
			
			<div class="create-customer__errors alert alert-danger" id="non-valid-email" role="alert">
				The email address is non valid. An email address must contain an @ symbol.
			</div>
			
			<div class="create-customer__errors alert alert-danger" id="no-email" role="alert">
				The email field is required.
			</div>
			
			<div class="create-customer__errors alert alert-danger" id="phone-not-long-enough" role="alert">
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
		<script type="text/javascript" src="/js/create-customer.js"></script>
	@endsection


@endsection
