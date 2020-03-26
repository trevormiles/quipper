@extends('layout')



@section('title', 'Quipper | Edit Rental Category')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Rental Categories')
@section('link-1-location', '/rental-categories')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Rental Category')
@section('link-2-location', '/rental-categories/create')


@section('link-3-title', 'View Rental items')
@section('link-3-location', '/rental-items')



@section('panel-title', 'Edit Rental Category')

@section('content')
	
	<div class="rental-categories">
		
		<h3 class="rental-categories__create__title">Rental category name:</h3>
		
		<form method="POST" action="/rental-categories/{{ $rentalCategory->id }}">
			
			@method('PATCH')
			{{ csrf_field() }}

			<input class="rental-categories__create__input" type="text" name="category" placeholder="Category Name" value="{{ $rentalCategory->category }}">
			
			<input type="hidden" name="oldName" value="{{ $rentalCategory->category }}">
			
			<p><span class="rental-categories__create__bold">Note:</span> All items with this category name will be changed to have the new category name upon pressing submit.</p>

			<button class="rental-categories__create__button" type="submit">Submit Edit</button>
		
		</form>
		
	</div>

@endsection
