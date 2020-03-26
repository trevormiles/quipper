@extends('layout')



@section('title', 'Quipper | Sales Inventory')

@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')

@section('link-1-title', 'All Sales Items')
@section('link-1-location', '/sales-items')
@section('link-1-active-class', 'sub-nav-active')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'Add New Sales Item')
@section('link-2-location', '/sales-items/create')


@section('link-3-title', 'Edit Sales Categories')
@section('link-3-location', '/sales-categories')



@section('panel-title', 'Sales Inventory')

@section('content')

	<div class="sales-items">

		<h3 class="sales-items__title">All Sales Items</h3>

		<div class="accordion">

			<?php foreach ($salesCategories as $salesCategory) : ?>

			<?php $salesCategoryName = $salesCategory->category; ?>

			<div class="card">
				
				<div class="card-header" data-toggle="collapse" data-target="#collapse<?php echo $salesCategory->id; ?>" aria-expanded="false" aria-controls="collapse<?php echo $salesCategory->id; ?>">
					<h5 class="card-header__title"><?php echo $salesCategoryName; ?></h5>
					<i class="fas fa-chevron-down card-header__arrow"></i>
				</div>

				<div id="collapse<?php echo $salesCategory->id; ?>" class="collapse" aria-labelledby="heading<?php echo $salesCategory->id; ?>">

					<div class="card-body">
						
						<div class="sales-items__header">
							<h5 class="sales-items__header__item sales-items__header__name">Item Name</h5>
							<h5 class="sales-items__header__item sales-items__header__quantity">Quantity</h5>
							<h5 class="sales-items__header__item sales-items__header__price">Price</h5>
							<h5 class="sales-items__header__item sales-items__header__edit">Edit Item</h5>
							<h5 class="sales-items__header__item sales-items__header__delete">Delete Item</h5>
						</div>

						<?php
							$resultedItemsFoundByCategory = DB::table('sales_items')->where('category', '=', $salesCategoryName)->get();

							$resultedItemsFoundByCategory = json_decode(json_encode($resultedItemsFoundByCategory), true);
						?>

						<?php foreach ($resultedItemsFoundByCategory as $itemByCategory) : ?>
							<span class="sales-items__item-row">
								<h5 class="sales-items__item-row__item sales-items__item-row__name"><?php echo $itemByCategory["title"]; ?></h5>
								<h5 class="sales-items__item-row__item sales-items__item-row__quantity"><?php echo $itemByCategory["quantity"]; ?></h5>
								<h5 class="sales-items__item-row__item sales-items__item-row__price"><?php echo "$" . $itemByCategory["price"]; ?></h5>
								<a href="/sales-items/{{ $itemByCategory["id"] }}/edit" class="sales-items__item-row__item sales-items__item-row__edit"><i class="fas fa-edit"></i></a>
								<a href="" class="sales-items__item-row__item sales-items__item-row__delete"  data-toggle="modal" data-target="#modal<?php echo $itemByCategory["id"]; ?>"><i class="fas fa-times"></i></a>
							</span>
						
							<div class="modal fade" id="modal<?php echo $itemByCategory["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="Delete Box Modal" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">

										<div class="modal-header">
											<h5 class="modal-title">Delete this sales item?</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>

										<div class="modal-body">
											<form method="POST" action="/sales-items/<?php echo $itemByCategory["id"]; ?>">
												{{ method_field('DELETE') }}
												{{ csrf_field() }}
												<h3 class="sales-items__modal__title"><?php echo $itemByCategory["title"]; ?></h3>
												
												<div class="sales-items__modal__button__container">
													<button type="submit" class="sales-items__modal__button__submit">Yes, delete</button>
													<h6 class="sales-items__modal__button__cancel" data-dismiss="modal" aria-label="Close">No, cancel</h6>
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
		<script type="text/javascript" src="/js/sales-items.js"></script>
	@endsection
		
@endsection
