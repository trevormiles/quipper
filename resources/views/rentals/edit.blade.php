@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

@section('title', 'Quipper | Edit Rental')



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


<?php 
	$todayDate = date("Y-m-d");
	$todayLink = "/rentals-day?date=" . $todayDate;
?>

@section('link-3-title', 'View Today')
@section('link-3-location', $todayLink)



@section('panel-title', 'Edit Rental')

@section('content')




	<?php 

		// Get the start and end dates and set it to a hidden input so the javascript can pick it up, also get the rental ID number
		$predeterminedStartDate = $rental->startDate;
		$predeterminedEndDate = $rental->endDate;
		$thisRentalID = $rental->id;




		///////////////// Getting the items availability information //////////////////////////////

		// Get the rental items for this reservation
		$thePredeterminedRentalItems = $rental->items;
		$thePredeterminedRentalItemsDecoded = json_decode($thePredeterminedRentalItems);

		// Create an empty array for now where all the information for each instance of each item will be stored
		$allMatchingInstancesOfItemsInDatabase = [];
		
		// Loop through each item and get all other instances in the database where that item has been used/reserved
		foreach ($thePredeterminedRentalItemsDecoded as $predeterminedRentalItem) {
			
			// First, get the name
			$predeterminedRentalItemName = $predeterminedRentalItem[0];
			
			// Also how many of that item have been reserved
			$predeterminedRentalItemQuantity = $predeterminedRentalItem[1];
			
			// And query the database to see how many of that item are in the inventory
			$resultedItemFoundInInventory = DB::table('rental_items')->where('title', '=', $predeterminedRentalItemName)->get();
			$resultedItemFoundInInventoryDecoded = json_decode(json_encode($resultedItemFoundInInventory), true);
			$amountOfItemInInventory = $resultedItemFoundInInventoryDecoded[0]["quantity"];
			
			// Make an array for this item that we'll add the instances of this item to later on
			$instancesOfThisItem = [$predeterminedRentalItemName . "!" . $predeterminedRentalItemQuantity . "!" . $amountOfItemInInventory];
			
			// Use the name to search through the database
			$rentalsWithSameItem = DB::table('rentals')->where('items', 'LIKE', '%'.$predeterminedRentalItemName.'%')
														->where('id', '!=', $rental->id)
														->where('status', '=', "active")
														->get();
			
			//var_dump($rentalsWithSameItem);
			
			// Convert that last JSON array into a php array
			$rentalsWithSameItemArray = json_decode(json_encode($rentalsWithSameItem), true);
			
			// Loop through array and only get items that match the item name, since there are usually multiple items in every reservation
			foreach ($rentalsWithSameItemArray as $rentalWithSameItem) {
				
				// Pick out only the items in this array, we don't need to know the start date and end date etc. of each reservation 
				$rentalWithSameItemOnlyTheItems = $rentalWithSameItem["items"];
				
				
				// Convert the last json array into a php array
				$rentalWithSameItemOnlyTheItemsArray = json_decode($rentalWithSameItemOnlyTheItems);
				
				
				// Loop through that last array and if it's title matches the item's title, we'll add it to the instancesOfThisItem array
				
				foreach ($rentalWithSameItemOnlyTheItemsArray as $rentalWithSameItemOnlyTheItem) {
					
					$theItemsName = $rentalWithSameItemOnlyTheItem[0];
					$theItemsStatus = $rentalWithSameItemOnlyTheItem[6];
					
					if ($theItemsName == $predeterminedRentalItemName && $theItemsStatus !== "Checked In") {
						
						$theItemsQuantity = $rentalWithSameItemOnlyTheItem[1];
						$theItemsStartDate = $rentalWithSameItem["startDate"];
						$theItemsEndDate = $rentalWithSameItem["endDate"];
						
						$theItemsInformation = $theItemsQuantity . "@" . $theItemsStartDate . "@" . $theItemsEndDate;
						array_push($instancesOfThisItem, $theItemsInformation);

					}
				}
			}
			
			$instancesOfThisItemImploded = implode(":",$instancesOfThisItem);
			array_push($allMatchingInstancesOfItemsInDatabase, $instancesOfThisItemImploded);
		}
		
		$allMatchingInstancesOfItemsInDatabaseImploded = implode("?",$allMatchingInstancesOfItemsInDatabase);

	?>

	<input type="hidden" id="getPredeterminedStartDate" value="<?php echo $predeterminedStartDate; ?>">
	<input type="hidden" id="getPredeterminedEndDate" value="<?php echo $predeterminedEndDate; ?>">
	<input type="hidden" id="getThisRentalID" value="<?php echo $thisRentalID; ?>">
	<input type="hidden" id="itemsAvailabilityList" value="<?php echo $allMatchingInstancesOfItemsInDatabaseImploded; ?>">

	

	<form method="POST" action="/new-customer-from-edit-rentals" id="newCustomerRentals">
		
	{{ csrf_field() }}

	<div class="action-panel__content-container">

		<!-- Customer Input -->
		
		<input type="hidden" id="thisRentalID" value="<?php echo $thisRentalID; ?>" name="thisRentalID">
		
		<h2 class="edit-rental__step-title">Select a customer</h2>

		<div class="action-panel__gray-container edit-rental__top-container">
			
			<div class="edit-rental__customer-input-container">
			
				<div class="edit-rental__existing-customer">

					<h5 class="edit-rental__title">Search for an existing customer:</h5>

					<input class="edit-rental__existing-customer__field form-control" value="<?php echo $rental->customer; ?>" id="customer-input" type="text" placeholder="Type to begin searching..." onkeyup="searchingCustomerNames()">
					
					<?php 
						$activeCustomers = App\Customer::where('status', '=', 'active')->get();
					?>
					
					<ul id="customer-options-list" style="display: none">
						@foreach ($activeCustomers as $customer)
							<li>{{ $customer->name }}</li>
						@endforeach
					</ul>
					
					<div class="edit-rental__existing-customer__no-matches" id="noMatchesCustomerNames">
						<h5 class="edit-rental__existing-customer__no-matches__text">No customers match your search</h5>
					</div>

				</div>


				<div class="edit-rental__or">

					<h5 class="edit-rental__title">Or</h5>
					<div class="edit-rental__or__line"></div>

				</div>


				<div class="edit-rental__new-customer">

					<h5 class="edit-rental__title">Create a new customer: <span class="edit-rental__new-customer__new-user-icon"><i class="fas fa-user-plus"></i></span></h5>

					<div class="edit-rental__new-customer__field-group">
						<label class="edit-rental__new-customer__label">Name:</label>
						<input class="edit-rental__new-customer__field form-control" type="text" name="name" id="newCustomerName">
					</div>
					
					<div class="edit-rental__new-customer__field-group__same-line">
						<div class="edit-rental__new-customer__field-group edit-rental__new-customer__field-group__first">
							<label class="edit-rental__new-customer__label">Email:</label>
							<input class="edit-rental__new-customer__field form-control" type="text" name="email" id="email">
						</div>

						<div class="edit-rental__new-customer__field-group edit-rental__new-customer__field-group__second">
							<label class="edit-rental__new-customer__label">Phone:</label>
							<input class="edit-rental__new-customer__field form-control" type="text" name="phoneNumber" id="phoneNumber">
						</div>
					</div>

				</div>
				
			</div>

		</div>
		
		
		
		
		
		<h2 class="edit-rental__step-title">Select the dates of the rental</h2>
		
		<div class="edit-rental__bottom-container">
		
			<div class="action-panel__gray-container edit-rental__bottom-container__dates">

				<div class="edit-rental__dates">



					<div class="edit-rental__dates__start">

						<h5 class="edit-rental__dates__date-title">Start Date:</h5>

						<div class="edit-rental__dates__block__start edit-rental__dates__block">

							<div class="edit-rental__dates__block__content">

								<div class="edit-rental__dates__block__dates">

									<div class="edit-rental__dates__block__dates__startDatePickerDay edit-rental__dates__block__dates__day-written"></div>

									<div class="edit-rental__dates__block__dates__date">

										<input class="edit-rental__dates__block__dates__startDatePicker edit-rental__dates__block__dates__date-input" id="startDatePicker" name="startDate"></input>

										<div class="edit-rental__dates__block__dates__fullStartDateDisplayed edit-rental__dates__block__dates__full-date-displayed"></div>

									</div>

								</div>

								<div class="edit-rental__dates__block__content__trigger">
									<i class="edit-rental__dates__block__content__trigger__startDateTrigger fas fa-edit"></i>
								</div>

							</div>

						</div>

					</div>



					<div class="edit-rental__dates__end">

						<h5 class="edit-rental__dates__date-title">End Date:</h5>

						<div class="edit-rental__dates__block__end edit-rental__dates__block">

							<div class="edit-rental__dates__triangle"></div>

							<div class="edit-rental__dates__block__content">

								<div class="edit-rental__dates__block__dates">

									<div class="edit-rental__dates__block__dates__endDatePickerDay edit-rental__dates__block__dates__day-written"></div>

									<div class="edit-rental__dates__block__dates__date">

										<input class="edit-rental__dates__block__dates__endDatePicker edit-rental__dates__block__dates__date-input" id="endDatePicker" name="endDate"></input>

										<div class="edit-rental__dates__block__dates__fullEndDateDisplayed edit-rental__dates__block__dates__full-date-displayed"></div>

									</div>

								</div>

								<div class="edit-rental__dates__block__content__trigger">
									<i class="edit-rental__dates__block__content__trigger__endDateTrigger fas fa-edit"></i>
								</div>

							</div>

						</div>

					</div>



				</div>

			</div>
		
			<div class="edit-rental__next-button__container  edit-rental__bottom-container__submit">
				<a class="edit-rental__next-button" id="nextButton">Continue <i class="fas fa-arrow-right"></i></a>
			</div>
		
		</div>



		
		<div class="edit-rental__errors__container">

			<div class="edit-rental__errors alert alert-danger" id="no-customer-selected" role="alert">
				You must either select an existing customer or create a new customer.
			</div>

			<div class="edit-rental__errors alert alert-danger" id="customer-not-exist" role="alert">
				That customer doesn't exist. Please select an existing customer or create a new customer.
			</div>
			
			<div class="edit-rental__errors alert alert-danger" id="both-customer-fields-have-inputs" role="alert">
				You must either select an existing customer or create a new customer. You cannot have inputed text for both options.
			</div>
			
			<div class="edit-rental__errors alert alert-danger" id="missing-fields-new-customer" role="alert">
				The new customer name, new customer email, and new customer phone number are all mandatory fields.
			</div>
			
			<div class="edit-rental__errors alert alert-danger" id="new-customer-name-already-exists" role="alert">
				That customer name already exists.
			</div>
			
			<div class="edit-rental__errors alert alert-danger" id="start-date-too-large" role="alert">
				The end date is before the start date.
			</div>
			
			<div class="edit-rental__errors alert alert-danger" id="new-dates-dont-work" role="alert">
				There are not enough items available to switch to the new selected dates.
			</div>
			
			<div class="edit-rental__errors alert alert-danger" id="there-are-forbidden-characters" role="alert">
				You are not allowed to use the characters "@", ":", "/", "-" or "?" in the name.
			</div>
			
			<div class="edit-rental__errors alert alert-danger" id="customer-name-no-space" role="alert">
				The customer name must include a first and last name
			</div>
			
			<div class="edit-rental__errors alert alert-danger" id="customer-name-length" role="alert">
				The customer name must be longer than 4 characters
			</div>
			
			<div class="edit-rental__errors alert alert-danger" id="non-valid-email" role="alert">
				The email address is non valid. An email address must contain an @ symbol.
			</div>
			
			<div class="edit-rental__errors alert alert-danger" id="phone-not-long-enough" role="alert">
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
		<script type="text/javascript" src="/js/edit-rental.js"></script>
	@endsection


@endsection
