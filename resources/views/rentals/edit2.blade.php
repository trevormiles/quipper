@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

<?php
	
	// Get the data
	$retreivedData = $_GET['data'];

	//Explode the data, seperate into variables
	$retreivedDataArray = explode('-', $retreivedData);
	$retreivedRentalID = $retreivedDataArray[0];
	$retreivedStartDate = $retreivedDataArray[1];
	$retreivedEndDate = $retreivedDataArray[2];
	$retreivedCustomer = $retreivedDataArray[3];
	
	// Reformat the dates by exploding and rearranging
	$startDateArray = explode('/', $retreivedStartDate);
	$startYear = $startDateArray[2];
	$startMonth = $startDateArray[0];
	$startDay = $startDateArray[1];
	$startDate = $startYear . "-" . $startMonth . "-" . $startDay;

	$endDateArray = explode('/', $retreivedEndDate);
	$endYear = $endDateArray[2];
	$endMonth = $endDateArray[0];
	$endDay = $endDateArray[1];
	$endDate = $endYear . "-" . $endMonth . "-" . $endDay;

	// Calculate the number of the days of the rental period
	$formattedStartDate = strtotime("$startDate");
	$formattedEndDate = strtotime("$endDate");
	$datediff = $formattedEndDate - $formattedStartDate;
	$roundedDateDiff = round($datediff / (60 * 60 * 24));

	// Display date information
	$displayStartDate = $startMonth . "/" . $startDay;
	$displayEndDate = $endMonth . "/" . $endDay;
	$startDayOfWeek = date("l", strtotime($startDate));
	$endDayOfWeek = date("l", strtotime($endDate));


	// Get the rental information based off of the given rental ID passed in through the URL
	$rental = DB::table('rentals')->where('id', $retreivedRentalID)->get();
	$rental = json_decode(json_encode($rental), true);
	$retreivedRentalItems = $rental[0]["items"];
	$retreivedRentalItemsArray = json_decode($retreivedRentalItems);


	// Get the itemsStatus
	$retreivedRentalItemsStatus = $rental[0]["itemsStatus"];

	
	////////// Now compile that all into a string so it can be passed to the javascript and reconstructed there ///////////

	// First create an array that will be added on to in the loop below
	$stringedRentalItems = [];
	
	// Now loop through the items array and add it to the stringedRentalItems
	foreach ($retreivedRentalItemsArray as $retreivedRentalItem) {
		$itemTitle = $retreivedRentalItem[0];
		$itemQuantity = $retreivedRentalItem[1];
		$itemDays = $roundedDateDiff;
		
		if ($itemDays > 0) {
			$itemDaysMinusOne = $itemDays - 1;
		} else {
			$itemDaysMinusOne = 0;
		}
		
		$itemFirstDayRate = $retreivedRentalItem[3];
		$itemSecondDayRate = $retreivedRentalItem[4];
		
		$additionalDayTotal = $itemSecondDayRate * $itemDaysMinusOne;
		$itemTotal = $itemFirstDayRate + $additionalDayTotal;
		$itemTotalDecimal = number_format($itemTotal, 2);
		
		$itemStatus = $retreivedRentalItem[6];
		
		$itemString = $itemTitle . "?" . $itemQuantity . "?" . $itemDays . "?" . $itemFirstDayRate . "?" . $itemSecondDayRate . "?" . $itemTotalDecimal . "?" . $itemStatus;
		
		array_push($stringedRentalItems, $itemString);
		
	}

	$stringedRentalItemsImploded = implode(":",$stringedRentalItems);

	
	// Display customer information
	$user = DB::table('customers')->where('name', $retreivedCustomer)->first();
	$userEmail = $user->email;
	$userPhone = $user->phonenumber;

?>

@section('title', 'Quipper | Edit Rental')


@section('main-nav-1-title', 'Rentals')
@section('main-nav-1-location', '/rentals')
@section('main-nav-active-1', 'main-nav-active')

@section('main-nav-2-title', 'Booking')
@section('main-nav-2-location', '/booking')

@section('main-nav-3-title', 'Sales')
@section('main-nav-3-location', '/sales/create')

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
	<i class="far fa-calendar-alt"></i>
@endsection
@section('link-1-title', 'Rental Calendar')
@section('link-1-location', '/')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'New Rental')
@section('link-2-location', '/rentals/create')


<?php 
	$todayDate = date("Y-m-d");
	$todayLink = "/rentals-day?date=" . $todayDate;
?>

@section('link-3-title', 'View Today')
@section('link-3-location', $todayLink)


@section('panel-title', 'Edit Rental')

@section('content')

	<input type="hidden" id="retreivedRentalItems" value="<?php echo $stringedRentalItemsImploded; ?>">

	<form method="POST" action="/rentals/<?php echo $retreivedRentalID; ?>" id="submit-rental-edit">
						
		{{ method_field('PATCH') }}
		{{ csrf_field() }}
		
		<!-- Hidden Inputs From Previous Page -->
		
		<input type="hidden" name="customer" value="<?php echo $retreivedCustomer; ?>">
		<input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
		<input type="hidden" name="endDate" value="<?php echo $endDate; ?>">
		<input type="hidden" name="amountOfDays" id="amountOfDays" value="<?php echo $roundedDateDiff; ?>">
		<input type="hidden" name="itemsStatus" value="<?php echo $retreivedRentalItemsStatus; ?>">
		<input type="hidden" name="status" value="<?php echo "active"; ?>">
		
		
		
		
		<div class="action-panel__content-container__no-title">
			
			
			<div class="edit-rental__left-right-container">
			
				<div class="edit-rental__left">

					<div class="edit-rental__display-data">

						<div class="edit-rental__customer-data">
							<div class="edit-rental__box">
								
								<div class="edit-rental__box__title-container">
									<h5 class="edit-rental__box__title">Customer:</h5>
									<h5 class="edit-rental__box__icon"><a href="/rentals/<?php echo $retreivedRentalID; ?>/edit"><i class="fas fa-edit"></i></a></h5>
								</div>
								
								<h3 class="edit-rental__customer__name"><?php echo $retreivedCustomer; ?></h3>
								
								<div class="edit-rental__customer__information-container">
									<p class="edit-rental__customer__information"><span class="edit-rental__customer__information__title">Email:</span> <?php if ($userEmail) { echo $userEmail; } else { echo 'N/A'; } ?></p>
									<p class="edit-rental__customer__information"><span class="edit-rental__customer__information__title">Phone:</span> <?php if ($userPhone) { echo $userPhone; } else { echo 'N/A'; } ?></p>
								</div>
								
							</div>
						</div>

						<div class="edit-rental__dates-data">
							
							<div class="edit-rental__box">
								
								<div class="edit-rental__box__title-container">
									<h5 class="edit-rental__box__title">Rental dates:</h5>
									<h5 class="edit-rental__box__icon"><a href="/rentals/<?php echo $retreivedRentalID; ?>/edit"><i class="fas fa-edit"></i></a></h5>
								</div>
								
								<div class="edit-rental__dates-data__block">
									
									<div class="edit-rental__dates-data__block__start">
										<div class="edit-rental__dates-data__block__content">
											<h4 class="edit-rental__dates-data__block__day"><?php echo $startDayOfWeek; ?></h4>
											<h6 class="edit-rental__dates-data__block__date"><?php echo $displayStartDate; ?></h6>
										</div>
									</div>
									
									<div class="edit-rental__dates-data__block__end">
										
										<div class="edit-rental__dates-data__block__end__triangle"></div>
										
										<div class="edit-rental__dates-data__block__content">
											<h4 class="edit-rental__dates-data__block__day"><?php echo $endDayOfWeek; ?></h4>
											<h6 class="edit-rental__dates-data__block__date"><?php echo $displayEndDate; ?></h6>
										</div>
										
									</div>
									
								</div>
								
								<h6 class="edit-rental__dates-data__duration"><?php if ($roundedDateDiff > 0) {echo $roundedDateDiff; } else { echo 'Same'; } ?> day rental duration</h6>
								
							</div>
						</div>

					</div>

					<div class="edit-rental__add-items">
						
						<h2 class="edit-rental__step-title">Add Rental Items</h2>
						
						<div class="edit-rental__box edit-rental__add-items__box">


							<!-- Add Items -->

							<input class="itemsFormInput" type="text" name="items" value="">

							<h5 class="edit-rental__box__title">Search for items to add to cart:</h5>
							<input class="edit-rental__add-items__type-input form-control" type="text" id="myInput" onkeyup="myFunction()"  placeholder="Type to begin searching...">
							
							<div class="edit-rental__add-items__table__container">
							<table id="myTable" class="edit-rental__add-items__table">
								
								<tr class="edit-rental__add-items__header">
									<th class="edit-rental__add-items__item">Item</th>
									<th class="edit-rental__add-items__rate">Rate</th>
									<th class="edit-rental__add-items__available"># Available</th>
									<th class="edit-rental__add-items__quantity">Quantity:</th>
									<th class="edit-rental__add-items__add-to-cart">Add to cart</th>
								</tr>
								
								
								
								@foreach ($rentalItems as $rentalItem)
								
									<tr class="edit-rental__add-items__item-row">
										<td class="edit-rental__add-items__item-title">{{ $rentalItem->title }}</td>
										<input type="hidden" class="itemsListInputTitle" value="{{ $rentalItem->title }}">
										<td>${{ $rentalItem->firstDayRate . " / " . $rentalItem->secondDayRate }}</td>
										<input type="hidden" class="itemRateFirstDay" value="{{ $rentalItem->firstDayRate }}">
										<input type="hidden" class="itemRateAddDay" value="{{ $rentalItem->secondDayRate }}">
										<td>
											<?php						

												$results = DB::table('rentals')->where([
													['startDate', '<=', $endDate],
													['endDate', '>=', $startDate],
													['id', '!=', $retreivedRentalID]
												])->get();

												//var_dump($results);

												if (empty($results[0])) {

													$totalItemAvailability = $rentalItem->quantity;
													echo $totalItemAvailability;

												} else {

													$totalItemAmount = $rentalItem->quantity;
													$totalItemAvailability = $totalItemAmount;

													foreach ($results as $result) {

														$jsonItems = $result->items;
														$jsonItemsArray = json_decode($jsonItems, true);

														foreach ($jsonItemsArray as $jsonItemArray) {

																$jsonItemTitle = $jsonItemArray[0];
																$jsonItemStatus = $jsonItemArray[6];

																if ($jsonItemTitle === $rentalItem->title && $jsonItemStatus !== "Checked In") {
																$amountAlreadyTaken = $jsonItemArray[1];
																$totalItemAvailability = $totalItemAvailability - $amountAlreadyTaken;
															}
														}
													}

													echo $totalItemAvailability;
												}

											?>
										</td>
										<td>
											<input type="number" max="<?php echo $totalItemAvailability; ?>" min="0" placeholder="0" class="itemsListInputQuantity">
										</td>
										<td class="addItemToList edit-rental__add-items__cart"><i class="fas fa-shopping-cart"></i></td>
									</tr>
								
								@endforeach
								
							</table>
								
							<div class="edit-rental__add-items__no-matches" id="noMatchesItemsTable">
								<h4 class="edit-rental__add-items__no-matches__text">No Items match your search</h4>
							</div>
								
							</div>
						</div>
					</div>
				</div>

				<div class="edit-rental__right">
					<div class="edit-rental__box edit-rental__cart__items-box">
						
						<h5 class="edit-rental__cart__title">Items in cart:</h5>
						
						<div class="edit-rental__cart__heading-row">
						
							<p class="edit-rental__cart__heading__item edit-rental__cart__heading__item__item">Item:</p>
							
							<p class="edit-rental__cart__heading__item edit-rental__cart__heading__item__rate">Rate:</p>
							
							<p class="edit-rental__cart__heading__item edit-rental__cart__heading__item__quantity">QTY:</p>
							
							<p class="edit-rental__cart__heading__item edit-rental__cart__heading__item__total">Total:</p>
							
							<p class="edit-rental__cart__heading__item edit-rental__cart__heading__item__remove"></p>
						
						</div>
						
						<!-- Display Items as they're being added -->
						<ul class="itemsList edit-rental__cart__items"></ul>
						
						<div class="edit-rental__cart__bottom">
							
							<div class="edit-rental__cart__total">
								<p class="edit-rental__cart__total__text">Total Fee: $<span class="edit-rental__cart__total__number">0.00</span></p>
							</div>
							
							<!-- Submit form button -->
							<a class="editRentalSubmit edit-rental__cart__submit">Submit Edit</a>
							
						</div>
						
					</div>
				</div>
				
			</div>
			
			
			
			<div class="edit-rental__errors__container">
			
				<div class="edit-rental__errors alert alert-danger" id="quantity-is-zero" role="alert">
					The quantity must be more than 0 to be able to add it to the cart.
				</div>

				<div class="edit-rental__errors alert alert-danger" id="item-already-in-cart" role="alert">
					That item has already been added to the cart. If you want to change the quantity of that item, remove it from the cart and then add it again with the correct quantity.
				</div>
				
				<div class="edit-rental__errors alert alert-danger" id="no-items-have-been-added" role="alert">
					No items have been added to the cart. You must add items to be able to submit a reservation.
				</div>
				
			</div>
			
		
		</div>
		
		
		<!-- Items Sum Hidden Field -->

		<input type="hidden" class="itemsSum" type="number" name="itemsSum" value="">
		
		
	</form>

@endsection

@section('script')
	<script type="text/javascript" src="/js/edit-rental2.js"></script>
@endsection


