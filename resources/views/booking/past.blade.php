@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

@section('title', 'Quipper | Past Bookings')


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
@section('link-4-active-class', 'sub-nav-active')



@section('panel-title', 'All Past Bookings')

@section('content')

	<?php

		// Get all past bookings. If there are no past bookings, turn that variable to false

		$bookings = DB::table('bookings')->where('bookingDate', '<', date('Y-m-d'))->where('status', '=', 'active')->get();
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
			
			$startDates = array_unique($startDates);

			//var_dump($startDates);







			////// Organize the start dates according to their date ////////

			function date_sort($a, $b) {
				return strtotime($b) - strtotime($a);
			}

			usort($startDates, "date_sort");

			//print_r($startDates);

			
		}
		
	
	?>


	<?php if ($areThereBookings == true) : ?>

	
		<div class="past-bookings">			
			
			<?php foreach ($startDates as $startDate) : ?>
				
				<div class="past-bookings__group">
					
					<?php
						$dayofweek = date('l', strtotime($startDate));
						$month = date('F', strtotime($startDate));
						$day = date('j', strtotime($startDate));
						$suffix = date('S', strtotime($startDate));
						$year = date('Y', strtotime($startDate));
					?>
					
					<div class="past-bookings__date">
						<h4 class="past-bookings__date__title"><?php echo $dayofweek . " - "; ?><span class="past-bookings__date__title__date"><?php echo $month . " " . $day . $suffix . ", " . $year ?></span></h4>
					</div>

					<div class="past-bookings__container">

						<div class="past-bookings__header">
							<h5 class="past-bookings__header__item past-bookings__header__name">Name:</h5>
							<div class="past-bookings__header__type-amount-container">
								<div class="past-bookings__header__type-amount-row">
									<h5 class="past-bookings__header__item past-bookings__header__type">Type:</h5>
									<h5 class="past-bookings__header__item past-bookings__header__amount"># of participants:</h5>
								</div>
							</div>
							<h5 class="past-bookings__header__item past-bookings__header__start-time">Start Time:</h5>
							<h5 class="past-bookings__header__item past-bookings__header__end-time">End Time:</h5>
							<h5 class="past-bookings__header__item past-bookings__header__edit">Edit:</h5>
							<h5 class="past-bookings__header__item past-bookings__header__cancel">Delete:</h5>
						</div>

						<?php 
							$resultedBookings = DB::table('bookings')->where('bookingDate', $startDate)->where('status', '=', 'active')->get();
							$decodedResultedBookings = json_decode(json_encode($resultedBookings));
						?>

						<?php foreach ($decodedResultedBookings as $pastBooking) : ?>
						
							<?php
								$bookingItems = $pastBooking->items;
								$bookingItemsArray = json_decode($bookingItems);
								
								$bookingStartTime = date('g:i a', strtotime($pastBooking->startTime));
								$bookingEndTime = date('g:i a', strtotime($pastBooking->endTime));
							?>
							
							<div class="past-bookings__booking">
								<input type="hidden" class="bookingID" value="<?php echo $pastBooking->id; ?>">
								<h5 class="past-bookings__booking__item past-bookings__booking__name"><?php echo $pastBooking->customer; ?></h5>
								
								<div class="past-bookings__booking__type-amount-container">
									<?php foreach ($bookingItemsArray as $bookingItem) : ?>
										<div class="past-bookings__booking__type-amount-row">
											<h5 class="past-bookings__booking__item past-bookings__booking__type"><?php echo $bookingItem[0]; ?></h5>
											<h5 class="past-bookings__booking__item past-bookings__booking__amount"><?php echo $bookingItem[1]; ?></h5>
										</div>
									<?php endforeach; ?>
								</div>
								
								<h5 class="past-bookings__booking__item past-bookings__booking__start-time"><?php echo $bookingStartTime; ?></h5>
								<h5 class="past-bookings__booking__item past-bookings__booking__end-time"><?php echo $bookingEndTime; ?></h5>
								<a class="past-bookings__booking__item past-bookings__booking__edit" href="/booking/<?php echo $pastBooking->id ?>"><i class="fas fa-edit"></i></a>
								<a class="past-bookings__booking__item past-bookings__booking__cancel openModal" data-toggle="modal" data-target="#deleteBooking" href="#"><i class="fas fa-times"></i></a>
							</div>

						<?php endforeach; ?>
						
					</div>
					
				</div>
			
			<?php endforeach; ?>	

		</div>


	<?php endif; ?>






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
					
					<div class="past-bookings__modal__delete-container">
						<h2 class="past-bookings__modal__delete-title">Are you sure you want to delete this booking?</h2>
						<p class="past-bookings__modal__delete-sub-title">Deleting this booking will also delete it from Carts if payment has not been collected yet.</p>
					</div>
					
					<form method="POST" id="submitDeleteBooking">
						
						{{ method_field('PATCH') }}
						{{ csrf_field() }}

						<a id="submit-delete-booking" class="past-bookings__modal__submit">Yes, Delete</a>
						<a class="past-bookings__modal__cancel" data-dismiss="modal" aria-label="Close">No, Cancel</a>

					</form>
				</div>
				
			</div>
		</div>
	</div>






	<?php if ($areThereBookings == false) : ?>
		<div class="booking__no-active">
			<h1 class="booking__no-active__heading">There are no past bookings.</h1>
			<h6 class="booking__no-active__sub-heading">Click on "New Booking" in the navigation to create a new booking.</h6>
		</div>
	<?php endif; ?>



@endsection


@section('script')
	<script type="text/javascript" src="/js/past-bookings.js"></script>
@endsection

