@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

<?php
	if(isset($_GET['data'])) {
    	$retreivedData = $_GET['data'];
	}
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



@section('panel-title', 'New Rental')

@section('content')

	<?php if (isset($_GET['data'])) : ?>
		<input type="hidden" value="<?php echo $retreivedData; ?>" id="dataFromCreate2">
	<?php endif; ?>

	<form method="POST" action="/new-customer-from-rentals" id="newCustomerRentals">
		
	{{ csrf_field() }}

	<div class="action-panel__content-container">

		<!-- Customer Input -->
		
		<h2 class="create-rental__step-title">Select a customer</h2>

		<div class="action-panel__gray-container create-rental__top-container">
			
			<div class="create-rental__customer-input-container">
			
				<div class="create-rental__existing-customer">

					<h5 class="create-rental__title">Search for an existing customer:</h5>

					<input class="create-rental__existing-customer__field form-control" id="customer-input" type="text" placeholder="Type to begin searching..." onkeyup="searchingCustomerNames()">
					
					<?php 
						$activeCustomers = App\Customer::where('status', '=', 'active')->get();
					?>
					
					<ul id="customer-options-list" style="display: none">
						@foreach ($activeCustomers as $customer)
							<li>{{ $customer->name }}</li>
						@endforeach
					</ul>
					
					<div class="create-rental__existing-customer__no-matches" id="noMatchesCustomerNames">
						<h5 class="create-rental__existing-customer__no-matches__text">No customers match your search</h5>
					</div>

				</div>


				<div class="create-rental__or">

					<h5 class="create-rental__title">Or</h5>
					<div class="create-rental__or__line"></div>

				</div>


				<div class="create-rental__new-customer">

					<h5 class="create-rental__title">Create a new customer: <span class="create-rental__new-customer__new-user-icon"><i class="fas fa-user-plus"></i></span></h5>

					<div class="create-rental__new-customer__field-group">
						<label class="create-rental__new-customer__label">Name:</label>
						<input class="create-rental__new-customer__field form-control" type="text" name="name" id="newCustomerName">
					</div>
					
					<div class="create-rental__new-customer__field-group__same-line">
						<div class="create-rental__new-customer__field-group create-rental__new-customer__field-group__first">
							<label class="create-rental__new-customer__label">Email:</label>
							<input class="create-rental__new-customer__field form-control" type="text" name="email" id="email">
						</div>

						<div class="create-rental__new-customer__field-group create-rental__new-customer__field-group__second">
							<label class="create-rental__new-customer__label">Phone:</label>
							<input class="create-rental__new-customer__field form-control" type="text" name="phoneNumber" id="phoneNumber">
						</div>
					</div>

				</div>
				
			</div>

		</div>
		
		
		
		
		
		<h2 class="create-rental__step-title">Select the dates of the rental</h2>
		
		<div class="create-rental__bottom-container">
		
			<div class="action-panel__gray-container create-rental__bottom-container__dates">

				<div class="create-rental__dates">



					<div class="create-rental__dates__start">

						<h5 class="create-rental__dates__date-title">Start Date:</h5>

						<div class="create-rental__dates__block__start create-rental__dates__block">

							<div class="create-rental__dates__block__content">

								<div class="create-rental__dates__block__dates">

									<div class="create-rental__dates__block__dates__startDatePickerDay create-rental__dates__block__dates__day-written"></div>

									<div class="create-rental__dates__block__dates__date">

										<input class="create-rental__dates__block__dates__startDatePicker create-rental__dates__block__dates__date-input" id="startDatePicker" name="startDate"></input>

										<div class="create-rental__dates__block__dates__fullStartDateDisplayed create-rental__dates__block__dates__full-date-displayed"></div>

									</div>

								</div>

								<div class="create-rental__dates__block__content__trigger">
									<i class="create-rental__dates__block__content__trigger__startDateTrigger fas fa-edit"></i>
								</div>

							</div>

						</div>

					</div>



					<div class="create-rental__dates__end">

						<h5 class="create-rental__dates__date-title">End Date:</h5>

						<div class="create-rental__dates__block__end create-rental__dates__block">

							<div class="create-rental__dates__triangle"></div>

							<div class="create-rental__dates__block__content">

								<div class="create-rental__dates__block__dates">

									<div class="create-rental__dates__block__dates__endDatePickerDay create-rental__dates__block__dates__day-written"></div>

									<div class="create-rental__dates__block__dates__date">

										<input class="create-rental__dates__block__dates__endDatePicker create-rental__dates__block__dates__date-input" id="endDatePicker" name="endDate"></input>

										<div class="create-rental__dates__block__dates__fullEndDateDisplayed create-rental__dates__block__dates__full-date-displayed"></div>

									</div>

								</div>

								<div class="create-rental__dates__block__content__trigger">
									<i class="create-rental__dates__block__content__trigger__endDateTrigger fas fa-edit"></i>
								</div>

							</div>

						</div>

					</div>



				</div>

			</div>
		
			<div class="create-rental__next-button__container  create-rental__bottom-container__submit">
				<a class="create-rental__next-button" id="nextButton">Continue <i class="fas fa-arrow-right"></i></a>
			</div>
		
		</div>



		
		<div class="create-rental__errors__container">

			<div class="create-rental__errors alert alert-danger" id="no-customer-selected" role="alert">
				You must either select an existing customer or create a new customer.
			</div>

			<div class="create-rental__errors alert alert-danger" id="customer-not-exist" role="alert">
				That customer doesn't exist. Please select an existing customer or create a new customer.
			</div>
			
			<div class="create-rental__errors alert alert-danger" id="there-are-forbidden-characters" role="alert">
				You are not allowed to use the characters "@", ":", "/", "-" or "?" in the name.
			</div>
			
			<div class="create-rental__errors alert alert-danger" id="both-customer-fields-have-inputs" role="alert">
				You must either select an existing customer or create a new customer. You cannot have inputed text for both options.
			</div>
			
			<div class="create-rental__errors alert alert-danger" id="missing-fields-new-customer" role="alert">
				The new customer name, new customer email, and new customer phone number are all mandatory fields.
			</div>
			
			<div class="create-rental__errors alert alert-danger" id="new-customer-name-already-exists" role="alert">
				That customer name already exists.
			</div>
			
			<div class="create-rental__errors alert alert-danger" id="start-date-too-large" role="alert">
				The end date is before the start date.
			</div>
			
			<div class="create-rental__errors alert alert-danger" id="non-valid-email" role="alert">
				The email address is non valid. An email address must contain an @ symbol.
			</div>
			
			<div class="create-rental__errors alert alert-danger" id="customer-name-no-space" role="alert">
				The customer name must include a first and last name
			</div>
			
			<div class="create-rental__errors alert alert-danger" id="customer-name-length" role="alert">
				The customer name must be longer than 4 characters
			</div>
			
			<div class="create-rental__errors alert alert-danger" id="phone-not-long-enough" role="alert">
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
		<script type="text/javascript" src="/js/create-rental.js"></script>
	@endsection


@endsection


