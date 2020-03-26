@extends('layout')



@section('title', 'Quipper | New Sales Category')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Sales Categories')
@section('link-1-location', '/sales-categories')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Sales Category')
@section('link-2-location', '/sales-categories/create')
@section('link-2-active-class', 'sub-nav-active')


@section('link-3-title', 'View Sales items')
@section('link-3-location', '/sales-items')



@section('panel-title', 'New Sales Category')

@section('content')
	
	<div class="sales-categories">
		
		<h3 class="sales-categories__create__title">Sales category name:</h3>
		
		<form method="POST" action="/sales-categories">
		
			{{ csrf_field() }}

			<input class="sales-categories__create__input" type="text" name="category" placeholder="Category Name">

			<button class="sales-categories__create__button" type="submit">Create Sales Category</button>
		
		</form>
		
	</div>

@endsection
