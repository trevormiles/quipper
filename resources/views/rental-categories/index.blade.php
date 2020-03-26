@extends('layout')



@section('title', 'Quipper | Rental Categories')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Rental Categories')
@section('link-1-location', '/rental-categories')
@section('link-1-active-class', 'sub-nav-active')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Rental Category')
@section('link-2-location', '/rental-categories/create')


@section('link-3-title', 'View Rental items')
@section('link-3-location', '/rental-items')



@section('panel-title', 'Rental Categories')

@section('content')
	
	<div class="rental-categories">
		
		<h2 class="rental-categories__page-title">All Rental Categories</h2>
		
		<div class="rental-categories__header">
			<h5 class="rental-categories__header__item rental-categories__header__name">Category Name</h5>
			<h5 class="rental-categories__header__item rental-categories__header__edit">Edit Name</h5>
			<h5 class="rental-categories__header__item rental-categories__header__delete">Delete Category</h5>
		</div>
		
		<div class="rental-categories__categories">
			<?php foreach ($rentalCategories as $rentalCategory) : ?>
				
				<span class="rental-categories__categories__category__container">
					<h5 class="rental-categories__categories__category__item rental-categories__categories__category__name"><?php echo $rentalCategory->category; ?></h5>
					<a class="rental-categories__categories__category__item rental-categories__categories__category__edit" href="/rental-categories/{{$rentalCategory->id}}/edit"><i class="fas fa-edit"></i></a>
					<a class="rental-categories__categories__category__item rental-categories__categories__category__delete" data-toggle="modal" data-target="#modal<?php echo $rentalCategory->id; ?>"><i class="fas fa-times"></i></a>
				</span>
			
				
				<div class="modal fade" id="modal<?php echo $rentalCategory->id; ?>" tabindex="-1" role="dialog" aria-labelledby="Delete Box Modal" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">

							<div class="modal-header">
								<h5 class="modal-title">Delete this rental category?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body">
								<form method="POST" action="/rental-categories/<?php echo $rentalCategory->id; ?>">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<h3 class="rental-categories__categories__category__modal__title"><?php echo $rentalCategory->category; ?></h3>
									<div class="rental-categories__categories__category__modal__button__container">
										<button type="submit" class="rental-categories__categories__category__modal__button__submit">Yes, delete</button>
										<h6 class="rental-categories__categories__category__modal__button__cancel" data-dismiss="modal" aria-label="Close">No, cancel</h6>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>
			
			<?php endforeach; ?>
		</div>
		
	</div>

@endsection
