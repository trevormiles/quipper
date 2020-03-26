@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

@section('title', 'Quipper | Booking')


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
@section('link-1-active-class', 'sub-nav-active')


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



@section('panel-title', 'Booking Calendar')

@section('content')

	<?php

		// Get all bookings. If there are no bookings, turn that variable to false

		$bookings = DB::table('bookings')->where('bookingDate', '>=', date('Y-m-d'))->where('status', '=', 'active')->get();
		$bookingsCounted = $bookings->count();

		if($bookingsCounted == 0) {
			$areThereBookings = false;
		} else {
			$areThereBookings = true;
		}

		




		////////////////////////////////// Open the if statment here. If there aren't any bookings, nothing runs //////////////////////////////////////////////

		if ($areThereBookings == true) {
			
		


			////// Get the start date for each booking in the database //////

			$startDates = array();
			foreach($bookings as $booking){
				$startDates[] = $booking->bookingDate;
			}

			//var_dump($startDates);







			////// Organize the start dates according to their date ////////

			function date_sort($a, $b) {
				return strtotime($a) - strtotime($b);
			}

			usort($startDates, "date_sort");

			//print_r($startDates);






			////// For each of those start dates, get all the bookings that have that start date //////

			$orderedBookings = array();
			foreach($startDates as $startDate){
				$resultedDate = DB::table('bookings')->where('bookingDate', $startDate)->get();
				$orderedBookings[] = $resultedDate;
			}

			//var_dump(json_decode(json_encode($orderedBookings)));






			///// Flatten those Ordered Bookings so that there are no nested bookings under same date, and get the start date and the end date /////

			$decodedOrderedBookings = json_decode(json_encode($orderedBookings));
			$flattenedOrderedBookings = call_user_func_array('array_merge', $decodedOrderedBookings);

			//var_dump($flattenedOrderedBookings);


			$flattenedOrderedBookingsStartDate = date("Y-m-d");


			//Figure out the end booking

			$endDates = array();
			foreach($bookings as $booking){
				$endDates[] = $booking->bookingDate;
			}

			//var_dump($endDates);

			$endDatesOrganized = max($endDates);

			//var_dump($endDatesOrganized);

			$flattenedOrderedBookingsEndDate = $endDatesOrganized;

			//var_dump($flattenedOrderedBookings[0]->startDate);
			//var_dump($flattenedOrderedBookingsStartDate);
			//var_dump($flattenedOrderedBookingsEndDate);










			///// Declare Date Range Function //////

			function getDatesFromRange($start, $end, $format = 'Y-m-d') {
				$array = array();
				$interval = new DateInterval('P1D');

				$realEnd = new DateTime($end);
				$realEnd->add($interval);

				$period = new DatePeriod(new DateTime($start), $interval, $realEnd);

				foreach($period as $date) { 
					$array[] = $date->format($format); 
				}

				return $array;
			}





			////// Figure out how many StrToTime days are between the start and end date and add to it if it's not enough ////////

			// Figure out how many StrToTime days are between the start and end date
			$flattenedOrderedBookingsEndDateStrToTime = strtotime($flattenedOrderedBookingsEndDate);
			$flattenedOrderedBookingsStartDateStrToTime = strtotime($flattenedOrderedBookingsStartDate);
			$startAndEndDateDifference = $flattenedOrderedBookingsEndDateStrToTime - $flattenedOrderedBookingsStartDateStrToTime;

			// See how many days that is in a human number
			// echo round($startAndEndDateDifference / (60 * 60 * 24));

			// See how big a StrToTime should be for a 12 day period
			// 86,400 is one day
			// 12 days would be 1036800

			// Run if statement to ensure that our date range will always be at least 12 days
			if ($startAndEndDateDifference < 1036800) {
				$lackingDifferenceToMakeTwelve = 1036800 - $startAndEndDateDifference;
				$newFlattenedOrderedBookingsEndDateStrToTime = $flattenedOrderedBookingsEndDateStrToTime + $lackingDifferenceToMakeTwelve;
				$flattenedOrderedBookingsEndDate = date('Y/m/d', $newFlattenedOrderedBookingsEndDateStrToTime);
			}




			////// Call Date Range Function inputing our start and end dates

			$dates = getDatesFromRange($flattenedOrderedBookingsStartDate, $flattenedOrderedBookingsEndDate);

			/*
			foreach($dates as $date){ 
				echo $date . ' ';
			}
			*/
			
		}
		
	
	?>


	<?php if ($areThereBookings == true) : ?>

	
	<div class="booking">

		<div class="booking__customer-box">

			<table>

				<tr>
					<th class="booking__customer-box__table-heading">
						<p class="booking__customer-box__heading booking__customer-box__heading__renter">Customer</p>
					</th>

					<th class="booking__customer-box__table-heading">
						<p class="booking__customer-box__heading">Type</p>
					</th>
				</tr>

				@foreach ($bookings->sortBy('bookingDate') as $booking)
				
					<?php
						$bookingData = $booking;
						$bookingDataEncoded = json_decode(json_encode($bookingData), true);
						$bookingDataItems = $bookingDataEncoded["items"];
						$bookingDataItemsDecoded = 	json_decode($bookingDataItems, true);
					?>

					<tr class="booking__customer-box__data">
						<td class="booking__customer-box__table-data">
							<a class="booking__customer-box__link" href="/booking/{{ $booking->id }}">
								<p class="booking__customer-box__name">{{ $booking->customer }}</p>
							</a>
						</td>

						<td class="booking__customer-box__table-data">
							<a class="booking__customer-box__link" href="/booking/{{ $booking->id }}">
								<p class="booking__customer-box__date">
									<?php
										$amountOfBookingItems = count($bookingDataItemsDecoded);

										if ($amountOfBookingItems > 1) {
											echo "Multiple";
										} else {
											$bookingItemTitle = $bookingDataItemsDecoded[0][0];
											$bookingItemTitle = str_replace('Reservation', '', $bookingItemTitle);
											echo $bookingItemTitle;
										}
									?>
								</p>
							</a>
						</td>
					</tr>

				@endforeach

			</table>

		</div>

		<div class="booking__container" id="booking__container">
			<table class="booking__table">

				<tr class="booking__table__date-row">
					@foreach ($dates as $date)

						<?php
							$newDate = date("m-d-Y", strtotime($date));
							$dateArr = explode('-', $newDate);

							$unixTimestamp = strtotime($date);
							$dayOfWeek = date("l", $unixTimestamp);
						?>	

						<th class="booking__table__date-heading <?php if ($date === date("Y-m-d")) echo "special-class" ?>">
							
							<a class="booking__table__date-heading__text" href="/booking-day?date=<?php echo $date ?>">
								<p class="booking__table__date-heading__day">{{ $dayOfWeek }}<?php if($date === date("Y-m-d")) : ?><span class="special-class__today"> - Today</span><?php endif; ?></p>
								<p class="booking__table__date-heading__date"><?php echo $dateArr[0] . "/" . $dateArr[1] ?></p>
							</a>
							
						</th>

					@endforeach
				</tr>
				
				<?php $pixelsToScrollFromTop = 45; ?>

				@foreach ($bookings->sortBy('bookingDate') as $booking)

					<?php
	
						// Get the reservation's start and end date
						$itemStartDate = $booking->bookingDate;
						$itemEndDate = $booking->bookingDate;
									
						//////////////// Create the status functionality for each reservation ////////////////////
									
						// Get how many pixels would need to be scrolled for this item's beginning on the calendar
						$flatOrderedBookingsStartDateStrToTime = strtotime($flattenedOrderedBookingsStartDate);
						$itemStartDateStrToTime = strtotime($itemStartDate);
						$startDateItemStartDateDiffTime = $itemStartDateStrToTime - $flatOrderedBookingsStartDateStrToTime;
						$startDateItemStartDateDiffDays = round($startDateItemStartDateDiffTime / (60 * 60 * 24));
						$amountOfPixelsToScrollForThisItemsBeginning = $startDateItemStartDateDiffDays * 185;
									
						// Get how many pixels wide this item is on the calendar
						$itemEndDateStrToTime = strtotime($itemEndDate);
						$itemWidthInTime = $itemEndDateStrToTime - $itemStartDateStrToTime;
						$itemWidthInDays = round($itemWidthInTime / (60 * 60 * 24));
						$itemWidthInPixels = $itemWidthInDays * 185;
						$itemWidthInPixels = $itemWidthInPixels + 185;
									
						// Get amount of pixels to pushed from the top for each item
						$thisItemsPixelsToScrollFromTop = $pixelsToScrollFromTop + 12.5;
						$pixelsToScrollFromTop = $pixelsToScrollFromTop + 45;
				
					?>


					<tr class="booking__table__bookings-row">
						@foreach ($dates as $date)
							<th class="booking__table__bookings-box <?php if (date("Y-m-d") > $itemEndDate) echo "late"; ?>">
								
								
									<?php if($itemStartDate === $date && $itemEndDate === $date) : ?>
										<a href="/booking/{{ $booking->id }}">
    										<div class="booking__table__bookings-box__start-end"></div>
										</a>
									<?php elseif($itemStartDate === $date) : ?>
										<a href="/booking/{{ $booking->id }}">
											<div class="booking__table__bookings-box__start"></div>
										</a>
									<?php elseif($itemEndDate === $date) : ?>
										<a href="/booking/{{ $booking->id }}">
											<div class="booking__table__bookings-box__end"></div>
										</a>
									<?php elseif($date > $itemStartDate && $date < $itemEndDate) : ?>
										<a href="/booking/{{ $booking->id }}">
											<div class="booking__table__bookings-box__middle"></div>
										</a>
									<?php endif; ?>
								
							</th>
						@endforeach
						
						<?php

							$customerStartDate = $booking->startTime;
							$customerStartDateFormatted = date("g:i A", strtotime("$customerStartDate"));

							$customerEndDate = $booking->endTime;
							$customerEndDateFormatted = date("g:i A", strtotime("$customerEndDate"));

						?>
						
						<a href="/booking/{{ $booking->id }}" class="booking__table__bookings-row__status" style="position: absolute; top: <?php echo $thisItemsPixelsToScrollFromTop; ?>px; left: <?php echo $amountOfPixelsToScrollForThisItemsBeginning; ?>px; width: <?php echo $itemWidthInPixels ?>px;">
							
							<?php
								echo $customerStartDateFormatted . " - " . $customerEndDateFormatted;
							?>
							
						</a>
						
					</tr>

				@endforeach

			</table>
		</div>
		
		<?php
		
		$dateToday = date("Y-m-d");

		$date1 = date_create($dateToday);
		$date2 = date_create($flattenedOrderedBookingsStartDate);
		$date3 = date_create($flattenedOrderedBookingsEndDate);

		//difference between two dates
		$diff = date_diff($date1,$date2);

		$diffFormatted = $diff->format("%a");

		?>


		<?php 

			if ($date1 >= $date2 && $date1 <= $date3) {
				$amountPixelsToScroll = $diffFormatted*185;
			} else {
				$amountPixelsToScroll = 0;
			}

		?>

		<script>
			var elmnt = document.getElementById("booking__container");
			elmnt.scrollLeft = "<?php echo $amountPixelsToScroll; ?>";
		</script>

	</div>


	<?php endif; ?>



	<?php if ($areThereBookings == false) : ?>
		<div class="booking__no-active">
			<h1 class="booking__no-active__heading">There are no upcoming bookings.</h1>
			<h6 class="booking__no-active__sub-heading">Click on "New Booking" in the navigation to create a new booking.</h6>
		</div>
	<?php endif; ?>



@endsection

