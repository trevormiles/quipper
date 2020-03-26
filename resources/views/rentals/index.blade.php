@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

@section('title', 'Quipper | Rentals')


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
@section('link-1-location', '/rentals')
@section('link-1-active-class', 'sub-nav-active')


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



@section('panel-title', 'Rental Calendar')

@section('content')

	<?php

		// Get active rentals. If there are no active rentals, turn that variable to false

		$activeRentals = DB::table('rentals')->where('status', 'active')->get();
		$activeRentalsCounted = $activeRentals->count();

		if($activeRentalsCounted == 0) {
			$areThereActiveRentals = false;
		} else {
			$areThereActiveRentals = true;
		}

		




		////////////////////////////////// Open the if statment here. If there aren't active rentals, nothing runs //////////////////////////////////////////////

		if ($areThereActiveRentals == true) {
			
		


			////// Get the start date for each rental in the database //////

			$startDates = array();
			foreach($activeRentals as $rental){
				$startDates[] = $rental->startDate;
			}

			//var_dump($startDates);







			////// Organize the start dates according to their date ////////

			function date_sort($a, $b) {
				return strtotime($a) - strtotime($b);
			}

			usort($startDates, "date_sort");

			//print_r($startDates);






			////// For each of those start dates, get all the rentals that have that start date //////

			$orderedRentals = array();
			foreach($startDates as $startDate){
				$resultedDate = DB::table('rentals')->where('startDate', $startDate)->where('status', 'active')->get();
				$orderedRentals[] = $resultedDate;
			}

			//var_dump(json_decode(json_encode($orderedRentals)));






			///// Flatten those Ordered Rentals so that there are no nested rentals under same date, and get the start date and the end date /////

			$decodedOrderedRentals = json_decode(json_encode($orderedRentals));
			$flattenedOrderedRentals = call_user_func_array('array_merge', $decodedOrderedRentals);

			//var_dump($flattenedOrderedRentals);


			$flattenedOrderedRentalsStartDate = $flattenedOrderedRentals[0]->startDate;


			//Figure out the end rental

			$endDates = array();
			foreach($activeRentals as $rental){
				$endDates[] = $rental->endDate;
			}

			//var_dump($endDates);

			$endDatesOrganized = max($endDates);

			//var_dump($endDatesOrganized);

			$flattenedOrderedRentalsEndDate = $endDatesOrganized;

			//var_dump($flattenedOrderedRentals[0]->startDate);
			//var_dump($flattenedOrderedRentalsStartDate);
			//var_dump($flattenedOrderedRentalsEndDate);










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





			////// Figure out how many StrToTime days are between the start and end date and to it if it's not enough ////////

			// Figure out how many StrToTime days are between the start and end date
			$flattenedOrderedRentalsEndDateStrToTime = strtotime($flattenedOrderedRentalsEndDate);
			$flattenedOrderedRentalsStartDateStrToTime = strtotime($flattenedOrderedRentalsStartDate);
			$startAndEndDateDifference = $flattenedOrderedRentalsEndDateStrToTime - $flattenedOrderedRentalsStartDateStrToTime;

			// See how many days that is in a human number
			// echo round($startAndEndDateDifference / (60 * 60 * 24));

			// See how big a StrToTime should be for a 12 day period
			// 86,400 is one day
			// 12 days would be 1036800

			// Run if statement to ensure that our date range will always be at least 12 days
			if ($startAndEndDateDifference < 1036800) {
				$lackingDifferenceToMakeTwelve = 1036800 - $startAndEndDateDifference;
				$newFlattenedOrderedRentalsEndDateStrToTime = $flattenedOrderedRentalsEndDateStrToTime + $lackingDifferenceToMakeTwelve;
				$flattenedOrderedRentalsEndDate = date('Y/m/d', $newFlattenedOrderedRentalsEndDateStrToTime);
			}




			////// Call Date Range Function inputing our start and end dates

			$dates = getDatesFromRange($flattenedOrderedRentalsStartDate, $flattenedOrderedRentalsEndDate);

			/*
			foreach($dates as $date){ 
				echo $date . ' ';
			}
			*/
			
		}
		
	
	?>


	<?php if ($areThereActiveRentals == true) : ?>

	
	<div class="rentals">

		<div class="rentals__customer-box">

			<table>

				<tr>
					<th class="rentals__customer-box__table-heading">
						<p class="rentals__customer-box__heading rentals__customer-box__heading__renter">Customer</p>
					</th>

					<th class="rentals__customer-box__table-heading">
						<p class="rentals__customer-box__heading">Date</p>
					</th>
				</tr>

				@foreach ($activeRentals->sortBy('startDate') as $rental)

					<?php

						$customerStartDate = $rental->startDate;
						$newCustomerStartDate = date("m-d-Y", strtotime($customerStartDate));
						$newStartArr = explode('-', $newCustomerStartDate);

						$customerEndDate = $rental->endDate;
						$newCustomerEndDate = date("m-d-Y", strtotime($customerEndDate));
						$newEndArr = explode('-', $newCustomerEndDate);

					?>

					<tr class="rentals__customer-box__data">
						<td class="rentals__customer-box__table-data">
							<a class="rentals__customer-box__link" href="/rentals/{{ $rental->id }}">
								<p class="rentals__customer-box__name">{{ $rental->customer }}</p>
							</a>
						</td>

						<td class="rentals__customer-box__table-data">
							<a class="rentals__customer-box__link" href="/rentals/{{ $rental->id }}">
								<p class="rentals__customer-box__date"><?php echo $newStartArr[0] . "/" . $newStartArr[1] . " - " . $newEndArr[0] . "/" . $newEndArr[1] ?></p>
							</a>
						</td>
					</tr>

				@endforeach

			</table>

		</div>

		<div class="rentals__container" id="rentals__container">
			<table class="rentals__table">

				<tr class="rentals__table__date-row">
					@foreach ($dates as $date)

						<?php
							$newDate = date("m-d-Y", strtotime($date));
							$dateArr = explode('-', $newDate);

							$unixTimestamp = strtotime($date);
							$dayOfWeek = date("l", $unixTimestamp);
						?>	

						<th class="rentals__table__date-heading <?php if ($date === date("Y-m-d")) echo "special-class" ?>">
							
							<a class="rentals__table__date-heading__text" href="/rentals-day?date=<?php echo $date ?>">
								<p class="rentals__table__date-heading__day">{{ $dayOfWeek }}<?php if($date === date("Y-m-d")) : ?><span class="special-class__today"> - Today</span><?php endif; ?></p>
								<p class="rentals__table__date-heading__date"><?php echo $dateArr[0] . "/" . $dateArr[1] ?></p>
							</a>
							
						</th>

					@endforeach
				</tr>
				
				<?php $pixelsToScrollFromTop = 45; ?>

				@foreach ($activeRentals->sortBy('startDate') as $rental)

					<?php
	
						// Get the reservation's start and end date
						$itemStartDate = $rental->startDate;
						$itemEndDate = $rental->endDate;
									
						//////////////// Create the status functionality for each reservation ////////////////////
									
						// Get how many pixels would need to be scrolled for this item's beginning on the calendar
						$flatOrderedRentalsStartDateStrToTime = strtotime($flattenedOrderedRentalsStartDate);
						$itemStartDateStrToTime = strtotime($itemStartDate);
						$startDateItemStartDateDiffTime = $itemStartDateStrToTime - $flatOrderedRentalsStartDateStrToTime;
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


					<tr class="rentals__table__rentals-row">
						@foreach ($dates as $date)
							<th class="rentals__table__rentals-box <?php if (date("Y-m-d") > $itemEndDate) echo "late"; ?>">
								
								
									<?php if($itemStartDate === $date && $itemEndDate === $date) : ?>
										<a href="/rentals/{{ $rental->id }}">
    										<div class="rentals__table__rentals-box__start-end"></div>
										</a>
									<?php elseif($itemStartDate === $date) : ?>
										<a href="/rentals/{{ $rental->id }}">
											<div class="rentals__table__rentals-box__start"></div>
										</a>
									<?php elseif($itemEndDate === $date) : ?>
										<a href="/rentals/{{ $rental->id }}">
											<div class="rentals__table__rentals-box__end"></div>
										</a>
									<?php elseif($date > $itemStartDate && $date < $itemEndDate) : ?>
										<a href="/rentals/{{ $rental->id }}">
											<div class="rentals__table__rentals-box__middle"></div>
										</a>
									<?php endif; ?>
								
							</th>
						@endforeach
						
						<a href="/rentals/{{ $rental->id }}" class="rentals__table__rentals-row__status" style="position: absolute; top: <?php echo $thisItemsPixelsToScrollFromTop; ?>px; left: <?php echo $amountOfPixelsToScrollForThisItemsBeginning; ?>px; width: <?php echo $itemWidthInPixels ?>px;">{{ $rental->itemsStatus }}</a>
						
					</tr>

				@endforeach

			</table>
		</div>
		
		<?php
		
		$dateToday = date("Y-m-d");

		$date1 = date_create($dateToday);
		$date2 = date_create($flattenedOrderedRentalsStartDate);
		$date3 = date_create($flattenedOrderedRentalsEndDate);

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
			var elmnt = document.getElementById("rentals__container");
			elmnt.scrollLeft = "<?php echo $amountPixelsToScroll; ?>";
		</script>

	</div>


	<?php endif; ?>



	<?php if ($areThereActiveRentals == false) : ?>
		<div class="rentals__no-active">
			<h1 class="rentals__no-active__heading">There are no currently active rentals.</h1>
			<h6 class="rentals__no-active__sub-heading">Click on "New Rental" in the navigation to create a new rental.</h6>
		</div>
	<?php endif; ?>



@endsection

