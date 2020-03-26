@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

<?php
	
	// Get the data
	$retreivedCustomer = $_GET['data'];

	// Display customer information
	$user = DB::table('customers')->where('name', $retreivedCustomer)->first();
	$userEmail = $user->email;
	$userPhone = $user->phonenumber;

?>

@section('title', 'Quipper | New Sale')

@section('main-nav-1-title', 'Rentals')
@section('main-nav-1-location', '/rentals')

@section('main-nav-2-title', 'Booking')
@section('main-nav-2-location', '/booking')

@section('main-nav-3-title', 'Sales')
@section('main-nav-3-location', '/sales/create')
@section('main-nav-active-3', 'main-nav-active')

@section('main-nav-4-title', 'Carts')
@section('main-nav-4-location', '/carts')

@section('carts-counter')
	<?php
		$cartsGroupedByCustomer = DB::table('carts')->where('status', '=', "active")->groupBy('customer')->get();
		$cartsGroupedByCustomerArray = json_decode(json_encode($cartsGroupedByCustomer), true);
		$cartsGroupedByCustomerCounted = count($cartsGroupedByCustomerArray);
	?>

	<?php if ($cartsGroupedByCustomerCounted > 0) : ?>
		<div class="checkout__counter">
			<p class="checkout__counter__number">
				<?php
					echo $cartsGroupedByCustomerCounted;
				?>
			</p>
		</div>
	<?php endif; ?>
@endsection


@section('link-1-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-1-title', 'New Sale')
@section('link-1-location', '/sales/create')
@section('link-1-active-class', 'sub-nav-active')


@section('link-2-title', 'Go to Accounting')
@section('link-2-location', '/accounting')


@section('panel-title', 'New Sale')


@section('back-arrow')
	<a href="/sales/create?data=<?php echo $retreivedCustomer; ?>" class="action-panel__back-arrow"><img src="/svg/back-arrow.svg" class="action-panel__back-arrow__icon"></a>
@endsection


@section('panel-title', 'New Sale')

@section('content')

	<form id="submit-sale" method="POST" action="/sales">
		
		@csrf
		
		<!-- Hidden Inputs From Previous Page -->
		
		<input type="hidden" name="customer" value="<?php echo $retreivedCustomer; ?>">
		<input type="hidden" name="saleDate" value="<?php echo date("Y-m-d"); ?>">
		<input class="itemsFormInput" type="text" name="items" value="">
		<input type="hidden" class="itemsSum" type="number" name="itemsSum" value="">
		
		
		
		
		<div class="action-panel__content-container__no-title">
			
			
			<div class="create-sale__left-right-container">
			
				<div class="create-sale__left">

					<div class="create-sale__left-top">

						<div class="create-sale__customer-data">
							<div class="create-sale__box">
								
								<div class="create-sale__box__title-container">
									<h5 class="create-sale__box__title">Customer:</h5>
									<h5 class="create-sale__box__icon"><a href="/sales/create?data=<?php echo $retreivedCustomer; ?>"><i class="fas fa-edit"></i></a></h5>
								</div>
								
								<h3 class="create-sale__customer__name"><?php echo $retreivedCustomer; ?></h3>
								
								<div class="create-sale__customer__information-container">
									<p class="create-sale__customer__information"><span class="create-sale__customer__information__title">Email:</span> <?php if ($userEmail) { echo $userEmail; } else { echo 'N/A'; } ?></p>
									<p class="create-sale__customer__information"><span class="create-sale__customer__information__title">Phone:</span> <?php if ($userPhone) { echo $userPhone; } else { echo 'N/A'; } ?></p>
								</div>
								
							</div>
						</div>

						<div class="create-sale__quick-search-container">
							
							<div class="create-sale__box create-sale__quick-search__box">
								
								
								<!-- Add Items -->

								<h5 class="create-sale__box__title">Quick search for items to add to cart:</h5>
								<input class="create-sale__quick-search__type-input form-control" type="text" id="myInput" onkeyup="myFunction()"  placeholder="Type to begin searching...">

								<div class="create-sale__quick-search__table__container">
									<table id="myTable" class="create-sale__quick-search__table">

										<tr class="create-sale__quick-search__header">
											<th class="create-sale__quick-search__item">Item</th>
											<th class="create-sale__quick-search__price">Price</th>
											<th class="create-sale__quick-search__quantity">Quantity</th>
											<th class="create-sale__quick-search__add">Add to cart</th>
										</tr>



										@foreach ($salesItems as $salesItem)

											<tr class="create-sale__quick-search__item-row">
												<td class="create-sale__quick-search__item-title">{{ $salesItem->title }}</td>
												<input type="hidden" class="itemsListInputTitle" value="{{ $salesItem->title }}">
												<td>${{ $salesItem->price }}</td>
												<input type="hidden" class="itemPrice" value="{{ $salesItem->price }}">
												<td>
													<input type="number" max="{{ $salesItem->quantity }}" min="0" placeholder="0" class="itemsListInputQuantity">
												</td>
												<td class="addItemToList create-sale__quick-search__cart"><i class="fas fa-shopping-cart"></i></td>
											</tr>

										@endforeach

									</table>

									<div class="create-sale__quick-search__no-matches" id="noMatchesItemsTable">
										<h4 class="create-sale__quick-search__no-matches__text">No Items match your search</h4>
									</div>

								</div>
								
							</div>
							
						</div>

					</div>
					

					<div class="create-sale__add-by-category">
						
						<div class="create-sale__box">

							<h5 class="create-sale__box__title">Search for items by category:</h5>
							
							<div class="create-sale__add-by-category__container">
								
								@foreach ($salesCategories as $salesCategory)
								
									<div class="create-sale__add-by-category__category">
										
										<?php $salesCategoryName = $salesCategory->category; ?>

										<div class="card create-sale__add-by-category__card">

											<div class="card-header" data-toggle="collapse" data-target="#collapse<?php echo $salesCategory->id; ?>" aria-expanded="false" aria-controls="collapse<?php echo $salesCategory->id; ?>">
												<h5 class="card-header__title"><?php echo $salesCategoryName; ?></h5>
												<i class="fas fa-chevron-down card-header__arrow"></i>
											</div>

											<div id="collapse<?php echo $salesCategory->id; ?>" class="collapse" aria-labelledby="heading<?php echo $salesCategory->id; ?>">

												<div class="card-body">

													<div class="create-sale__add-by-category__header">
														<h5 class="create-sale__add-by-category__header__item create-sale__add-by-category__header__name">Item Name</h5>
														<h5 class="create-sale__add-by-category__header__item create-sale__add-by-category__header__available"># Available</h5>
														<h5 class="create-sale__add-by-category__header__item create-sale__add-by-category__header__price">Price</h5>
														<h5 class="create-sale__add-by-category__header__item create-sale__add-by-category__header__quantity">Quantity</h5>
														<h5 class="create-sale__add-by-category__header__item create-sale__add-by-category__header__add">Add to cart</h5>
													</div>

													<?php
														$resultedItemsFoundByCategory = DB::table('sales_items')->where('category', '=', $salesCategoryName)->get();
														$resultedItemsFoundByCategory = json_decode(json_encode($resultedItemsFoundByCategory), true);
													?>

													<?php foreach ($resultedItemsFoundByCategory as $itemByCategory) : ?>
														<span class="create-sale__add-by-category__item-row">
															<h5 class="create-sale__add-by-category__item-row__item create-sale__add-by-category__item-row__name"><?php echo $itemByCategory["title"]; ?></h5>
															<input type="hidden" class="itemsListInputTitle" value="<?php echo $itemByCategory["title"]; ?>">
															<h5 class="create-sale__add-by-category__item-row__item create-sale__add-by-category__item-row__available"><?php echo $itemByCategory["quantity"]; ?></h5>
															<h5 class="create-sale__add-by-category__item-row__item create-sale__add-by-category__item-row__price"><?php echo "$" . $itemByCategory["price"]; ?></h5>
															<input type="hidden" class="itemPrice" value="<?php echo $itemByCategory["price"]; ?>">
															<div class="create-sale__add-by-category__item-row__item create-sale__add-by-category__item-row__quantity"><input class="itemsListInputQuantity" type="number" max="<?php echo $itemByCategory["quantity"]; ?>" min="0" placeholder="0"></div>
															<div class="addItemToListByCategory create-sale__add-by-category__item-row__item create-sale__add-by-category__item-row__add"><i class="fas fa-shopping-cart"></i></div>
														</span>
													<?php endforeach; ?>

												</div>

											</div>
										</div>
										
									</div>
								
								@endforeach
								
							</div>
							
						</div>
						
					</div>
					
				</div>

				<div class="create-sale__right">
					<div class="create-sale__box create-sale__cart__items-box">
						
						<h5 class="create-sale__cart__title">Items in cart:</h5>
						
						<div class="create-sale__cart__heading-row">
						
							<p class="create-sale__cart__heading__item create-sale__cart__heading__item__item">Item:</p>
							
							<p class="create-sale__cart__heading__item create-sale__cart__heading__item__price">Price:</p>
							
							<p class="create-sale__cart__heading__item create-sale__cart__heading__item__quantity">QTY:</p>
							
							<p class="create-sale__cart__heading__item create-sale__cart__heading__item__total">Total:</p>
							
							<p class="create-sale__cart__heading__item create-sale__cart__heading__item__remove"></p>
						
						</div>
						
						<!-- Display Items as they're being added -->
						<ul class="itemsList create-sale__cart__items"></ul>
						
						<div class="create-sale__cart__bottom">
							
							<div class="create-sale__cart__total">
								<p class="create-sale__cart__total__text">Total Fee: $<span class="create-sale__cart__total__number">0.00</span></p>
							</div>
							
							<!-- Submit form button -->
							<a class="createNewSaleSubmit create-sale__cart__submit">Make Sale</a>
							
						</div>
						
					</div>
				</div>
				
			</div>
			
			
			
			<div class="create-sale__errors__container">
			
				<div class="create-sale__errors alert alert-danger" id="quantity-is-zero" role="alert">
					The quantity must be more than 0 to be able to add it to the cart.
				</div>

				<div class="create-sale__errors alert alert-danger" id="item-already-in-cart" role="alert">
					That item has already been added to the cart. If you want to change the quantity of that item, remove it from the cart and then add it again with the correct quantity.
				</div>
				
				<div class="create-sale__errors alert alert-danger" id="no-items-have-been-added" role="alert">
					No items have been added to the cart. You must add items to be able to create a reservation.
				</div>
				
			</div>
			
		
		</div>
		
		
	</form>

@endsection

@section('script')
	<script type="text/javascript" src="/js/create-sale2.js"></script>
@endsection


