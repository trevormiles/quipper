@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

<?php
	
	// Get the data
	$retreivedData = $_GET['data'];

	//Explode the data, seperate into variables
	$retreivedDataArray = explode('-', $retreivedData);
	$retreivedDate = $retreivedDataArray[0];
	$retreivedCustomer = $retreivedDataArray[1];
	$retreivedStartTime = $retreivedDataArray[2];
	$retreivedEndTime = $retreivedDataArray[3];
	
	// Reformat the dates by exploding and rearranging
	$dateArray = explode('/', $retreivedDate);
	$year = $dateArray[2];
	$yearFormatted = substr($year,2);
	$month = $dateArray[0];
	$day = $dateArray[1];
	$date = $year . "-" . $month . "-" . $day;

	// Display date information
	$displayDate = $month . "/" . $day . "/" . $yearFormatted;
	$dayOfWeek = date("l", strtotime($date));

	// Display customer information
	$user = DB::table('customers')->where('name', $retreivedCustomer)->first();
	$userEmail = $user->email;
	$userPhone = $user->phonenumber;

	// Time
	$startTime = date('H:i:s', strtotime($retreivedStartTime));
	$endTime = date('H:i:s', strtotime($retreivedEndTime));

	// Calculate the number of hour of the rental period
	$formattedStartDate = strtotime("$date $startTime");
	$formattedEndDate = strtotime("$date $endTime");
	$dateDiff = $formattedEndDate - $formattedStartDate;
	$roundedDateDiff = round($dateDiff / (60 * 60));

?>

@section('title', 'Quipper | New Booking')


@section('main-nav-1-title', 'Rentals')
@section('main-nav-1-location', '/rentals')

@section('main-nav-2-title', 'Booking')
@section('main-nav-2-location', '/booking')
@section('main-nav-active-2', 'main-nav-active')

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
@section('link-1-title', 'Booking Calendar')
@section('link-1-location', '/booking')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'New Booking')
@section('link-2-location', '/booking/create')
@section('link-2-active-class', 'sub-nav-active')


<?php 
	$todayDate = date("Y-m-d");
	$todayLink = "/booking-day?date=" . $todayDate;
?>

@section('link-3-title', 'View Today')
@section('link-3-location', $todayLink)


@section('link-4-icon')
	<i class="fas fa-history"></i>
@endsection
@section('link-4-title', 'Past Bookings')
@section('link-4-location', '/booking-past')


@section('back-arrow')
	<a href="/booking/create?data=<?php echo $retreivedDate . "-" .  $retreivedCustomer . "-" . $startTime . "-" . $endTime; ?>" class="action-panel__back-arrow"><img src="/svg/back-arrow.svg" class="action-panel__back-arrow__icon"></a>
@endsection


@section('panel-title', 'New Booking')

@section('content')

	<form id="submit-booking" method="POST" action="/booking">
		
		@csrf
		
		<!-- Hidden Inputs From Previous Page -->
		
		<input type="hidden" name="customer" value="<?php echo $retreivedCustomer; ?>">
		<input type="hidden" name="date" value="<?php echo $date; ?>">
		<input type="hidden" name="startTime" value="<?php echo $startTime; ?>">
		<input type="hidden" name="endTime" value="<?php echo $endTime; ?>">
		<input type="hidden" name="amountOfHours" id="amountOfHours" value="<?php echo $roundedDateDiff; ?>">
		
		
		
		
		<div class="action-panel__content-container__no-title">
			
			
			<div class="create-booking__left-right-container">
			
				<div class="create-booking__left">

					<div class="create-booking__display-data">

						<div class="create-booking__customer-data">
							<div class="create-booking__box">
								
								<div class="create-booking__box__title-container">
									<h5 class="create-booking__box__title">Customer:</h5>
									<h5 class="create-booking__box__icon"><a href="/booking/create?data=<?php echo $retreivedDate . "-" . $retreivedCustomer . "-" . $startTime . "-" . $endTime; ?>"><i class="fas fa-edit"></i></a></h5>
								</div>
								
								<h3 class="create-booking__customer__name"><?php echo $retreivedCustomer; ?></h3>
								
								<div class="create-booking__customer__information-container">
									<p class="create-booking__customer__information"><span class="create-booking__customer__information__title">Email:</span> <?php if ($userEmail) { echo $userEmail; } else { echo 'N/A'; } ?></p>
									<p class="create-booking__customer__information"><span class="create-booking__customer__information__title">Phone:</span> <?php if ($userPhone) { echo $userPhone; } else { echo 'N/A'; } ?></p>
								</div>
								
							</div>
						</div>

						<div class="create-booking__dates-data">
							
							<div class="create-booking__box">
								
								<div class="create-booking__box__title-container">
									<h5 class="create-booking__box__title">Booking date and times:</h5>
									<h5 class="create-booking__box__icon"><a href="/booking/create?data=<?php echo $retreivedDate . "-" .  $retreivedCustomer . "-" . $startTime . "-" . $endTime; ?>"><i class="fas fa-edit"></i></a></h5>
								</div>
								
								<div class="create-booking__dates-data__date">
									<h4 class="create-booking__dates-data__date__day"><?php echo $dayOfWeek; ?></h4>
									<h4 class="create-booking__dates-data__date__divider">-</h4>
									<h4 class="create-booking__dates-data__date__full-date"><?php echo $displayDate; ?></h4>
								</div>
								
								<div class="create-booking__dates-data__block">
									
									<div class="create-booking__dates-data__block__start">
										<div class="create-booking__dates-data__block__content">
											<h6 class="create-booking__dates-data__block__time"><?php echo $retreivedStartTime; ?></h6>
										</div>
									</div>
									
									<div class="create-booking__dates-data__block__end">
										
										<div class="create-booking__dates-data__block__end__triangle"></div>
										
										<div class="create-booking__dates-data__block__content">
											<h6 class="create-booking__dates-data__block__time"><?php echo $retreivedEndTime; ?></h6>
										</div>
										
									</div>
									
								</div>
								
								<h6 class="create-booking__dates-data__duration"><?php echo $roundedDateDiff; ?> hour booking duration</h6>
								
							</div>
						</div>

					</div>

					<div class="create-booking__add-items">
						
						<h2 class="create-booking__step-title">Add Booking Items</h2>
						
						<div class="create-booking__box create-booking__add-items__box">


							<!-- Add Items -->

							<input class="itemsFormInput" type="text" name="items" value="">

							<h5 class="create-booking__box__title">Search for items to add to cart:</h5>
							<input class="create-booking__add-items__type-input form-control" type="text" id="myInput" onkeyup="myFunction()"  placeholder="Type to begin searching...">
							
							<div class="create-booking__add-items__table__container">
							<table id="myTable" class="create-booking__add-items__table">
								
								<tr class="create-booking__add-items__header">
									<th class="create-booking__add-items__item">Item</th>
									<th class="create-booking__add-items__rate">Rate</th>
									<th class="create-booking__add-items__quantity"># of people:</th>
									<th class="create-booking__add-items__add-to-cart">Add to cart</th>
								</tr>
								
								
								
								@foreach ($bookingItems as $bookingItem)
								
									<tr class="create-booking__add-items__item-row">
										<td class="create-booking__add-items__item-title">{{ $bookingItem->title }}</td>
										<input type="hidden" class="itemsListInputTitle" value="{{ $bookingItem->title }}">
										<td>${{ $bookingItem->firstHourRate . " / " . $bookingItem->additionalHourRate }}</td>
										<input type="hidden" class="itemRateFirstHour" value="{{ $bookingItem->firstHourRate }}">
										<input type="hidden" class="itemRateAddHour" value="{{ $bookingItem->additionalHourRate }}">
										<td>
											<input type="number" min="0" placeholder="0" class="itemsListInputQuantity create-booking__add-items__item-quantity">
										</td>
										<td class="addItemToList create-booking__add-items__cart"><i class="fas fa-shopping-cart"></i></td>
									</tr>
								
								@endforeach
								
							</table>
								
							<div class="create-booking__add-items__no-matches" id="noMatchesItemsTable">
								<h4 class="create-booking__add-items__no-matches__text">No Items match your search</h4>
							</div>
								
							</div>
						</div>
					</div>
				</div>

				<div class="create-booking__right">
					<div class="create-booking__box create-booking__cart__items-box">
						
						<h5 class="create-booking__cart__title">Items in cart:</h5>
						
						<div class="create-booking__cart__heading-row">
						
							<p class="create-booking__cart__heading__item create-booking__cart__heading__item__item">Item:</p>
							
							<p class="create-booking__cart__heading__item create-booking__cart__heading__item__rate">Rate:</p>
							
							<p class="create-booking__cart__heading__item create-booking__cart__heading__item__quantity"># PPL:</p>
							
							<p class="create-booking__cart__heading__item create-booking__cart__heading__item__total">Total:</p>
							
							<p class="create-booking__cart__heading__item create-booking__cart__heading__item__remove"></p>
						
						</div>
						
						<!-- Display Items as they're being added -->
						<ul class="itemsList create-booking__cart__items"></ul>
						
						<div class="create-booking__cart__bottom">
							
							<div class="create-booking__cart__total">
								<p class="create-booking__cart__total__text">Total Fee: $<span class="create-booking__cart__total__number">0.00</span></p>
							</div>
							
							<!-- Submit form button -->
							<a class="createNewBookingSubmit create-booking__cart__submit">Create Reservation</a>
							
						</div>
						
					</div>
				</div>
				
			</div>
			
			
			
			<div class="create-booking__errors__container">
			
				<div class="create-booking__errors alert alert-danger" id="quantity-is-zero" role="alert">
					The # of people must be more than 0 to be able to add it to the cart.
				</div>

				<div class="create-booking__errors alert alert-danger" id="item-already-in-cart" role="alert">
					That item has already been added to the cart. If you want to change the # of people of that item, remove it from the cart and then add it again with the correct quantity.
				</div>
				
				<div class="create-booking__errors alert alert-danger" id="no-items-have-been-added" role="alert">
					No items have been added to the cart. You must add items to be able to create a reservation.
				</div>
				
			</div>
			
		
		</div>
		
		
		<!-- Items Sum Hidden Field -->

		<input type="hidden" class="itemsSum" type="number" name="itemsSum" value="">
		
		
	</form>

@endsection

@section('script')
	<script type="text/javascript" src="/js/create-booking2.js"></script>
@endsection


