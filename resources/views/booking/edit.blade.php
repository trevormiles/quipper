@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

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



@section('panel-title', 'New Booking')

@section('content')


	<form method="POST" action="/new-customer-from-edit-booking" id="newCustomerBooking">
		
	{{ csrf_field() }}
		
	<input type="hidden" id="predeterminedStartTime" value="{{ $booking->startTime }}">
	<input type="hidden" id="predeterminedEndTime" value="{{ $booking->endTime }}">
	<input type="hidden" id="predeterminedDate" value="{{ $booking->bookingDate }}">
	<input type="hidden" id="getThisRentalID" value="{{ $booking->id }}" name="thisBookingID">

	<div class="action-panel__content-container">

		<!-- Customer Input -->
		
		<h2 class="edit-booking__step-title">Select a customer</h2>

		<div class="action-panel__gray-container edit-booking__top-container">
			
			<div class="edit-booking__customer-input-container">
			
				<div class="edit-booking__existing-customer">

					<h5 class="edit-booking__title">Search for an existing customer:</h5>

					<input class="edit-booking__existing-customer__field form-control" id="customer-input" type="text" placeholder="Type to begin searching..." onkeyup="searchingCustomerNames()" value="{{ $booking->customer }}">
					
					<?php 
						$activeCustomers = App\Customer::where('status', '=', 'active')->get();
					?>
					
					<ul id="customer-options-list" style="display: none">
						@foreach ($activeCustomers as $customer)
							<li>{{ $customer->name }}</li>
						@endforeach
					</ul>
					
					<div class="edit-booking__existing-customer__no-matches" id="noMatchesCustomerNames">
						<h5 class="edit-booking__existing-customer__no-matches__text">No customers match your search</h5>
					</div>

				</div>


				<div class="edit-booking__or">

					<h5 class="edit-booking__title">Or</h5>
					<div class="edit-booking__or__line"></div>

				</div>


				<div class="edit-booking__new-customer">

					<h5 class="edit-booking__title">Create a new customer: <span class="edit-booking__new-customer__new-user-icon"><i class="fas fa-user-plus"></i></span></h5>

					<div class="edit-booking__new-customer__field-group">
						<label class="edit-booking__new-customer__label">Name:</label>
						<input class="edit-booking__new-customer__field form-control" type="text" name="name" id="newCustomerName">
					</div>
					
					<div class="edit-booking__new-customer__field-group__same-line">
						<div class="edit-booking__new-customer__field-group edit-booking__new-customer__field-group__first">
							<label class="edit-booking__new-customer__label">Email:</label>
							<input class="edit-booking__new-customer__field form-control" type="text" name="email" id="email">
						</div>

						<div class="edit-booking__new-customer__field-group edit-booking__new-customer__field-group__second">
							<label class="edit-booking__new-customer__label">Phone:</label>
							<input class="edit-booking__new-customer__field form-control" type="text" name="phoneNumber" id="phoneNumber">
						</div>
					</div>

				</div>
				
			</div>

		</div>
		
		
		
		
		
		<h2 class="edit-booking__step-title">Select the dates and time of the booking</h2>
		
		<div class="edit-booking__bottom-container">
		
			<div class="action-panel__gray-container edit-booking__bottom-container__dates">
				
				
				<div class="edit-booking__dates__block__content__top">
					
					<h5 class="edit-booking__dates__date-title">Date:</h5>
					
					<div class="edit-booking__dates__block__content__top__container">

						<div class="edit-booking__dates__block__dates">

							<div class="edit-booking__dates__block__dates__datePickerDay edit-booking__dates__block__dates__day-written"></div>

							<div class="edit-booking__dates__block__dates__date">

								<input class="edit-booking__dates__block__dates__datePicker edit-booking__dates__block__dates__date-input" id="datePicker" name="date"></input>

								<div class="edit-booking__dates__block__dates__fullDateDisplayed edit-booking__dates__block__dates__full-date-displayed"></div>

							</div>

						</div>

						<div class="edit-booking__dates__block__content__trigger">
							<i class="edit-booking__dates__block__content__trigger__dateTrigger fas fa-edit"></i>
						</div>
					
					</div>

				</div>
			
			

				<div class="edit-booking__dates">

					<div class="edit-booking__dates__start">

						<h5 class="edit-booking__dates__date-title">Start Time:</h5>

						<div class="edit-booking__dates__block__start edit-booking__dates__block">

							<div class="edit-booking__dates__block__content">
							
								<div class="edit-booking__dates__block__content__bottom">
									<input class="edit-booking__dates__block__content__time-picker" id="timepicker-start" name="startTime"></input>
								</div>

							</div>

						</div>

					</div>



					<div class="edit-booking__dates__end">

						<h5 class="edit-booking__dates__date-title">End Time:</h5>

						<div class="edit-booking__dates__block__end edit-booking__dates__block">

							<div class="edit-booking__dates__triangle"></div>

							<div class="edit-booking__dates__block__content">
							
								<div class="edit-booking__dates__block__content__bottom">
									<input class="edit-booking__dates__block__content__time-picker" id="timepicker-end" name="endTime"></input>
								</div>

							</div>

						</div>

					</div>



				</div>

			</div>
		
			<div class="edit-booking__next-button__container  edit-booking__bottom-container__submit">
				<a class="edit-booking__next-button" id="nextButton">Continue <i class="fas fa-arrow-right"></i></a>
			</div>
		
		</div>



		
		<div class="edit-booking__errors__container">

			<div class="edit-booking__errors alert alert-danger" id="no-customer-selected" role="alert">
				You must either select an existing customer or create a new customer.
			</div>

			<div class="edit-booking__errors alert alert-danger" id="customer-not-exist" role="alert">
				That customer doesn't exist. Please select an existing customer or create a new customer.
			</div>
			
			<div class="edit-booking__errors alert alert-danger" id="there-are-forbidden-characters" role="alert">
				You are not allowed to use the characters "@", ":", "/", "-" or "?" in the name.
			</div>
			
			<div class="edit-booking__errors alert alert-danger" id="both-customer-fields-have-inputs" role="alert">
				You must either select an existing customer or create a new customer. You cannot have inputed text for both options.
			</div>
			
			<div class="edit-booking__errors alert alert-danger" id="missing-fields-new-customer" role="alert">
				The new customer name, new customer email, and new customer phone number are all mandatory fields.
			</div>
			
			<div class="edit-booking__errors alert alert-danger" id="new-customer-name-already-exists" role="alert">
				That customer name already exists.
			</div>
			
			<div class="edit-booking__errors alert alert-danger" id="start-date-too-large" role="alert">
				The end date is before the start date.
			</div>
			
			<div class="edit-booking__errors alert alert-danger" id="customer-name-no-space" role="alert">
				The customer name must include a first and last name
			</div>
			
			<div class="edit-booking__errors alert alert-danger" id="customer-name-length" role="alert">
				The customer name must be longer than 4 characters
			</div>
			
			<div class="edit-booking__errors alert alert-danger" id="non-valid-email" role="alert">
				The email address is non valid. An email address must contain an @ symbol.
			</div>
			
			<div class="edit-booking__errors alert alert-danger" id="phone-not-long-enough" role="alert">
				The full phone number is required.
			</div>
			
		</div>


	</div>

	</form>



	<ul id="customerOptions" style="display: none;">
		
		@foreach ($customers as $customer)
			<li>{{ $customer->name }}</li>
		@endforeach
		
	</ul>


	@section('script')
		<script type="text/javascript" src="/js/edit-booking.js"></script>
	@endsection


@endsection


