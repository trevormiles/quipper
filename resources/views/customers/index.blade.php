@extends('layout')

<?php date_default_timezone_set('America/Denver'); ?>

@section('title', 'Quipper | Customers')



@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')



@section('link-1-title', 'All Customers')
@section('link-1-location', '/customers')
@section('link-1-active-class', 'sub-nav-active')


@section('link-2-icon')
	<i class="fas fa-plus"></i>
@endsection
@section('link-2-title', 'New Customer')
@section('link-2-location', '/customers/create')


@section('link-3-title', '')
@section('link-3-location', '')



@section('panel-title', 'All Customers')

@section('content')

	<div class="customers">
		
		<div class="customers__top-container">
			
			<h3 class="customers__title">All Customers</h3>
			
			<div class="customers__type-input__container">
				<input class="customers__type-input__input" type="text" id="myInput" onkeyup="myFunction()"  placeholder="Type a name to begin searching...">
				<div class="customers__type-input__search-container"><i class="fas fa-search"></i></div>
			</div>
			
		</div>
			
		<table id="myTable" class="customers__table">

			<tr class="customers__header">
				<th class="customers__header__item customers__header__name">Name</th>
				<th class="customers__header__item customers__header__email">Email</th>
				<th class="customers__header__item customers__header__phone">Phone Number</th>
				<th class="customers__header__item customers__header__edit">Edit</th>
				<th class="customers__header__item customers__header__delete">Delete</th>
			</tr>
			
			<?php 
				$alphabeticalCustomers = App\Customer::orderBy('name')->where('status', '=', 'active')->get();
			?>

			@foreach ($alphabeticalCustomers as $customer)

				<tr class="customers__customer">
					<td class="customers__customer__item customers__customer__name">{{ $customer->name }}</td>
					<td class="customers__customer__item customers__customer__email">{{ $customer->email }}</td>
					<td class="customers__customer__item customers__customer__phone">{{ $customer->phonenumber }}</td>
					<td class="customers__customer__item customers__customer__edit"><a href="/customers/{{ $customer->id }}/edit" class="customers__customer__edit__link"><i class="fas fa-edit"></i></a></td>
					<td class="customers__customer__item customers__customer__delete"><a class="customers__customer__delete__times"  data-toggle="modal" data-target="#modal<?php echo $customer->id; ?>"><i class="fas fa-times"></i></a></td>
				</tr>
			
				<div class="modal fade" id="modal<?php echo $customer->id; ?>" tabindex="-1" role="dialog" aria-labelledby="Delete Box Modal" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">

							<div class="modal-header">
								<h5 class="modal-title">Delete this customer?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body">
								<form method="POST" action="/customer-delete/<?php echo $customer->id; ?>">
									{{ method_field('PATCH') }}
									{{ csrf_field() }}
									
									<h3 class="customers__modal__title"><?php echo $customer->name; ?></h3>

									<?php

										$thisCustomersName = $customer->name;
										$todaysDate = date('Y-m-d');

										$activeRentalsWithThisCustomer = DB::table('rentals')->where('customer', 'LIKE', '%'.$thisCustomersName.'%')
																						 ->where('status', '=', "active")
																						 ->get();
									
										$activeRentalsWithThisCustomer = json_decode(json_encode($activeRentalsWithThisCustomer), true);
									
										$activeBookingsWithThisCustomer = DB::table('bookings')->where('customer', 'LIKE', '%'.$thisCustomersName.'%')
																						 ->where('bookingDate', '>=', $todaysDate)
																						 ->get();
									
										$activeBookingsWithThisCustomer = json_decode(json_encode($activeBookingsWithThisCustomer), true);

									?>

									<?php if ((empty($activeRentalsWithThisCustomer)) && (empty($activeBookingsWithThisCustomer))) : ?>

										<div class="customers__modal__button__container">
											<button type="submit" class="customers__modal__button__submit">Yes, delete</button>
											<h6 class="customers__modal__button__cancel" data-dismiss="modal" aria-label="Close">No, cancel</h6>
										</div>

									<?php else : ?>

										<p class="customers__modal__there-are-active-items">There is currently an active rental or booking with this customer. You can only delete customers if there are no active rentals or bookings under that customer's name.</p>

									<?php endif; ?>

								</form>
							</div>

						</div>
					</div>
				</div>

			@endforeach

		</table>

		<div class="customers__no-matches" id="noMatchesItemsTable">
			<h4 class="customers__no-matches__text">No customers match your search</h4>
		</div>

	</div>


	@section('script')
		<script type="text/javascript" src="/js/customers.js"></script>
	@endsection


@endsection
