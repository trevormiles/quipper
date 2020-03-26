@extends('layout')



@section('title', 'Quipper | Rental Inventory')

@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')

@section('link-1-title', 'All Rental Items')
@section('link-1-location', '/rental-items')
@section('link-1-active-class', 'sub-nav-active')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Item')
@section('link-2-location', '/rental-items/create')


@section('link-3-title', 'Edit Rental Categories')
@section('link-3-location', '/rental-categories')



@section('panel-title', 'Rental Inventory')

@section('content')

	<div class="rental-items">

		<h3 class="rental-items__title">All Rental Items</h3>

		<div class="accordion">

			<?php foreach ($rentalCategories as $rentalCategory) : ?>

			<?php $rentalCategoryName = $rentalCategory->category; ?>

			<div class="card">
				
				<div class="card-header" data-toggle="collapse" data-target="#collapse<?php echo $rentalCategory->id; ?>" aria-expanded="false" aria-controls="collapse<?php echo $rentalCategory->id; ?>">
					<h5 class="card-header__title"><?php echo $rentalCategoryName; ?></h5>
					<i class="fas fa-chevron-down card-header__arrow"></i>
				</div>

				<div id="collapse<?php echo $rentalCategory->id; ?>" class="collapse" aria-labelledby="heading<?php echo $rentalCategory->id; ?>">

					<div class="card-body">
						
						<div class="rental-items__header">
							<h5 class="rental-items__header__item rental-items__header__name">Item Name</h5>
							<h5 class="rental-items__header__item rental-items__header__quantity">Quantity</h5>
							<h5 class="rental-items__header__item rental-items__header__rate">Rate</h5>
							<h5 class="rental-items__header__item rental-items__header__edit">Edit Item</h5>
							<h5 class="rental-items__header__item rental-items__header__delete">Delete Item</h5>
						</div>

						<?php
							$resultedItemsFoundByCategory = DB::table('rental_items')->where('category', '=', $rentalCategoryName)->get();

							$resultedItemsFoundByCategory = json_decode(json_encode($resultedItemsFoundByCategory), true);
						?>

						<?php foreach ($resultedItemsFoundByCategory as $itemByCategory) : ?>
							<span class="rental-items__item-row">
								<h5 class="rental-items__item-row__item rental-items__item-row__name"><?php echo $itemByCategory["title"]; ?></h5>
								<h5 class="rental-items__item-row__item rental-items__item-row__quantity"><?php echo $itemByCategory["quantity"]; ?></h5>
								<h5 class="rental-items__item-row__item rental-items__item-row__rate"><?php echo "$" . $itemByCategory["firstDayRate"] . "/" . $itemByCategory["secondDayRate"]; ?></h5>
								<a href="/rental-items/{{ $itemByCategory["id"] }}/edit" class="rental-items__item-row__item rental-items__item-row__edit"><i class="fas fa-edit"></i></a>
								<a href="" class="rental-items__item-row__item rental-items__item-row__delete"  data-toggle="modal" data-target="#modal<?php echo $itemByCategory["id"]; ?>"><i class="fas fa-times"></i></a>
							</span>
						
							<div class="modal fade" id="modal<?php echo $itemByCategory["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="Delete Box Modal" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">

										<div class="modal-header">
											<h5 class="modal-title">Delete this rental item?</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>

										<div class="modal-body">
											<form method="POST" action="/rental-items/<?php echo $itemByCategory["id"]; ?>">
												{{ method_field('DELETE') }}
												{{ csrf_field() }}
												<h3 class="rental-items__modal__title"><?php echo $itemByCategory["title"]; ?></h3>
												
												<?php
												
													$thisItemsName = $itemByCategory["title"];
												
													$activeRentalsWithThisItem = DB::table('rentals')->where('items', 'LIKE', '%'.$thisItemsName.'%')
																									 ->where('status', '=', "active")
																									 ->get();
													$activeRentalsWithThisItem = json_decode(json_encode($activeRentalsWithThisItem), true);
										
												?>
												
												<?php if (empty($activeRentalsWithThisItem)) : ?>
												
													<div class="rental-items__modal__button__container">
														<button type="submit" class="rental-items__modal__button__submit">Yes, delete</button>
														<h6 class="rental-items__modal__button__cancel" data-dismiss="modal" aria-label="Close">No, cancel</h6>
													</div>
												
												<?php else : ?>
												
													<p class="rental-items__modal__there-are-active-items">There is currently an active rental with this item. You can only delete items if all instances of that item are checked in.</p>
												
												<?php endif; ?>
												
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
		<script type="text/javascript" src="/js/rental-items.js"></script>
	@endsection
		
@endsection
