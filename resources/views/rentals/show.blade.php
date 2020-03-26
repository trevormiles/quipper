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

@section('panel-title', 'View Rental')

@section('content')

	<?php
		
		// Get the customer
		$selectedCustomer = $rental->customer;
		$customer = DB::table('customers')->where('name', $selectedCustomer)->first();
		$customerEmail = $customer->email;
		$customerPhone = $customer->phonenumber;

		
		// Get the start and end date
		$startDate = $rental->startDate;
		$endDate = $rental->endDate;


		// Break up the start date
		$startDateArray = explode('-', $startDate);
		$startYear = $startDateArray[0];
		$startYearFormatted = substr($startYear,2);
		$startMonth = $startDateArray[1];
		$startDay = $startDateArray[2];
		$formattedStartDate = $startMonth . "/" . $startDay . "/" . $startYearFormatted;

		// Break up the end date
		$endDateArray = explode('-', $endDate);
		$endYear = $endDateArray[0];
		$endYearFormatted = substr($endYear,2);
		$endMonth = $endDateArray[1];
		$endDay = $endDateArray[2];
		$formattedEndDate = $endMonth . "/" . $endDay . "/" . $endYearFormatted;


		// Get day names of the week
		$startDayOfWeek = date("l", strtotime($startDate));
		$endDayOfWeek = date("l", strtotime($endDate));

		// Calculate the number of the days of the rental period
		$calculatedStartDate = strtotime("$startDate");
		$calculatedEndDate = strtotime("$endDate");
		$datediff = $calculatedEndDate - $calculatedStartDate;
		$roundedDateDiff = round($datediff / (60 * 60 * 24));
		
		// Get the items and convert it from json to an array
		$rentalItems =  $rental->items;
		$rentalItemsArray = json_decode($rentalItems, true);

		// Get the items sum
		$itemsSum = $rental->itemsSum;


		// Figure out whether or not to show the check out and check in buttons

		$reserved = [];
		$checkedOut = [];
		
		foreach ($rentalItemsArray as $rentalItem) {
			if ($rentalItem[6] === "Reserved") {
				array_push($reserved,"Reserved");
			} else {
				array_push($checkedOut,"Checked Out");
			}
		}

	?>

	<div class="action-panel__content-container">
		<div class="show-rental__container">
			
			<div class="show-rental__top-container">
				
				<div class="show-rental__customer">
					<h1 class="show-rental__customer__title">{{ $customer->name }}</h1>
					<div class="show-rental__customer__divider"></div>
					<div class="show-rental__customer__information__container">
						<h5 class="show-rental__customer__info"><span class="show-rental__customer__info__title">Email:</span> <?php if ($customerEmail) { echo $customerEmail; } else { echo 'N/A'; } ?></h5>
						<h5 class="show-rental__customer__info"><span class="show-rental__customer__info__title">Phone:</span> <?php if ($customerPhone) { echo $customerPhone; } else { echo 'N/A'; } ?></h5>
					</div>
				</div>
				
				<div class="show-rental__dates">
					
					<div class="show-rental__dates__commands">
						
						<a class="show-rental__dates__commands__delete" data-toggle="modal" data-target="#deleteRental">Delete</a>
						
						<?php if ( $reserved !== [] ) : ?>
							<a class="show-rental__dates__commands__command" data-toggle="modal" data-target="#checkOutModal">Check Out</a>
						<?php endif; ?>
						
						<?php if ( $checkedOut !== [] ) : ?>
							<a class="show-rental__dates__commands__command" data-toggle="modal" data-target="#checkInModal">Check In</a>
						<?php endif; ?>
						
					</div>
					
					<div class="show-rental__dates-data__block">			
						<div class="show-rental__dates-data__block__start">
							<div class="show-rental__dates-data__block__content">
								<div class="show-rental__dates-data__block__content__text">
									<h4 class="show-rental__dates-data__block__day"><?php echo $startDayOfWeek; ?></h4>
									<h5 class="show-rental__dates-data__block__date"><?php echo $formattedStartDate; ?></h5>
								</div>
								<div class="show-rental__dates-data__block__content__edit-container">
									<a href="/rentals/{{ $rental->id }}/edit" class="show-rental__dates-data__block__content__edit"><i class="fas fa-edit"></i></a>
								</div>
							</div>
						</div>

						<div class="show-rental__dates-data__block__end">

							<div class="show-rental__dates-data__block__end__triangle"></div>

							<div class="show-rental__dates-data__block__content">
								<div class="show-rental__dates-data__block__content__text">
									<h4 class="show-rental__dates-data__block__day"><?php echo $endDayOfWeek; ?></h4>
									<h5 class="show-rental__dates-data__block__date"><?php echo $formattedEndDate; ?></h5>
								</div>
								<div class="show-rental__dates-data__block__content__edit-container">
									<a href="/rentals/{{ $rental->id }}/edit" class="show-rental__dates-data__block__content__edit"><i class="fas fa-edit"></i></a>
								</div>
							</div>

						</div>
					</div>
					
					<h6 class="show-rental__dates__duration"><?php if ($roundedDateDiff > 0) {echo $roundedDateDiff; } else { echo 'Same'; } ?> day rental duration</h6>
					
				</div>
				
			</div>
			
			
			
			<div class="show-rental__items__container">
				
				<div class="show-rental__items__edit-container">
					<a href="/rentals-edit2?data=<?php echo $rental->id . "-" . $formattedStartDate . "-" . $formattedEndDate . "-" . $selectedCustomer ?>" class="show-rental__items__edit"><i class="fas fa-edit"></i></a>
				</div>
				
				<div class="show-rental__items__header">
					<h5 class="show-rental__items__header__item show-rental__items__header__name">Item Name</h5>
					<h5 class="show-rental__items__header__item show-rental__items__header__status">Status</h5>
					<h5 class="show-rental__items__header__item show-rental__items__header__quantity">Quantity</h5>
					<h5 class="show-rental__items__header__item show-rental__items__header__rate">Rate</h5>
					<h5 class="show-rental__items__header__item show-rental__items__header__fee">Total Fee</h5>
				</div>
				
				<?php foreach($rentalItemsArray as $rentalItem): ?>
					<div class="show-rental__items__item-row">
						
						<h5 class="show-rental__items__item-row__item show-rental__items__item-row__name"><?php echo $rentalItem[0]; ?></h5>
						
						<h5 class="show-rental__items__item-row__item show-rental__items__item-row__status"><?php echo $rentalItem[6]; ?></h5>
						
						<h5 class="show-rental__items__item-row__item show-rental__items__item-row__quantity"><?php echo $rentalItem[1]; ?></h5>
						
						<h5 class="show-rental__items__item-row__item show-rental__items__item-row__rate"><?php echo "$" . $rentalItem[3] . "/" . $rentalItem[4]; ?></h5>
						
						<h5 class="show-rental__items__item-row__item show-rental__items__item-row__fee"><?php echo "$" . number_format($rentalItem[5], 2); ?></h5>
						
					</div>	
				<?php endforeach; ?>
				
				<div class="show-rental__items__total">
					<h5 class="show-rental__items__total__text"><span class="show-rental__items__total__total">Total:</span> $<?php echo $itemsSum; ?></h5>
				</div>
				
			</div>
			
			
			
		</div>
	</div>












	<!-- Delete Modal -->
	<div class="modal fade" id="deleteRental" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				
				<div class="modal-header">
					<h3 class="modal-title" id="checkOutModalTitle">Delete Rental</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					
					<h2 class="show-rental__modal__delete-title">Are you sure you want to delete this rental?</h2>
					<p class="show-rental__modal__delete-sub-title">Deleting this rental will also delete it from Carts if payment has not been collected yet.</p>
					
					<form method="POST" action="/{{ $rental->id }}/rental-delete" id="submitDeleteRental">
						
						{{ method_field('PATCH') }}
						{{ csrf_field() }}

						<a id="submit-delete-rental" class="show-rental__modal__submit">Yes, Delete</a>
						<a class="show-rental__modal__cancel" data-dismiss="modal" aria-label="Close">No, Cancel</a>

					</form>
				</div>
				
			</div>
		</div>
	</div>





	



	<!-- Check Out Modal -->
	<div class="modal fade" id="checkOutModal" tabindex="-1" role="dialog" aria-labelledby="CheckOutModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				
				<div class="modal-header">
					<h3 class="modal-title" id="checkOutModalTitle">Check Out Items</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					
					<form method="POST" action="/rentals/{{ $rental->id }}" id="submitCheckOut">
						
						{{ method_field('PATCH') }}
						{{ csrf_field() }}
						
						<input type="hidden" name="customer" value="<?php echo $selectedCustomer; ?>">
						<input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
						<input type="hidden" name="endDate" value="<?php echo $endDate; ?>">
						<input type="hidden" name="items" class="show-rental__items-check-out">
						<input type="hidden" name="itemsSum" value="<?php echo $itemsSum; ?>">
						<input type="hidden" name="itemsStatus" id="checked-out-items-status">
						<input type="hidden" name="status" value="<?php echo "active"; ?>">
						
						<div class="show-rental__modal__header">
							<h6 class="show-rental__modal__header__item show-rental__modal__header__item__item-name">Item</h6>
							<h6 class="show-rental__modal__header__item show-rental__modal__header__item__quantity">QTY</h6>
							<h6 class="show-rental__modal__header__item show-rental__modal__header__item__status">Check Out</h6>
						</div>
						
						<div class="show-rental__modal__body">
							<?php foreach($rentalItemsArray as $rentalItem): ?>
							
								<div class="show-rental__modal__item-container show-rental__modal__item-container-check-out <?php 
											if ($rentalItem[6] === "Checked Out") { 
												echo "show-rental__modal__item-container-check-out__already-checked-out"; 
											} elseif ($rentalItem[6] === "Checked In") {
												echo "show-rental__modal__item-container-check-out__item-is-checked-in";
											}
											?>">
									
									<h5 class="show-rental__modal__item show-rental__modal__item__name"><?php echo $rentalItem[0]; ?></h5>
									
									<h5 class="show-rental__modal__item show-rental__modal__item__quantity"><?php echo $rentalItem[1]; ?></h5>
									
									<h5 class="show-rental__modal__item show-rental__modal__item__amount-of-days"><?php echo $rentalItem[2]; ?></h5>
									
									<h5 class="show-rental__modal__item show-rental__modal__item__first-day-rate"><?php echo $rentalItem[3]; ?></h5>
									
									<h5 class="show-rental__modal__item show-rental__modal__item__second-day-rate"><?php echo $rentalItem[4]; ?></h5>
									
									<h5 class="show-rental__modal__item show-rental__modal__item__total"><?php echo $rentalItem[5]; ?></h5>
									
									<div class="show-rental__modal__item show-rental__modal__item__status">
										<label class="switch">
										  <input class="checkbox-check-out" type="checkbox">
										  <span class="slider round"></span>
										</label>
									</div>
									
								</div>
							
							<?php endforeach; ?>
							
							<div class="show-rental__modal__all-items">
								
								<h5 class="show-rental__modal__item show-rental__modal__item__all">Check Out All Items</h5>
								
								<label class="switch">
									  <input type="checkbox" id="check-all-check-out-box">
									  <span class="slider round"></span>
								</label>
								
							</div>
							
						</div>
						

						<a id="submit-check-out" class="show-rental__modal__submit">Submit</a>

					</form>
				</div>
				
			</div>
		</div>
	</div>







	<!-- Check In Modal -->
	<div class="modal fade" id="checkInModal" tabindex="-1" role="dialog" aria-labelledby="checkInModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				
				<div class="modal-header">
					<h3 class="modal-title" id="checkInModalTitle">Check In Items</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					
					<form method="POST" action="/rentals/{{ $rental->id }}" id="submitCheckIn">
						
						{{ method_field('PATCH') }}
						{{ csrf_field() }}
						
						<input type="hidden" name="customer" value="<?php echo $selectedCustomer; ?>">
						<input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
						<input type="hidden" name="endDate" value="<?php echo $endDate; ?>">
						<input type="hidden" name="items" class="show-rental__items-check-in">
						<input type="hidden" name="itemsStatus" id="checked-in-items-status">
						<input type="hidden" name="itemsSum" value="<?php echo $itemsSum; ?>">
						<input type="hidden" name="status" id="check-in-status">
						
						<div class="show-rental__modal__header">
							<h6 class="show-rental__modal__header__item show-rental__modal__header__item__item-name">Item</h6>
							<h6 class="show-rental__modal__header__item show-rental__modal__header__item__quantity">QTY</h6>
							<h6 class="show-rental__modal__header__item show-rental__modal__header__item__status">Check In</h6>
						</div>
						
						<div class="show-rental__modal__body">
							<?php foreach($rentalItemsArray as $rentalItem): ?>
							
								<div class="show-rental__modal__item-container show-rental__modal__item-container-check-in <?php
											if ($rentalItem[6] === "Checked In") { 
												echo "show-rental__modal__item-container-check-in__already-checked-in"; 
											} elseif ($rentalItem[6] === "Reserved") {
												echo "show-rental__modal__item-container-check-in__not-yet-checked-out"; 
											}
											?>">
									
									<h5 class="show-rental__modal__item show-rental__modal__item__name"><?php echo $rentalItem[0]; ?></h5>
									
									<h5 class="show-rental__modal__item show-rental__modal__item__quantity"><?php echo $rentalItem[1]; ?></h5>
									
									<h5 class="show-rental__modal__item show-rental__modal__item__amount-of-days"><?php echo $rentalItem[2]; ?></h5>
									
									<h5 class="show-rental__modal__item show-rental__modal__item__first-day-rate"><?php echo $rentalItem[3]; ?></h5>
									
									<h5 class="show-rental__modal__item show-rental__modal__item__second-day-rate"><?php echo $rentalItem[4]; ?></h5>
									
									<h5 class="show-rental__modal__item show-rental__modal__item__total"><?php echo $rentalItem[5]; ?></h5>
									
									<div class="show-rental__modal__item show-rental__modal__item__status">
										<label class="switch">
										  <input class="checkbox-check-in" type="checkbox">
										  <span class="slider round"></span>
										</label>
									</div>
									
								</div>
							
							<?php endforeach; ?>
							
							<div class="show-rental__modal__all-items">
								
								<h5 class="show-rental__modal__item show-rental__modal__item__all">Check In All Items</h5>
								
								<label class="switch">
									  <input type="checkbox" id="check-all-check-in-box">
									  <span class="slider round"></span>
								</label>
								
							</div>
							
						</div>
						

						<a id="submit-check-in" class="show-rental__modal__submit">Submit</a>

					</form>
				</div>
				
			</div>
		</div>
	</div>

	


@endsection

@section('script')
	<script type="text/javascript" src="/js/show-rental.js"></script>
@endsection
