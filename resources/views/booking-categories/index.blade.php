@extends('layout')



@section('title', 'Quipper | Booking Categories')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Booking Categories')
@section('link-1-location', '/booking-categories')
@section('link-1-active-class', 'sub-nav-active')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Booking Category')
@section('link-2-location', '/booking-categories/create')


@section('link-3-title', 'View Booking items')
@section('link-3-location', '/booking-items')



@section('panel-title', 'Booking Categories')

@section('content')
	
	<div class="booking-categories">
		
		<h2 class="booking-categories__page-title">All Booking Categories</h2>
		
		<div class="booking-categories__header">
			<h5 class="booking-categories__header__item booking-categories__header__name">Category Name</h5>
			<h5 class="booking-categories__header__item booking-categories__header__edit">Edit Name</h5>
			<h5 class="booking-categories__header__item booking-categories__header__delete">Delete Category</h5>
		</div>
		
		<div class="booking-categories__categories">
			<?php foreach ($bookingCategories as $bookingCategory) : ?>
				
				<span class="booking-categories__categories__category__container">
					<h5 class="booking-categories__categories__category__item booking-categories__categories__category__name"><?php echo $bookingCategory->category; ?></h5>
					<a class="booking-categories__categories__category__item booking-categories__categories__category__edit" href="/booking-categories/{{$bookingCategory->id}}/edit"><i class="fas fa-edit"></i></a>
					<a class="booking-categories__categories__category__item booking-categories__categories__category__delete" data-toggle="modal" data-target="#modal<?php echo $bookingCategory->id; ?>"><i class="fas fa-times"></i></a>
				</span>
			
				
				<div class="modal fade" id="modal<?php echo $bookingCategory->id; ?>" tabindex="-1" role="dialog" aria-labelledby="Delete Box Modal" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">

							<div class="modal-header">
								<h5 class="modal-title">Delete this booking category?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body">
								<form method="POST" action="/booking-categories/<?php echo $bookingCategory->id; ?>">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<h3 class="booking-categories__categories__category__modal__title"><?php echo $bookingCategory->category; ?></h3>
									<div class="booking-categories__categories__category__modal__button__container">
										<button type="submit" class="booking-categories__categories__category__modal__button__submit">Yes, delete</button>
										<h6 class="booking-categories__categories__category__modal__button__cancel" data-dismiss="modal" aria-label="Close">No, cancel</h6>
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
