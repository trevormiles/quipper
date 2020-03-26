@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

<?php

	// Set up displaying the date
	$retreivedDate = $_GET['date'];
	$newRetreivedDate =  date("M-d-Y", strtotime($retreivedDate)); 
	$newDateArr = explode('-', $newRetreivedDate);
	$month = $newDateArr[0];
	$day = $newDateArr[1];
	$monthDay = $month . "." . " " . $day;

	if ($retreivedDate === date("Y-m-d")) {
		$monthDay = "Bookings Today";
	} else {
		$monthDay = "Bookings";
	}

	$retreivedDateTitle = "Quipper | " . $monthDay;


	$fullTextRetreivedDate = date("F-d-Y", strtotime($retreivedDate));
	$newFullDateArr = explode('-', $fullTextRetreivedDate);
	$fullMonth = $newFullDateArr[0];
	$fullDay = $newFullDateArr[1];
	$fullYear = $newFullDateArr[2];
	$fullMonthDay = $fullMonth . " " . $fullDay . "," . " " . $fullYear;

	if ($retreivedDate === date("Y-m-d")) {
		$fullMonthDay = "Today - " . $fullMonthDay;
	}

	





	//////////////// Get each booking item and see if there is a booking for that item this day ////////////////////////

	$allBookingItemInstancesArray = [];
	
	foreach ($bookingItems as $bookingItem) {
		
		$bookingItemTitle = $bookingItem["title"];
		
		$thisBookingItemArray = [$bookingItemTitle];
		
		$bookingItemInstances = DB::table('bookings')->where([
									['bookingDate', '=', $retreivedDate],
									['items', 'LIKE', '%'.$bookingItemTitle.'%'],
									['status', '=', 'active']
								])->get();

		$bookingItemInstancesArray = json_decode(json_encode($bookingItemInstances), true);
		
		
		// Now loop through each of the matching results and only get the part of the booking that pertains to the matching booking name.
		
		foreach ($bookingItemInstancesArray as $bookingItemInstanceArray) {
			
			$bookingItemInstanceItems = $bookingItemInstanceArray["items"];
			$bookingItemInstanceItemsArray = json_decode($bookingItemInstanceItems, true);
			
			foreach ($bookingItemInstanceItemsArray as $bookingItem) {
				$bookingItemName = $bookingItem[0];
				
				if ($bookingItemName == $bookingItemTitle) {
					$bookingItemQuantity = $bookingItem[1];
					$bookingItemHours = $bookingItem[2];
					$bookingItemFirstHourRate = $bookingItem[3];
					$bookingItemAddHourRate = $bookingItem[4];
					$bookingItemTotal = $bookingItem[5];
					
					$bookingItemInstanceID = $bookingItemInstanceArray["id"];
					$bookingItemInstanceCustomer = $bookingItemInstanceArray["customer"];
					$bookingItemInstanceStartTime = $bookingItemInstanceArray["startTime"];
					$bookingItemInstanceEndTime = $bookingItemInstanceArray["endTime"];
					
					$matchingBookingItemInformation = [$bookingItemInstanceID, $bookingItemInstanceCustomer, $bookingItemInstanceStartTime, $bookingItemInstanceEndTime, $bookingItemQuantity, $bookingItemHours, $bookingItemFirstHourRate, $bookingItemAddHourRate, $bookingItemTotal];
					array_push($thisBookingItemArray, $matchingBookingItemInformation);
				}
			}
		}
		
		array_push($allBookingItemInstancesArray, $thisBookingItemArray);
	}




	// Check to see if there are no bookings this day if array's are empty
	
	$isAllBookingItemInstancesArrayEmpty = false;
	$arrayToCheckEachItemInstance = [];

	foreach ($allBookingItemInstancesArray as $checkBookingItemArrayInstance) {
		
		$checkBookingItemArrayInstanceCounted = count($checkBookingItemArrayInstance);
		
		if ($checkBookingItemArrayInstanceCounted > 1) {
			array_push($arrayToCheckEachItemInstance, $checkBookingItemArrayInstanceCounted);
		}
	}

	if (empty($arrayToCheckEachItemInstance)) {
		$isAllBookingItemInstancesArrayEmpty = true;
	}


	
	// Set up the function that will organize the arrays according to their start time which will be used below

	function date_compare($a, $b)
	{
		$t1 = strtotime($a[2]);
		$t2 = strtotime($b[2]);
		return $t1 - $t2;
	}

?>


@section('title', $retreivedDateTitle)


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

<?php if($todayDate === $retreivedDate) : ?>
	@section('link-3-active-class', 'sub-nav-active')
<?php endif; ?>


@section('link-4-icon')
	<i class="fas fa-history"></i>
@endsection
@section('link-4-title', 'Past Bookings')
@section('link-4-location', '/booking-past')


@section('panel-title', $fullMonthDay)

@section('content')
	

	<?php if ($isAllBookingItemInstancesArrayEmpty == false) : ?>

	<div class="booking-day">
		
		<?php foreach ($allBookingItemInstancesArray as $bookingItemInstancesArray) : ?>
		
			<?php $bookingItemInstancesArrayCounted = count($bookingItemInstancesArray); ?>
		
			<?php if ($bookingItemInstancesArrayCounted > 1 ) : ?>
		
				<div class="booking-day__instance">
		
					<?php $bookingItemInstanceArrayTitle = $bookingItemInstancesArray[0]; ?>

					<h2 class="booking-day__title"><?php echo $bookingItemInstanceArrayTitle; ?></h2>

					<div class="booking-day__header">

						<h6 class="booking-day__header__customer">Customer:</h6>

						<div class="booking-day__header__items-container">

							<h6 class="booking-day__header__item booking-day__header__item__start-time">Start Time:</h6>
							<h6 class="booking-day__header__item booking-day__header__item__end-time">End Time:</h6>
							<h6 class="booking-day__header__item booking-day__header__item__hours"># of hours:</h6>
							<h6 class="booking-day__header__item booking-day__header__item__quantity"># of people:</h6>
							<h6 class="booking-day__header__item booking-day__header__item__fee">Fee:</h6>

						</div>

					</div>

					<?php
						array_shift($bookingItemInstancesArray);
						//dd($bookingItemInstancesArray);
					
						// Organize the arrays according to their start time  
						usort($bookingItemInstancesArray, 'date_compare');
						
					?>

					<?php foreach($bookingItemInstancesArray as $bookingData): ?>
						<a href="/booking/<?php echo $bookingData[0]; ?>" class="booking-day__booking">

							<div class="booking-day__booking__container">

								<h6 class="booking-day__booking__customer"><?php echo $bookingData[1]; ?></h6>

								<div class="booking-day__booking__items-container">
									
									<?php 
										$formattedStartTime = date('g:i A', strtotime($bookingData[2]));
										$formattedEndTime = date('g:i A', strtotime($bookingData[3]));
									?>

									<div class="booking-day__booking__item-container">
										<h6 class="booking-day__booking__item booking-day__booking__item__start-time"><?php echo $formattedStartTime; ?></h6>
										<h6 class="booking-day__booking__item booking-day__booking__item__end-time"><?php echo $formattedEndTime; ?></h6>
										<h6 class="booking-day__booking__item booking-day__booking__item__hours"><?php echo $bookingData[5]; ?></h6>
										<h6 class="booking-day__booking__item booking-day__booking__item__quantity"><?php echo $bookingData[4]; ?></h6>
										<h6 class="booking-day__booking__item booking-day__booking__item__fee"><?php echo "$" . number_format($bookingData[8], 2); ?></h6>
									</div>

								</div>

							</div>

						</a>

					<?php endforeach; ?>
					
				</div>

			<?php endif; ?>
		
		<?php endforeach; ?>
		
	</div>

	<?php endif; ?>




	
	<?php if ($isAllBookingItemInstancesArrayEmpty == true) : ?>
		<div class="booking-day__none">
			<h1 class="booking-day__none__text">There are no bookings this day</h1>
		</div>
	<?php endif; ?>
	


	
@endsection