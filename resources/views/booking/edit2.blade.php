@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

<?php
	
	// Get the data
	$retreivedData = $_GET['data'];

	//Explode the data, seperate into variables
	$retreivedDataArray = explode('-', $retreivedData);
	$retreivedBookingID = $retreivedDataArray[0];
	$retreivedDate = $retreivedDataArray[1];
	$retreivedCustomer = $retreivedDataArray[2];
	$retreivedStartTime = $retreivedDataArray[3];
	$retreivedEndTime = $retreivedDataArray[4];
	
	// Reformat the dates by exploding and rearranging
	$dateArray = explode('/', $retreivedDate);
	$year = $dateArray[2];
	$yearFormatted = substr($year,2);
	$month = $dateArray[0];
	$day = $dateArray[1];
	$date = $year . "-" . $month . "-" . $day;

	// Calculate the number of hours of the booking period
	$formattedStartDate = strtotime("$date $retreivedStartTime");
	$formattedEndDate = strtotime("$date $retreivedEndTime");
	$datediff = $formattedEndDate - $formattedStartDate;
	$roundedDateDiff = round($datediff / (60 * 60));

	// Time
	$startTime = date('H:i:s', strtotime($retreivedStartTime));
	$endTime = date('H:i:s', strtotime($retreivedEndTime));

	// Display date information
	$displayDate = $month . "/" . $day . "/" . $yearFormatted;
	$dayOfWeek = date("l", strtotime($date));


	// Get the booking information based off of the given booking ID passed in through the URL
	$booking = DB::table('bookings')->where('id', $retreivedBookingID)->get();
	$booking = json_decode(json_encode($booking), true);
	$retreivedBookingItems = $booking[0]["items"];
	$retreivedBookingItemsArray = json_decode($retreivedBookingItems);



	
	////////// Now compile that all into a string so it can be passed to the javascript and reconstructed there ///////////

	// First create an array that will be added on to in the loop below
	$stringedBookingItems = [];
	
	// Now loop through the items array and add it to the stringedBookingItems
	foreach ($retreivedBookingItemsArray as $retreivedBookingItem) {
		$itemTitle = $retreivedBookingItem[0];
		$itemQuantity = $retreivedBookingItem[1];
		$itemHours = $roundedDateDiff;
		
		if ($itemHours > 0) {
			$itemHoursMinusOne = $itemHours - 1;
		} else {
			$itemHoursMinusOne = 0;
		}
		
		$itemFirstHourRate = $retreivedBookingItem[3];
		$itemSecondHourRate = $retreivedBookingItem[4];
		
		$additionalHourTotal = $itemSecondHourRate * $itemHoursMinusOne;
		$itemTotal = ($itemFirstHourRate + $additionalHourTotal) * $itemQuantity;
		$itemTotalDecimal = number_format($itemTotal, 2);
		
		$itemString = $itemTitle . "?" . $itemQuantity . "?" . $itemHours . "?" . $itemFirstHourRate . "?" . $itemSecondHourRate . "?" . $itemTotalDecimal;
		
		array_push($stringedBookingItems, $itemString);
		
	}

	$stringedBookingItemsImploded = implode(":",$stringedBookingItems);

	
	// Display customer information
	$user = DB::table('customers')->where('name', $retreivedCustomer)->first();
	$userEmail = $user->email;
	$userPhone = $user->phonenumber;

?>

@section('title', 'Quipper | Edit Booking')


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


@section('panel-title', 'Edit Booking')

@section('content')

	<input type="hidden" id="retreivedBookingItems" value="<?php echo $stringedBookingItemsImploded; ?>">

	<form method="POST" action="/booking/<?php echo $retreivedBookingID; ?>" id="submit-booking-edit">
						
		{{ method_field('PATCH') }}
		{{ csrf_field() }}
		
		<!-- Hidden Inputs From Previous Page -->
		
		<input type="hidden" name="customer" value="<?php echo $retreivedCustomer; ?>">
		<input type="hidden" name="date" value="<?php echo $date; ?>">
		<input type="hidden" name="startTime" value="<?php echo $retreivedStartTime; ?>">
		<input type="hidden" name="endTime" value="<?php echo $retreivedEndTime; ?>">
		<input type="hidden" name="amountOfHours" id="amountOfHours" value="<?php echo $roundedDateDiff; ?>">
		
		
		
		
		<div class="action-panel__content-container__no-title">
			
			
			<div class="edit-booking__left-right-container">
			
				<div class="edit-booking__left">

					<div class="edit-booking__display-data">

						<div class="edit-booking__customer-data">
							<div class="edit-booking__box">
								
								<div class="edit-booking__box__title-container">
									<h5 class="edit-booking__box__title">Customer:</h5>
									<h5 class="edit-booking__box__icon"><a href="/booking/<?php echo $retreivedBookingID; ?>/edit"><i class="fas fa-edit"></i></a></h5>
								</div>
								
								<h3 class="edit-booking__customer__name"><?php echo $retreivedCustomer; ?></h3>
								
								<div class="edit-booking__customer__information-container">
									<p class="edit-booking__customer__information"><span class="edit-booking__customer__information__title">Email:</span> <?php if ($userEmail) { echo $userEmail; } else { echo 'N/A'; } ?></p>
									<p class="edit-booking__customer__information"><span class="edit-booking__customer__information__title">Phone:</span> <?php if ($userPhone) { echo $userPhone; } else { echo 'N/A'; } ?></p>
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

					<div class="edit-booking__add-items">
						
						<h2 class="edit-booking__step-title">Add Booking Items</h2>
						
						<div class="edit-booking__box edit-booking__add-items__box">


							<!-- Add Items -->

							<input class="itemsFormInput" type="text" name="items" value="">

							<h5 class="edit-booking__box__title">Search for items to add to cart:</h5>
							<input class="edit-booking__add-items__type-input form-control" type="text" id="myInput" onkeyup="myFunction()"  placeholder="Type to begin searching...">
							
							<div class="edit-booking__add-items__table__container">
							<table id="myTable" class="edit-booking__add-items__table">
								
								<tr class="edit-booking__add-items__header">
									<th class="edit-booking__add-items__item">Item</th>
									<th class="edit-booking__add-items__rate">Rate</th>
									<th class="edit-booking__add-items__quantity"># of PPL:</th>
									<th class="edit-booking__add-items__add-to-cart">Add to cart</th>
								</tr>
								
								
								
								@foreach ($bookingItems as $bookingItem)
								
									<tr class="edit-booking__add-items__item-row">
										<td class="edit-booking__add-items__item-title">{{ $bookingItem->title }}</td>
										<input type="hidden" class="itemsListInputTitle" value="{{ $bookingItem->title }}">
										<td>${{ $bookingItem->firstHourRate . " / " . $bookingItem->additionalHourRate }}</td>
										<input type="hidden" class="itemRateFirstHour" value="{{ $bookingItem->firstHourRate }}">
										<input type="hidden" class="itemRateAddHour" value="{{ $bookingItem->additionalHourRate }}">
										<td>
											<input type="number" min="0" placeholder="0" class="itemsListInputQuantity edit-booking__add-items__item-quantity">
										</td>
										<td class="addItemToList edit-booking__add-items__cart"><i class="fas fa-shopping-cart"></i></td>
									</tr>
								
								@endforeach
								
							</table>
								
							<div class="edit-booking__add-items__no-matches" id="noMatchesItemsTable">
								<h4 class="edit-booking__add-items__no-matches__text">No Items match your search</h4>
							</div>
								
							</div>
						</div>
					</div>
				</div>

				<div class="edit-booking__right">
					<div class="edit-booking__box edit-booking__cart__items-box">
						
						<h5 class="edit-booking__cart__title">Items in cart:</h5>
						
						<div class="edit-booking__cart__heading-row">
						
							<p class="edit-booking__cart__heading__item edit-booking__cart__heading__item__item">Item:</p>
							
							<p class="edit-booking__cart__heading__item edit-booking__cart__heading__item__rate">Rate:</p>
							
							<p class="edit-booking__cart__heading__item edit-booking__cart__heading__item__quantity"># of PPL:</p>
							
							<p class="edit-booking__cart__heading__item edit-booking__cart__heading__item__total">Total:</p>
							
							<p class="edit-booking__cart__heading__item edit-booking__cart__heading__item__remove"></p>
						
						</div>
						
						<!-- Display Items as they're being added -->
						<ul class="itemsList edit-booking__cart__items"></ul>
						
						<div class="edit-booking__cart__bottom">
							
							<div class="edit-booking__cart__total">
								<p class="edit-booking__cart__total__text">Total Fee: $<span class="edit-booking__cart__total__number">0.00</span></p>
							</div>
							
							<!-- Submit form button -->
							<a class="editBookingSubmit edit-booking__cart__submit">Submit Edit</a>
							
						</div>
						
					</div>
				</div>
				
			</div>
			
			
			
			<div class="edit-booking__errors__container">
			
				<div class="edit-booking__errors alert alert-danger" id="quantity-is-zero" role="alert">
					The quantity must be more than 0 to be able to add it to the cart.
				</div>

				<div class="edit-booking__errors alert alert-danger" id="item-already-in-cart" role="alert">
					That item has already been added to the cart. If you want to change the quantity of that item, remove it from the cart and then add it again with the correct quantity.
				</div>
				
				<div class="edit-booking__errors alert alert-danger" id="no-items-have-been-added" role="alert">
					No items have been added to the cart. You must add items to be able to submit a reservation.
				</div>
				
			</div>
			
		
		</div>
		
		
		<!-- Items Sum Hidden Field -->

		<input type="hidden" class="itemsSum" type="number" name="itemsSum" value="">
		
		
	</form>

@endsection

@section('script')
	<script type="text/javascript" src="/js/edit-booking2.js"></script>
@endsection


