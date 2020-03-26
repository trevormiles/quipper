@extends('layout')



@section('title', 'Quipper | Booking Inventory')

@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')

@section('link-1-title', 'All Booking Items')
@section('link-1-location', '/booking-items')
@section('link-1-active-class', 'sub-nav-active')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Booking Item')
@section('link-2-location', '/booking-items/create')


@section('link-3-title', 'Edit Booking Categories')
@section('link-3-location', '/booking-categories')



@section('panel-title', 'Booking Inventory')

@section('content')

	<div class="booking-items">

		<h3 class="booking-items__title">All Booking Items</h3>

		<div class="accordion">

			<?php foreach ($bookingCategories as $bookingCategory) : ?>

			<?php $bookingCategoryName = $bookingCategory->category; ?>

			<div class="card">
				
				<div class="card-header" data-toggle="collapse" data-target="#collapse<?php echo $bookingCategory->id; ?>" aria-expanded="false" aria-controls="collapse<?php echo $bookingCategory->id; ?>">
					<h5 class="card-header__title"><?php echo $bookingCategoryName; ?></h5>
					<i class="fas fa-chevron-down card-header__arrow"></i>
				</div>

				<div id="collapse<?php echo $bookingCategory->id; ?>" class="collapse" aria-labelledby="heading<?php echo $bookingCategory->id; ?>">

					<div class="card-body">
						
						<div class="booking-items__header">
							<h5 class="booking-items__header__item booking-items__header__name">Item Name</h5>
							<h5 class="booking-items__header__item booking-items__header__rate">Rate</h5>
							<h5 class="booking-items__header__item booking-items__header__edit">Edit Item</h5>
							<h5 class="booking-items__header__item booking-items__header__delete">Delete Item</h5>
						</div>

						<?php
							$resultedItemsFoundByCategory = DB::table('booking_items')->where('category', '=', $bookingCategoryName)->get();

							$resultedItemsFoundByCategory = json_decode(json_encode($resultedItemsFoundByCategory), true);
						?>

						<?php foreach ($resultedItemsFoundByCategory as $itemByCategory) : ?>
							<span class="booking-items__item-row">
								<h5 class="booking-items__item-row__item booking-items__item-row__name"><?php echo $itemByCategory["title"]; ?></h5>
								<h5 class="booking-items__item-row__item booking-items__item-row__rate"><?php echo "$" . $itemByCategory["firstHourRate"] . "/" . $itemByCategory["additionalHourRate"]; ?></h5>
								<a href="/booking-items/{{ $itemByCategory["id"] }}/edit" class="booking-items__item-row__item booking-items__item-row__edit"><i class="fas fa-edit"></i></a>
								<a href="" class="booking-items__item-row__item booking-items__item-row__delete"  data-toggle="modal" data-target="#modal<?php echo $itemByCategory["id"]; ?>"><i class="fas fa-times"></i></a>
							</span>
						
							<div class="modal fade" id="modal<?php echo $itemByCategory["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="Delete Box Modal" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">

										<div class="modal-header">
											<h5 class="modal-title">Delete this booking item?</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>

										<div class="modal-body">
											<form method="POST" action="/booking-items/<?php echo $itemByCategory["id"]; ?>">
												{{ method_field('DELETE') }}
												{{ csrf_field() }}
												<h3 class="booking-items__modal__title"><?php echo $itemByCategory["title"]; ?></h3>
														
												<div class="booking-items__modal__button__container">
													<button type="submit" class="booking-items__modal__button__submit">Yes, delete</button>
													<h6 class="booking-items__modal__button__cancel" data-dismiss="modal" aria-label="Close">No, cancel</h6>
												</div>
												
											</form>
										</div>

									</div>
								</div>
							</div>
						<?php endforeach; ?>

					</div>

				</div>
			</div>

			<?php endforeach; ?>

		</div>
		
		
	</div>


	@section('script')
		<script type="text/javascript" src="/js/booking-items.js"></script>
	@endsection
		
@endsection
