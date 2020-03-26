@extends('layout')



@section('title', 'Quipper | View Sales Item')


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


@section('link-3-title', 'Edit Sales Categories')
@section('link-3-location', '/sales-categories')



@section('panel-title', 'View Sales Item')

@section('content')

	<div class="show-sales-item">

		<h1 class="show-sales-item__title">{{ $salesItem->title }}</h1>
		<div class="show-sales-item__divider"></div>
		
		<h5><span class="show-sales-item__bold">Quantity:</span> {{ $salesItem->quantity }}</h5>
		<h5><span class="show-sales-item__bold">Sales Category:</span> {{ $salesItem->category }}</h5>
		
		<h5><span class="show-sales-item__bold">Price:</span> ${{ $salesItem->price }}</h5>
		
		<div class="show-sales-item__button-container">
			<a class="show-sales-item__edit" href="/sales-items/{{ $salesItem->id }}/edit">Edit</a>

			<form method="POST" action="/sales-items/{{ $salesItem->id }}">

				@method('DELETE')
				@csrf

				<button class="show-sales-item__delete" type="submit">Delete Sales Item</button>

			</form>
		</div>
		
	</div>


@endsection
