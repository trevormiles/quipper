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
		$monthDay = "Rentals Today";
	} else {
		$monthDay = "Rentals";
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


	// Set up the going out and coming in arrays
	// Going Out
	$goingOut = DB::table('rentals')->where([
					['startDate', '=', $retreivedDate],
					['status', '=', "active"],
					['itemsStatus', '=', "Reserved"]
				])->orWhere([
					['startDate', '=', $retreivedDate],
					['status', '=', "active"],
					['itemsStatus', '=', "Partially Out"]
				])->orWhere([
					['startDate', '=', $retreivedDate],
					['status', '=', "active"],
					['itemsStatus', '=', "Mixed"]
				])->get();

	$goingOutArray = json_decode(json_encode($goingOut), true);


	// Coming in
	$comingIn = DB::table('rentals')->where([
					['endDate', '=', $retreivedDate],
					['status', '=', "active"]
				])->get();

	$comingInArray = json_decode(json_encode($comingIn), true);

?>


@section('title', $retreivedDateTitle)


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

<?php if($todayDate === $retreivedDate) : ?>
	@section('link-3-active-class', 'sub-nav-active')
<?php endif; ?>


@section('panel-title', $fullMonthDay)

@section('content')
	

	<div class="rentals-day">
		
		<h2 class="rentals-day__title">Going Out</h2>
		
		<?php if ($goingOutArray !== []) : ?>
		
			<div class="rentals-day__header">

				<h6 class="rentals-day__header__customer">Customer:</h6>

				<div class="rentals-day__header__items-container">

					<h6 class="rentals-day__header__item rentals-day__header__item__item-name">Item:</h6>
					<h6 class="rentals-day__header__item rentals-day__header__item__rate">Status:</h6>
					<h6 class="rentals-day__header__item rentals-day__header__item__days"># of days:</h6>
					<h6 class="rentals-day__header__item rentals-day__header__item__quantity">Quantity:</h6>
					<h6 class="rentals-day__header__item rentals-day__header__item__fee">Fee:</h6>

				</div>

			</div>


			<?php foreach($goingOutArray as $rentalData): ?>
				<a href="/rentals/<?php echo $rentalData["id"]; ?>" class="rentals-day__rental">

					<div class="rentals-day__rental__container">

						<h6 class="rentals-day__rental__customer"><?php echo $rentalData["customer"]; ?></h6>

						<div class="rentals-day__rental__items-container">

							<?php
								$rentalItemsArray = $rentalData["items"];
								$rentalItemsArrayDecoded = json_decode($rentalItemsArray);
							?>

							<?php foreach($rentalItemsArrayDecoded as $rentalItemData): ?>

								<div class="rentals-day__rental__item-container">
									<h6 class="rentals-day__rental__item rentals-day__rental__item__item-name"><?php echo $rentalItemData[0]; ?></h6>
									<h6 class="rentals-day__rental__item rentals-day__rental__item__rate"><?php echo $rentalItemData[6];?></h6>
									<h6 class="rentals-day__rental__item rentals-day__rental__item__days"><?php echo $rentalItemData[2]; ?></h6>
									<h6 class="rentals-day__rental__item rentals-day__rental__item__quantity"><?php echo $rentalItemData[1]; ?></h6>
									<h6 class="rentals-day__rental__item rentals-day__rental__item__fee"><?php echo "$" . number_format($rentalItemData[5], 2); ?></h6>
								</div>

							<?php endforeach; ?>

							<div class="rentals-day__rental__total">
								<h6 class="rentals-day__rental__total__text"><?php echo "$" . $rentalData["itemsSum"] ?></h6>
							</div>

						</div>

					</div>

				</a>

			<?php endforeach; ?>
		
		<?php endif; ?>
		
		
		<?php if ($goingOutArray === []) : ?>
			<div class="rentals-day__none">
				<h2 class="rentals-day__none__text">No items going out</h2>
			</div>
		<?php endif; ?>
		
		
		
		
		
		
		
		
		<h2 class="rentals-day__title">Coming In</h2>
		
		<?php if ($comingInArray !== []) : ?>
		
			<div class="rentals-day__header">

				<h6 class="rentals-day__header__customer">Customer:</h6>

				<div class="rentals-day__header__items-container">

					<h6 class="rentals-day__header__item rentals-day__header__item__item-name">Item:</h6>
					<h6 class="rentals-day__header__item rentals-day__header__item__rate">Status:</h6>
					<h6 class="rentals-day__header__item rentals-day__header__item__days"># of days:</h6>
					<h6 class="rentals-day__header__item rentals-day__header__item__quantity">Quantity:</h6>
					<h6 class="rentals-day__header__item rentals-day__header__item__fee">Fee:</h6>

				</div>

			</div>


			<?php foreach($comingInArray as $rentalData): ?>
				<a href="/rentals/<?php echo $rentalData["id"]; ?>" class="rentals-day__rental">

					<div class="rentals-day__rental__container">

						<h6 class="rentals-day__rental__customer"><?php echo $rentalData["customer"] ?></h6>

						<div class="rentals-day__rental__items-container">

							<?php
								$rentalItemsArray = $rentalData["items"];
								$rentalItemsArrayDecoded = json_decode($rentalItemsArray);
							?>

							<?php foreach($rentalItemsArrayDecoded as $rentalItemData): ?>

								<div class="rentals-day__rental__item-container">
									<h6 class="rentals-day__rental__item rentals-day__rental__item__item-name"><?php echo $rentalItemData[0]; ?></h6>
									<h6 class="rentals-day__rental__item rentals-day__rental__item__rate"><?php echo $rentalItemData[6];?></h6>
									<h6 class="rentals-day__rental__item rentals-day__rental__item__days"><?php echo $rentalItemData[2]; ?></h6>
									<h6 class="rentals-day__rental__item rentals-day__rental__item__quantity"><?php echo $rentalItemData[1]; ?></h6>
									<h6 class="rentals-day__rental__item rentals-day__rental__item__fee"><?php echo "$" . number_format($rentalItemData[5], 2); ?></h6>
								</div>

							<?php endforeach; ?>

							<div class="rentals-day__rental__total">
								<h6 class="rentals-day__rental__total__text"><?php echo "$" . $rentalData["itemsSum"] ?></h6>
							</div>

						</div>

					</div>

				</a>

			<?php endforeach; ?>
		
		<?php endif; ?>
		
		
		<?php if ($comingInArray === []) : ?>
			<div class="rentals-day__none">
				<h2 class="rentals-day__none__text">No items coming in</h2>
			</div>
		<?php endif; ?>
		
		
	</div>
	
@endsection