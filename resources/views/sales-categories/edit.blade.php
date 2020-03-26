@extends('layout')



@section('title', 'Quipper | Edit Sales Category')

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


@section('link-3-title', 'View Sales items')
@section('link-3-location', '/sales-items')



@section('panel-title', 'Edit Sales Category')

@section('content')
	
	<div class="sales-categories">
		
		<h3 class="sales-categories__create__title">Sales category name:</h3>
		
		<form method="POST" action="/sales-categories/{{ $salesCategory->id }}">
			
			@method('PATCH')
			{{ csrf_field() }}

			<input class="sales-categories__create__input" type="text" name="category" placeholder="Category Name" value="{{ $salesCategory->category }}">
			
			<input type="hidden" name="oldName" value="{{ $salesCategory->category }}">
			
			<p><span class="sales-categories__create__bold">Note:</span> All items with this category name will be changed to have the new category name upon pressing submit.</p>

			<button class="sales-categories__create__button" type="submit">Submit Edit</button>
		
		</form>
		
	</div>

@endsection
