@extends('layout')



@section('title', 'Quipper | View Customer')


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



@section('panel-title', 'View Customer')

@section('content')
	
	<div class="show-customer">

		<h1 class="show-customer__title">{{ $customer->name }}</h1>
		<div class="show-customer__divider"></div>
		
		<h5><span class="show-customer__bold">Phone Number:</span> {{ $customer->phonenumber }}</h5>
		<h5><span class="show-customer__bold">Email:</span> {{ $customer->email }}</h5>
		
		<div class="show-customer__button-container">
			<a class="show-customer__edit" href="/customers/{{ $customer->id }}/edit">Edit</a>

			<form method="POST" action="/customers/{{ $customer->id }}">

				@method('DELETE')
				@csrf

				<button class="show-customer__delete" type="submit">Delete Customer</button>

			</form>
			
		</div>
		
	</div>

@endsection
