@extends('layout')


@section('title', 'Quipper | Carts')


@section('title', 'Quipper | Booking')


@section('main-nav-1-title', 'Rentals')
@section('main-nav-1-location', '/rentals')

@section('main-nav-2-title', 'Booking')
@section('main-nav-2-location', '/booking')

@section('main-nav-3-title', 'Sales')
@section('main-nav-3-location', '/sales/create')

@section('main-nav-4-title', 'Carts')
@section('main-nav-4-location', '/carts')
@section('main-nav-active-4', 'main-nav-active')

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
	<i class="fas fa-shopping-cart"></i>
@endsection
@section('link-1-title', 'All Carts')
@section('link-1-location', '/carts')
@section('link-1-active-class', 'sub-nav-active')


@section('link-2-icon')
	
@endsection
@section('link-2-title', 'Go to Accounting')
@section('link-2-location', '/accounting')


@section('link-3-title', '')
@section('link-3-location', '')



@section('panel-title', 'All Carts')

@section('content')

	<?php 
		$cartsGroupedByCustomer = $carts->where('status', '=', "active")->groupBy('customer');
		$cartsGroupedByCustomerArray = json_decode(json_encode($cartsGroupedByCustomer), true);
		$cartsGroupedByCustomerCounted = count($cartsGroupedByCustomerArray);
	?>

	<?php if ($cartsGroupedByCustomerCounted > 0) : ?>

		<div class="carts" id="carts">

			<?php foreach ($cartsGroupedByCustomerArray as $cartsGroupedByCustomerArray) : ?>

				<form class="cart-form" method="POST" action="/carts-update">
					{{ method_field('PATCH') }}
					{{ csrf_field() }}

					<input type="hidden" name="checkedItemsArray" class="checkedItemsArray">

					<div class="carts__cart">

						<div class="carts__cart__header">
							<h2 class="carts__cart__header__title"><?php echo $cartsGroupedByCustomerArray[0]["customer"]; ?></h2>
						</div>

						<div class="carts__cart__body">

							<?php 
								$rentalsArray = [];
								$bookingsArray = [];
								$salesArray = [];
							?>

							<?php foreach ($cartsGroupedByCustomerArray as $cartInstance) : ?>

								<?php if (!empty($cartInstance["rentalID"])) : ?>
									<?php
										$cartInstanceID = $cartInstance["id"];
										$rentalID = $cartInstance["rentalID"];
										$rentalIDsArray = [$cartInstanceID, $rentalID];
									?>
									<?php array_push($rentalsArray, $rentalIDsArray); ?>
								<?php endif; ?>

								<?php if (!empty($cartInstance["bookingID"])) : ?>	
									<?php
										$cartInstanceID = $cartInstance["id"];
										$bookingID = $cartInstance["bookingID"];
										$bookingIDsArray = [$cartInstanceID, $bookingID];
									?>
									<?php array_push($bookingsArray, $bookingIDsArray); ?>
								<?php endif; ?>

								<?php if (!empty($cartInstance["salesID"])) : ?>
									<?php
										$cartInstanceID = $cartInstance["id"];
										$salesID = $cartInstance["salesID"];
										$salesIDsArray = [$cartInstanceID, $salesID];
									?>
									<?php array_push($salesArray, $salesIDsArray); ?>
								<?php endif; ?>

							<?php endforeach; ?>






							<?php if (count($rentalsArray) > 0) : ?>
								<?php //var_dump($rentalsArray); ?>
								<div class="cart__container">
									<h4 class="carts__category__title">Rentals</h4>
									<div class="carts__rentals cart">

										<div class="carts__rentals__header">
											<h5 class="carts__rentals__header__item carts__rentals__header__start-date">Start Date:</h5>
											<h5 class="carts__rentals__header__item carts__rentals__header__end-date">End Date:</h5>
											<h5 class="carts__rentals__header__item carts__rentals__header__fee__mobile">Fee:</h5>
											<div class="carts__rentals__header__items-container">
												<h5 class="carts__rentals__header__item carts__rentals__header__items">Item:</h5>
												<h5 class="carts__rentals__header__item carts__rentals__header__quantity">Quantity:</h5>
												<h5 class="carts__rentals__header__item carts__rentals__header__fee__desktop">Fee:</h5>
											</div>
											<h5 class="carts__rentals__header__item carts__rentals__header__discount">Discount:</h5>
											<h5 class="carts__rentals__header__item carts__rentals__header__total-fee">Total Fee:</h5>
											<h5 class="carts__rentals__header__item carts__rentals__header__edit">Edit:</h5>
											<h5 class="carts__rentals__header__item carts__rentals__header__cancel">Delete:</h5>
											<h5 class="carts__rentals__header__item carts__rentals__header__collect">Collect Payment:</h5>
										</div>

										<?php foreach ($rentalsArray as $rentalArray) : ?>

											<?php
												$thisCartInstanceId = $rentalArray[0];
												$thisRentalId = $rentalArray[1];
												$rentalData = DB::table('rentals')->where('id', '=', $thisRentalId)->get();
												$rentalDataArray = json_decode(json_encode($rentalData), true);
												//var_dump($rentalDataArray);

												$startDate = $rentalDataArray[0]["startDate"];
												$startDateArray = explode('-', $startDate);
												$startYear = $startDateArray[0];
												$startYearFormatted = substr($startYear,2);
												$startMonth = $startDateArray[1];
												$startDay = $startDateArray[2];
												$formattedStartDate = $startMonth . "/" . $startDay . "/" . $startYearFormatted;

												$endDate = $rentalDataArray[0]["endDate"];
												$endDateArray = explode('-', $endDate);
												$endYear = $endDateArray[0];
												$endYearFormatted = substr($endYear,2);
												$endMonth = $endDateArray[1];
												$endDay = $endDateArray[2];
												$formattedEndDate = $endMonth . "/" . $endDay . "/" . $endYearFormatted;

												$items = $rentalDataArray[0]["items"];
												$itemsArray = json_decode($items);
												$totalFee = $rentalDataArray[0]["itemsSum"];
											?>

											<div class="carts__rentals__rental cart-item">
												<input type="hidden" class="cart-item-ids" value="<?php echo $thisCartInstanceId; ?>">
												<h5 class="carts__rentals__rental__item carts__rentals__rental__start-date"><?php echo $formattedStartDate; ?></h5>
												<h5 class="carts__rentals__rental__item carts__rentals__rental__end-date"><?php echo $formattedEndDate; ?></h5>
												<h5 class="carts__rentals__rental__item carts__rentals__rental__fee__mobile">$<?php echo $totalFee; ?></h5>
												<div class="carts__rentals__rental__items-container">
													<?php foreach ($itemsArray as $item) : ?>
														<div class="carts__rentals__rental__items-row">
															<h5 class="carts__rentals__rental__item carts__rentals__rental__items"><?php echo $item[0]; ?></h5>
															<h5 class="carts__rentals__rental__item carts__rentals__rental__quantity"><?php echo $item[1]; ?></h5>
															<h5 class="carts__rentals__rental__item carts__rentals__rental__fee__desktop">$<?php echo number_format($item[5], 2); ?></h5>
														</div>
													<?php endforeach; ?>
													<div class="carts__rentals__rental__items-total">
														<h5 class="carts__rentals__rental__item carts__rentals__rental__items-total__total">Total:</h5>
														<h5 class="carts__rentals__rental__item carts__rentals__rental__items-total__number">$<?php echo $totalFee; ?></h5>
													</div>
												</div>
												<div class="carts__rentals__rental__discount">
													<input class="carts__rentals__rental__discount__input discount__input form-control" type="number" min="0" max="100" placeholder="0">
													<h5 class="carts__rentals__rental__discount__percentage">%</h5>
												</div>
												<h5 class="carts__rentals__rental__item carts__rentals__rental__total-fee total-fee">$<?php echo $totalFee; ?></h5>
												<input class="carts__rentals__rental__total-fee__not-changing total-fee__not-changing" value="<?php echo $totalFee; ?>" style="display: none;">
												<a class="carts__rentals__rental__item carts__rentals__rental__edit" href="/rentals/<?php echo $thisRentalId; ?>"><i class="fas fa-edit"></i></a>
												<a class="carts__rentals__rental__item carts__rentals__rental__cancel openModal" data-toggle="modal" data-target="#deleteCart"><i class="fas fa-times"></i></a>
												<div class="carts__rentals__rental__collect collect-switch-container">
													<label class="switch">
													  <input class="checkbox-check-out" type="checkbox">
													  <span class="slider round"></span>
													</label>
												</div>
											</div>

										<?php endforeach; ?>

									</div>
								</div>
							<?php endif; ?>



							<?php if (count($bookingsArray) > 0) : ?>
								<?php //var_dump($bookingArray); ?>
								<div class="cart__container">
									<h4 class="carts__category__title">Booking</h4>
									<div class="carts__bookings cart">

										<div class="carts__bookings__header">
											<h5 class="carts__bookings__header__item carts__bookings__header__start-date">Start Date:</h5>
											<h5 class="carts__bookings__header__item carts__bookings__header__end-date"># of hours:</h5>
											<h5 class="carts__bookings__header__item carts__bookings__header__fee__mobile">Fee:</h5>
											<div class="carts__bookings__header__items-container">
												<h5 class="carts__bookings__header__item carts__bookings__header__items">Item:</h5>
												<h5 class="carts__bookings__header__item carts__bookings__header__quantity"># of PPL:</h5>
												<h5 class="carts__bookings__header__item carts__bookings__header__fee__desktop">Fee:</h5>
											</div>
											<h5 class="carts__bookings__header__item carts__bookings__header__discount">Discount:</h5>
											<h5 class="carts__bookings__header__item carts__bookings__header__total-fee">Total Fee:</h5>
											<h5 class="carts__bookings__header__item carts__bookings__header__edit">Edit:</h5>
											<h5 class="carts__bookings__header__item carts__bookings__header__cancel">Delete:</h5>
											<h5 class="carts__bookings__header__item carts__bookings__header__collect">Collect Payment:</h5>
										</div>

										<?php foreach ($bookingsArray as $bookingArray) : ?>

											<?php
												$thisCartInstanceId = $bookingArray[0];
												$thisBookingId = $bookingArray[1];
												$bookingData = DB::table('bookings')->where('id', '=', $thisBookingId)->get();
												$bookingDataArray = json_decode(json_encode($bookingData), true);
												//var_dump($bookingDataArray);

												$bookingDate = $bookingDataArray[0]["bookingDate"];
												$dateArray = explode('-', $bookingDate);
												$year = $dateArray[0];
												$yearFormatted = substr($year,2);
												$month = $dateArray[1];
												$day = $dateArray[2];
												$formattedDate = $month . "/" . $day . "/" . $yearFormatted;

												$items = $bookingDataArray[0]["items"];
												$itemsArray = json_decode($items);
												$totalFee = $bookingDataArray[0]["itemsSum"];
											?>

											<div class="carts__bookings__booking cart-item">
												<input type="hidden" class="cart-item-ids" value="<?php echo $thisCartInstanceId; ?>">
												<h5 class="carts__bookings__booking__item carts__bookings__booking__start-date"><?php echo $formattedDate; ?></h5>
												<h5 class="carts__bookings__booking__item carts__bookings__booking__end-date"><?php echo $itemsArray[0][2]; ?></h5>
												<h5 class="carts__bookings__booking__item carts__bookings__booking__fee__mobile">$<?php echo $totalFee; ?></h5>
												<div class="carts__bookings__booking__items-container">
													<?php foreach ($itemsArray as $item) : ?>
														<div class="carts__bookings__booking__items-row">
															<h5 class="carts__bookings__booking__item carts__bookings__booking__items"><?php echo $item[0]; ?></h5>
															<h5 class="carts__bookings__booking__item carts__bookings__booking__quantity"><?php echo $item[1]; ?></h5>
															<h5 class="carts__bookings__booking__item carts__bookings__booking__fee__desktop">$<?php echo number_format($item[5], 2); ?></h5>
														</div>
													<?php endforeach; ?>
													<div class="carts__bookings__booking__items-total">
														<h5 class="carts__bookings__booking__item carts__bookings__booking__items-total__total">Total:</h5>
														<h5 class="carts__bookings__booking__item carts__bookings__booking__items-total__number">$<?php echo $totalFee; ?></h5>
													</div>
												</div>
												<div class="carts__bookings__booking__discount">
													<input class="carts__bookings__booking__discount__input discount__input form-control" type="number" min="0" max="100" placeholder="0">
													<h5 class="carts__bookings__booking__discount__percentage">%</h5>
												</div>
												<h5 class="carts__bookings__booking__item carts__bookings__booking__total-fee total-fee">$<?php echo $totalFee; ?></h5>
												<input class="carts__bookings__booking__total-fee__not-changing total-fee__not-changing" value="<?php echo $totalFee; ?>" style="display: none;">
												<a class="carts__bookings__booking__item carts__bookings__booking__edit" href="/booking/<?php echo $thisBookingId; ?>"><i class="fas fa-edit"></i></a>
												<a class="carts__bookings__booking__item carts__bookings__booking__cancel openModal" data-toggle="modal" data-target="#deleteCart"><i class="fas fa-times"></i></a>
												<div class="carts__bookings__booking__collect collect-switch-container">
													<label class="switch">
													  <input class="checkbox-check-out" type="checkbox">
													  <span class="slider round"></span>
													</label>
												</div>
											</div>

										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>




							<?php if (count($salesArray) > 0) : ?>
								<?php //var_dump($salesArray); ?>
								<div class="cart__container">
									<h4 class="carts__category__title">Sales</h4>
									<div class="carts__sales cart">

										<div class="carts__sales__header">
											<h5 class="carts__sales__header__item carts__sales__header__start-date">Start Date:</h5>
											<h5 class="carts__sales__header__item carts__sales__header__end-date"></h5>
											<h5 class="carts__sales__header__item carts__sales__header__fee__mobile">Fee:</h5>
											<div class="carts__sales__header__items-container">
												<h5 class="carts__sales__header__item carts__sales__header__items">Item:</h5>
												<h5 class="carts__sales__header__item carts__sales__header__quantity">Quantity:</h5>
												<h5 class="carts__sales__header__item carts__sales__header__fee__desktop">Fee:</h5>
											</div>
											<h5 class="carts__sales__header__item carts__sales__header__discount">Discount:</h5>
											<h5 class="carts__sales__header__item carts__sales__header__total-fee">Total Fee:</h5>
											<h5 class="carts__sales__header__item carts__sales__header__edit"></h5>
											<h5 class="carts__sales__header__item carts__sales__header__cancel">Delete:</h5>
											<h5 class="carts__sales__header__item carts__sales__header__collect">Collect Payment:</h5>
										</div>

										<?php foreach ($salesArray as $saleArray) : ?>

											<?php
												$thisCartInstanceId = $saleArray[0];
												$thisSaleId = $saleArray[1];
												$saleData = DB::table('sales')->where('id', '=', $thisSaleId)->get();
												$saleDataArray = json_decode(json_encode($saleData), true);
												//var_dump($saleDataArray);

												$saleDate = $saleDataArray[0]["saleDate"];
												$dateArray = explode('-', $saleDate);
												$year = $dateArray[0];
												$yearFormatted = substr($year,2);
												$month = $dateArray[1];
												$day = $dateArray[2];
												$formattedDate = $month . "/" . $day . "/" . $yearFormatted;

												$items = $saleDataArray[0]["items"];
												$itemsArray = json_decode($items);
												$totalFee = $saleDataArray[0]["itemsSum"];
											?>

											<div class="carts__sales__sale cart-item">
												<input type="hidden" class="cart-item-ids" value="<?php echo $thisCartInstanceId; ?>">
												<h5 class="carts__sales__sale__item carts__sales__sale__start-date"><?php echo $formattedDate; ?></h5>
												<h5 class="carts__sales__sale__item carts__sales__sale__end-date"></h5>
												<h5 class="carts__sales__sale__item carts__sales__sale__fee__mobile">$<?php echo $totalFee; ?></h5>
												<div class="carts__sales__sale__items-container">
													<?php foreach ($itemsArray as $item) : ?>
														<div class="carts__sales__sale__items-row">
															<h5 class="carts__sales__sale__item carts__sales__sale__items"><?php echo $item[0]; ?></h5>
															<h5 class="carts__sales__sale__item carts__sales__sale__quantity"><?php echo $item[1]; ?></h5>
															<h5 class="carts__sales__sale__item carts__sales__sale__fee__desktop">$<?php echo number_format($item[3], 2); ?></h5>
														</div>
													<?php endforeach; ?>
													<div class="carts__sales__sale__items-total">
														<h5 class="carts__sales__sale__item carts__sales__sale__items-total__total">Total:</h5>
														<h5 class="carts__sales__sale__item carts__sales__sale__items-total__number">$<?php echo $totalFee; ?></h5>
													</div>
												</div>
												<div class="carts__sales__sale__discount">
													<input class="carts__sales__sale__discount__input discount__input form-control" type="number" min="0" max="100" placeholder="0">
													<h5 class="carts__sales__sale__discount__percentage">%</h5>
												</div>
												<h5 class="carts__sales__sale__item carts__sales__sale__total-fee total-fee">$<?php echo $totalFee; ?></h5>
												<input class="carts__sales__sale__total-fee__not-changing total-fee__not-changing" value="<?php echo $totalFee; ?>" style="display: none;">
												<a class="carts__sales__sale__item carts__sales__sale__edit"></a>
												<a class="carts__sales__sale__item carts__sales__sale__cancel openModal" data-toggle="modal" data-target="#deleteCart"><i class="fas fa-times"></i></a>
												<div class="carts__sales__sale__collect collect-switch-container">
													<label class="switch">
													  <input class="checkbox-check-out" type="checkbox">
													  <span class="slider round"></span>
													</label>
												</div>
											</div>

										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>


							<div class="carts__bottom">

								<div class="carts__bottom__right">
									<h5 class="carts__bottom__right__title">Collect payment for all items:</h5>
									<div class="carts__bottom__right__switch">
										<label class="switch">
										  <input class="check-all-check-out-box" type="checkbox">
										  <span class="slider round"></span>
										</label>
									</div>
								</div>

								<div class="carts__bottom__left">
									<div class="carts__bottom__total">
										<h2 class="carts__bottom__total__total">Total:</h2>
										<h2 class="carts__bottom__total__number">$0.00</h2>
									</div>

									<a class="carts__bottom__submit">Collect Payment</a>
								</div>

							</div>


						</div>
						
						
						<div class="carts__no-checked__container">
							<div class="alert alert-danger carts__no-checked" role="alert">
								No items have been checked. You must check an item to be able to collect payment.
							</div>
							<div class="carts__no-checked__spacer"></div>
						</div>
						

					</div>
					
				</form>

			<?php endforeach; ?>

		</div>

	<?php endif; ?>







	<!-- Delete Modal -->
	<div class="modal fade" id="deleteCart" tabindex="-1" role="dialog" aria-labelledby="deleteCart" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				
				<div class="modal-header">
					<h3 class="modal-title" id="deleteCartTitle">Delete Cart Item</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					
					<div class="carts__modal__delete-container">
						<h2 class="carts__modal__delete-title">Are you sure you want to delete this cart item?</h2>
						<p class="carts__modal__delete-sub-title">Deleting this cart item will also delete it from <span class="carts__modal__type"></span>.</p>
					</div>
					
					<form method="POST" id="submitDeleteCart">
						
						{{ method_field('PATCH') }}
						{{ csrf_field() }}

						<a id="submit-delete-cart" class="carts__modal__submit">Yes, Delete</a>
						<a class="carts__modal__cancel" data-dismiss="modal" aria-label="Close">No, Cancel</a>

					</form>
				</div>
				
			</div>
		</div>
	</div>





	<?php if ($cartsGroupedByCustomerCounted < 1) : ?>
		
		<div class="carts__no-active">
			<h1 class="carts__no-active__heading">There are no active carts.</h1>
		</div>

	<?php endif; ?>





	@section('script')
		<script type="text/javascript" src="/js/carts.js"></script>
	@endsection

@endsection
