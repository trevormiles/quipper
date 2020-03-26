@extends('layout')



@section('title', 'Quipper | New Rental Category')


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
@section('link-2-active-class', 'sub-nav-active')


@section('link-3-title', 'View Rental items')
@section('link-3-location', '/rental-items')



@section('panel-title', 'New Rental Category')

@section('content')
	
	<div class="rental-categories">
		
		<h3 class="rental-categories__create__title">Rental category name:</h3>
		
		<form method="POST" action="/rental-categories">
		
			{{ csrf_field() }}

			<input class="rental-categories__create__input" type="text" name="category" placeholder="Category Name">

			<button class="rental-categories__create__button" type="submit">Create Rental Category</button>
		
		</form>
		
	</div>

@endsection
