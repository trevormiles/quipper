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



@section('panel-title', 'View Booking')

@section('content')

	<?php
		
		// Get the customer
		$selectedCustomer = $booking->customer;
		$customer = DB::table('customers')->where('name', $selectedCustomer)->first();
		$customerEmail = $customer->email;
		$customerPhone = $customer->phonenumber;

		
		// Get the date
		$date = $booking->bookingDate;


		// Get the start time and end time
		$startTime = $booking->startTime;
		$endTime = $booking->endTime;


		// Break up the date
		$dateArray = explode('-', $date);
		$year = $dateArray[0];
		$yearFormatted = substr($year,2);
		$month = $dateArray[1];
		$day = $dateArray[2];
		$formattedDate = $month . "/" . $day . "/" . $yearFormatted;
		$URLDate = $month . "/" . $day . "/" . $year;


		// Get day name of the week
		$dayOfWeek = date("l", strtotime($date));

		// Calculate the number of hour of the rental period
		$calculatedStartDate = strtotime("$date $startTime");
		$calculatedEndDate = strtotime("$date $endTime");
		$dateDiff = $calculatedEndDate - $calculatedStartDate;
		$roundedDateDiff = round($dateDiff / (60 * 60));
		
		// Get the items and convert it from json to an array
		$bookingItems =  $booking->items;
		$bookingItemsArray = json_decode($bookingItems, true);

		// Get the items sum
		$itemsSum = $booking->itemsSum;

		// Time
		$startTime = $booking->startTime;
		$endTime = $booking->endTime;
		$formattedStartTime = date('g:i A', strtotime($startTime));
		$formattedEndTime = date('g:i A', strtotime($endTime));

	?>

	<div class="action-panel__content-container">
		<div class="show-booking__container">
			
			<div class="show-booking__top-container">
				
				<div class="show-booking__customer">
					<h1 class="show-booking__customer__title">{{ $customer->name }}</h1>
					<div class="show-booking__customer__divider"></div>
					<div class="show-booking__customer__information__container">
						<h5 class="show-booking__customer__info"><span class="show-booking__customer__info__title">Email:</span> <?php if ($customerEmail) { echo $customerEmail; } else { echo 'N/A'; } ?></h5>
						<h5 class="show-booking__customer__info"><span class="show-booking__customer__info__title">Phone:</span> <?php if ($customerPhone) { echo $customerPhone; } else { echo 'N/A'; } ?></h5>
					</div>
				</div>
				
				<div class="show-booking__dates">
					
					<div class="show-booking__dates__date">
						<h4 class="show-booking__dates__date__day"><?php echo $dayOfWeek; ?></h4>
						<h4 class="show-booking__dates__date__divider">-</h4>
						<h4 class="show-booking__dates__date__full-date"><?php echo $formattedDate; ?></h4>
						
						<a class="show-booking__dates__delete" data-toggle="modal" data-target="#deleteBooking">Delete</a>
					</div>
					
					<div class="show-booking__dates-data__block">			
						<div class="show-booking__dates-data__block__start">
							<div class="show-booking__dates-data__block__content">
								
								<div class="show-booking__dates-data__block__content__text">
									<h5 class="show-booking__dates-data__block__time"><?php echo $formattedStartTime; ?></h5>
								</div>
								
								<div class="show-booking__dates-data__block__content__edit-container">
									<a href="/booking/{{ $booking->id }}/edit" class="show-booking__dates-data__block__content__edit"><i class="fas fa-edit"></i></a>
								</div>
								
							</div>
						</div>

						<div class="show-booking__dates-data__block__end">

							<div class="show-booking__dates-data__block__end__triangle"></div>

							<div class="show-booking__dates-data__block__content">
								
								<div class="show-booking__dates-data__block__content__text">
									<h5 class="show-booking__dates-data__block__time"><?php echo $formattedEndTime; ?></h5>
								</div>
								
								<div class="show-booking__dates-data__block__content__edit-container">
									<a href="/booking/{{ $booking->id }}/edit" class="show-booking__dates-data__block__content__edit"><i class="fas fa-edit"></i></a>
								</div>
								
							</div>

						</div>
					</div>
					
					<h6 class="show-booking__dates__duration"><?php echo $roundedDateDiff; ?> hour duration</h6>
					
				</div>
				
			</div>
			
			
			
			<div class="show-booking__items__container">
				
				<div class="show-booking__items__edit-container">
					<a href="/booking-edit2?data=<?php echo $booking->id . "-" . $URLDate . "-" . $selectedCustomer . "-" . $formattedStartTime . "-" . $formattedEndTime; ?>" class="show-booking__items__edit"><i class="fas fa-edit"></i></a>
				</div>
				
				<div class="show-booking__items__header">
					<h5 class="show-booking__items__header__item show-booking__items__header__name">Item Name</h5>
					<h5 class="show-booking__items__header__item show-booking__items__header__quantity"># of people</h5>
					<h5 class="show-booking__items__header__item show-booking__items__header__rate">Rate</h5>
					<h5 class="show-booking__items__header__item show-booking__items__header__fee">Total Fee</h5>
				</div>
				
				<?php foreach($bookingItemsArray as $bookingItem): ?>
					<div class="show-booking__items__item-row">
						
						<h5 class="show-booking__items__item-row__item show-booking__items__item-row__name"><?php echo $bookingItem[0]; ?></h5>
						
						<h5 class="show-booking__items__item-row__item show-booking__items__item-row__quantity"><?php echo $bookingItem[1]; ?></h5>
						
						<h5 class="show-booking__items__item-row__item show-booking__items__item-row__rate"><?php echo "$" . $bookingItem[3] . "/" . $bookingItem[4]; ?></h5>
						
						<h5 class="show-booking__items__item-row__item show-booking__items__item-row__fee"><?php echo "$" . number_format($bookingItem[5], 2); ?></h5>
						
					</div>	
				<?php endforeach; ?>
				
				<div class="show-booking__items__total">
					<h5 class="show-booking__items__total__text"><span class="show-booking__items__total__total">Total:</span> $<?php echo $itemsSum; ?></h5>
				</div>
				
			</div>
			
			
			
		</div>
	</div>



	<!-- Delete Modal -->
	<div class="modal fade" id="deleteBooking" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				
				<div class="modal-header">
					<h3 class="modal-title">Delete Booking</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					
					<h2 class="show-booking__modal__delete-title">Are you sure you want to delete this booking?</h2>
					<p class="show-booking__modal__delete-sub-title">Deleting this booking will also delete it from Carts if payment has not been collected yet.</p>
					
					<form method="POST" action="/{{ $booking->id }}/booking-delete" id="submitDeleteBooking">
						
						{{ method_field('PATCH') }}
						{{ csrf_field() }}

						<a id="submit-delete-booking" class="show-booking__modal__submit">Yes, Delete</a>
						<a class="show-booking__modal__cancel" data-dismiss="modal" aria-label="Close">No, Cancel</a>

					</form>
				</div>
				
			</div>
		</div>
	</div>


@endsection


@section('script')
	<script type="text/javascript" src="/js/show-booking.js"></script>
@endsection
