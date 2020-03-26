@extends('layout')



@section('title', 'Quipper | Sales Categories')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Sales Categories')
@section('link-1-location', '/sales-categories')
@section('link-1-active-class', 'sub-nav-active')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Sales Category')
@section('link-2-location', '/sales-categories/create')


@section('link-3-title', 'View Sales items')
@section('link-3-location', '/sales-items')



@section('panel-title', 'Sales Categories')

@section('content')
	
	<div class="sales-categories">
		
		<h2 class="sales-categories__page-title">All Sales Categories</h2>
		
		<div class="sales-categories__header">
			<h5 class="sales-categories__header__item sales-categories__header__name">Category Name</h5>
			<h5 class="sales-categories__header__item sales-categories__header__edit">Edit Name</h5>
			<h5 class="sales-categories__header__item sales-categories__header__delete">Delete Category</h5>
		</div>
		
		<div class="sales-categories__categories">
			<?php foreach ($salesCategories as $salesCategory) : ?>
				
				<span class="sales-categories__categories__category__container">
					<h5 class="sales-categories__categories__category__item sales-categories__categories__category__name"><?php echo $salesCategory->category; ?></h5>
					<a class="sales-categories__categories__category__item sales-categories__categories__category__edit" href="/sales-categories/{{$salesCategory->id}}/edit"><i class="fas fa-edit"></i></a>
					<a class="sales-categories__categories__category__item sales-categories__categories__category__delete" data-toggle="modal" data-target="#modal<?php echo $salesCategory->id; ?>"><i class="fas fa-times"></i></a>
				</span>
			
				
				<div class="modal fade" id="modal<?php echo $salesCategory->id; ?>" tabindex="-1" role="dialog" aria-labelledby="Delete Box Modal" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">

							<div class="modal-header">
								<h5 class="modal-title">Delete this sales category?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body">
								<form method="POST" action="/sales-categories/<?php echo $salesCategory->id; ?>">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<h3 class="sales-categories__categories__category__modal__title"><?php echo $salesCategory->category; ?></h3>
									<div class="sales-categories__categories__category__modal__button__container">
										<button type="submit" class="sales-categories__categories__category__modal__button__submit">Yes, delete</button>
										<h6 class="sales-categories__categories__category__modal__button__cancel" data-dismiss="modal" aria-label="Close">No, cancel</h6>
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
