@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

<?php
	
	// Get the data
	$retreivedData = $_GET['data'];

	//Explode the data, seperate into variables
	$retreivedDataArray = explode('-', $retreivedData);
	$retreivedStartDate = $retreivedDataArray[0];
	$retreivedEndDate = $retreivedDataArray[1];
	$retreivedCustomer = $retreivedDataArray[2];
	
	// Reformat the dates by exploding and rearranging
	$startDateArray = explode('/', $retreivedStartDate);
	$startYear = $startDateArray[2];
	$startYearFormatted = substr($startYear,2);
	$startMonth = $startDateArray[0];
	$startDay = $startDateArray[1];
	$startDate = $startYear . "-" . $startMonth . "-" . $startDay;

	$endDateArray = explode('/', $retreivedEndDate);
	$endYear = $endDateArray[2];
	$endYearFormatted = substr($endYear,2);
	$endMonth = $endDateArray[0];
	$endDay = $endDateArray[1];
	$endDate = $endYear . "-" . $endMonth . "-" . $endDay;

	// Calculate the number of the days of the rental period
	$formattedStartDate = strtotime("$startDate");
	$formattedEndDate = strtotime("$endDate");
	$datediff = $formattedEndDate - $formattedStartDate;
	$roundedDateDiff = round($datediff / (60 * 60 * 24));

	// Display date information
	$displayStartDate = $startMonth . "/" . $startDay . "/" . $startYearFormatted;
	$displayEndDate = $endMonth . "/" . $endDay . "/" . $endYearFormatted;
	$startDayOfWeek = date("l", strtotime($startDate));
	$endDayOfWeek = date("l", strtotime($endDate));

	// Display customer information
	$user = DB::table('customers')->where('name', $retreivedCustomer)->first();
	$userEmail = $user->email;
	$userPhone = $user->phonenumber;

?>

@section('title', 'Quipper | New Rental')


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
@section('link-2-active-class', 'sub-nav-active')


<?php 
	$todayDate = date("Y-m-d");
	$todayLink = "/rentals-day?date=" . $todayDate;
?>

@section('link-3-title', 'View Today')
@section('link-3-location', $todayLink)


@section('back-arrow')
	<a href="/rentals/create?data=<?php echo $retreivedStartDate . "-" . $retreivedEndDate . "-" .  $retreivedCustomer; ?>" class="action-panel__back-arrow"><img src="/svg/back-arrow.svg" class="action-panel__back-arrow__icon"></a>
@endsection


@section('panel-title', 'New Rental')

@section('content')

	<form id="submit-rental" method="POST" action="/rentals">
		
		@csrf
		
		<!-- Hidden Inputs From Previous Page -->
		
		<input type="hidden" name="customer" value="<?php echo $retreivedCustomer; ?>">
		<input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
		<input type="hidden" name="endDate" value="<?php echo $endDate; ?>">
		<input type="hidden" name="amountOfDays" id="amountOfDays" value="<?php echo $roundedDateDiff; ?>">
		<input type="hidden" name="status" value="<?php echo "active"; ?>">
		
		
		
		
		<div class="action-panel__content-container__no-title">
			
			
			<div class="create-rental__left-right-container">
			
				<div class="create-rental__left">

					<div class="create-rental__display-data">

						<div class="create-rental__customer-data">
							<div class="create-rental__box">
								
								<div class="create-rental__box__title-container">
									<h5 class="create-rental__box__title">Customer:</h5>
									<h5 class="create-rental__box__icon"><a href="/rentals/create?data=<?php echo $retreivedStartDate . "-" . $retreivedEndDate . "-" .  $retreivedCustomer; ?>"><i class="fas fa-edit"></i></a></h5>
								</div>
								
								<h3 class="create-rental__customer__name"><?php echo $retreivedCustomer; ?></h3>
								
								<div class="create-rental__customer__information-container">
									<p class="create-rental__customer__information"><span class="create-rental__customer__information__title">Email:</span> <?php if ($userEmail) { echo $userEmail; } else { echo 'N/A'; } ?></p>
									<p class="create-rental__customer__information"><span class="create-rental__customer__information__title">Phone:</span> <?php if ($userPhone) { echo $userPhone; } else { echo 'N/A'; } ?></p>
								</div>
								
							</div>
						</div>

						<div class="create-rental__dates-data">
							
							<div class="create-rental__box">
								
								<div class="create-rental__box__title-container">
									<h5 class="create-rental__box__title">Rental dates:</h5>
									<h5 class="create-rental__box__icon"><a href="/rentals/create?data=<?php echo $retreivedStartDate . "-" . $retreivedEndDate . "-" .  $retreivedCustomer; ?>"><i class="fas fa-edit"></i></a></h5>
								</div>
								
								<div class="create-rental__dates-data__block">
									
									<div class="create-rental__dates-data__block__start">
										<div class="create-rental__dates-data__block__content">
											<h4 class="create-rental__dates-data__block__day"><?php echo $startDayOfWeek; ?></h4>
											<h6 class="create-rental__dates-data__block__date"><?php echo $displayStartDate; ?></h6>
										</div>
									</div>
									
									<div class="create-rental__dates-data__block__end">
										
										<div class="create-rental__dates-data__block__end__triangle"></div>
										
										<div class="create-rental__dates-data__block__content">
											<h4 class="create-rental__dates-data__block__day"><?php echo $endDayOfWeek; ?></h4>
											<h6 class="create-rental__dates-data__block__date"><?php echo $displayEndDate; ?></h6>
										</div>
										
									</div>
									
								</div>
								
								<h6 class="create-rental__dates-data__duration"><?php if ($roundedDateDiff > 0) {echo $roundedDateDiff; } else { echo 'Same'; } ?> day rental duration</h6>
								
							</div>
						</div>

					</div>

					<div class="create-rental__add-items">
						
						<h2 class="create-rental__step-title">Add Rental Items</h2>
						
						<div class="create-rental__box create-rental__add-items__box">


							<!-- Add Items -->

							<input class="itemsFormInput" type="text" name="items" value="">

							<h5 class="create-rental__box__title">Search for items to add to cart:</h5>
							<input class="create-rental__add-items__type-input form-control" type="text" id="myInput" onkeyup="myFunction()"  placeholder="Type to begin searching...">
							
							<div class="create-rental__add-items__table__container">
							<table id="myTable" class="create-rental__add-items__table">
								
								<tr class="create-rental__add-items__header">
									<th class="create-rental__add-items__item">Item</th>
									<th class="create-rental__add-items__rate">Rate</th>
									<th class="create-rental__add-items__available"># Available</th>
									<th class="create-rental__add-items__quantity">Quantity:</th>
									<th class="create-rental__add-items__add-to-cart">Add to cart</th>
								</tr>
								
								
								
								@foreach ($rentalItems as $rentalItem)
								
									<tr class="create-rental__add-items__item-row">
										<td class="create-rental__add-items__item-title">{{ $rentalItem->title }}</td>
										<input type="hidden" class="itemsListInputTitle" value="{{ $rentalItem->title }}">
										<td>${{ $rentalItem->firstDayRate . " / " . $rentalItem->secondDayRate }}</td>
										<input type="hidden" class="itemRateFirstDay" value="{{ $rentalItem->firstDayRate }}">
										<input type="hidden" class="itemRateAddDay" value="{{ $rentalItem->secondDayRate }}">
										<td>
											<?php						

												$results = DB::table('rentals')->where([
													['startDate', '<=', $endDate],
													['endDate', '>=', $startDate]
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
										<td class="addItemToList create-rental__add-items__cart"><i class="fas fa-shopping-cart"></i></td>
									</tr>
								
								@endforeach
								
							</table>
								
							<div class="create-rental__add-items__no-matches" id="noMatchesItemsTable">
								<h4 class="create-rental__add-items__no-matches__text">No Items match your search</h4>
							</div>
								
							</div>
						</div>
					</div>
				</div>

				<div class="create-rental__right">
					<div class="create-rental__box create-rental__cart__items-box">
						
						<h5 class="create-rental__cart__title">Items in cart:</h5>
						
						<div class="create-rental__cart__heading-row">
						
							<p class="create-rental__cart__heading__item create-rental__cart__heading__item__item">Item:</p>
							
							<p class="create-rental__cart__heading__item create-rental__cart__heading__item__rate">Rate:</p>
							
							<p class="create-rental__cart__heading__item create-rental__cart__heading__item__quantity">QTY:</p>
							
							<p class="create-rental__cart__heading__item create-rental__cart__heading__item__total">Total:</p>
							
							<p class="create-rental__cart__heading__item create-rental__cart__heading__item__remove"></p>
						
						</div>
						
						<!-- Display Items as they're being added -->
						<ul class="itemsList create-rental__cart__items"></ul>
						
						<div class="create-rental__cart__bottom">
							
							<div class="create-rental__cart__total">
								<p class="create-rental__cart__total__text">Total Fee: $<span class="create-rental__cart__total__number">0.00</span></p>
							</div>
							
							<!-- Submit form button -->
							<a class="createNewRentalSubmit create-rental__cart__submit">Create Reservation</a>
							
						</div>
						
					</div>
				</div>
				
			</div>
			
			
			
			<div class="create-rental__errors__container">
			
				<div class="create-rental__errors alert alert-danger" id="quantity-is-zero" role="alert">
					The quantity must be more than 0 to be able to add it to the cart.
				</div>

				<div class="create-rental__errors alert alert-danger" id="item-already-in-cart" role="alert">
					That item has already been added to the cart. If you want to change the quantity of that item, remove it from the cart and then add it again with the correct quantity.
				</div>
				
				<div class="create-rental__errors alert alert-danger" id="no-items-have-been-added" role="alert">
					No items have been added to the cart. You must add items to be able to create a reservation.
				</div>
				
			</div>
			
		
		</div>
		
		
		<!-- Items Sum Hidden Field -->

		<input type="hidden" class="itemsSum" type="number" name="itemsSum" value="">
		
		
	</form>

@endsection

@section('script')
	<script type="text/javascript" src="/js/create-rental2.js"></script>
@endsection


