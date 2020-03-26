<?php

namespace App\Http\Controllers;

use App\Customer;

use Illuminate\Http\Request;

class CustomersController extends Controller
{
	
	
    public function index()
	
	{
		
		$customers = Customer::all();
		
		return view('customers.index', compact('customers'));
	}
	
	
	
	public function create()
	
	{
		
		$customers = Customer::all();
		
		return view('customers.create', compact('customers'));
		
	}
	
	
	
	
	public function show(Customer $customer)
	
	{
		
		return view('customers.show', compact('customer'));
		
	}
	
	
	
	
	public function store()
	
	{
		
		$customer = new Customer();
		$customer->name = request('name');
		$customer->email = request('email');
		$customer->phonenumber = request('phonenumber');
		$customer->status = "active";
		
		$customer->save();
		
		return redirect('/customers');
		
	}
	
	
	
	
	public function newCustomerFromRentals()
		
	{
		
		$customer = new Customer();
		$customer->name = request('name');
		$customer->email = request('email');
		$customer->phonenumber = request('phoneNumber');
		$customer->status = "active";
		
		$customerName = request('name');
		$startDate = request('startDate');
		$endDate = request('endDate');
		
		$hrefPreLocation = '/rentals-create2?data=';
		$hrefLocation = $hrefPreLocation . $startDate . "-" . $endDate . "-" . $customerName;
		
		$customer->save();
	
		
		return redirect($hrefLocation);
		
	}
	
	
	
	
	
	public function newCustomerFromEditRentals()
		
	{
		
		$customer = new Customer();
		$customer->name = request('name');
		$customer->email = request('email');
		$customer->phonenumber = request('phoneNumber');
		$customer->status = "active";
		
		$customerName = request('name');
		$startDate = request('startDate');
		$endDate = request('endDate');
		$thisRentalID = request('thisRentalID');
		
		$hrefPreLocation = '/rentals-edit2?data=';
		$hrefLocation = $hrefPreLocation . $thisRentalID . "-" . $startDate . "-" . $endDate . "-" . $customerName;
		
		$customer->save();
	
		
		return redirect($hrefLocation);
		
	}
	
	
	
	
	public function newCustomerFromSales()
		
	{
		
		$customer = new Customer();
		$customer->name = request('name');
		$customer->email = request('email');
		$customer->phonenumber = request('phoneNumber');
		$customer->status = "active";
		
		$customerName = request('name');
		
		$hrefPreLocation = '/sales-create2?data=';
		$hrefLocation = $hrefPreLocation . $customerName;
		
		$customer->save();
	
		
		return redirect($hrefLocation);
		
	}
	
	
	
	
	
	public function newCustomerFromBooking()
		
	{
		
		$customer = new Customer();
		$customer->name = request('name');
		$customer->email = request('email');
		$customer->phonenumber = request('phoneNumber');
		$customer->status = "active";
		
		$customerName = request('name');
		$date = request('date');
		$startTime = request('startTime');
		$endTime = request('endTime');
		
		$hrefPreLocation = '/booking-create2?data=';
		$hrefLocation = $hrefPreLocation . $date . "-" . $customerName . "-" . $startTime . "-" . $endTime;
		
		$customer->save();
	
		
		return redirect($hrefLocation);
		
	}
	
	
	
	
	
	public function newCustomerFromEditBooking()
		
	{
		
		$customer = new Customer();
		$customer->name = request('name');
		$customer->email = request('email');
		$customer->phonenumber = request('phoneNumber');
		$customer->status = "active";
		
		$customerName = request('name');
		$date = request('date');
		$startTime = request('startTime');
		$endTime = request('endTime');
		$thisBookingID = request('thisBookingID');
		
		$hrefPreLocation = '/booking-edit2?data=';
		$hrefLocation = $hrefPreLocation . $thisBookingID . "-" . $date . "-" . $customerName . "-" . $startTime . "-" . $endTime;
		
		$customer->save();
	
		
		return redirect($hrefLocation);
		
	}
	
	
	
	
	
	public function deleteCustomer(Customer $customer)
		
	{
		
		$customer->status = "inactive";
		$customer->save();
		
		return redirect('/customers');
		
	}
	
	
	
	
	
	public function edit(Customer $customer)
	
	{
		
		$customers = Customer::all();
		return view('customers.edit', compact('customer', 'customers'));
		
	}
	
	
	
	
	public function update(Customer $customer)
	
	{
		
		$customer->update(request(['name', 'phonenumber', 'email']));
		
		
		$oldCustomerName = request('oldCustomerName');
		$newCustomerName = request('name');
		
		
		$rentalsWithThisCustomer = \App\Rental::where('customer', 'LIKE', '%'.$oldCustomerName.'%')->get();
		
		foreach ($rentalsWithThisCustomer as $rentalWithThisCustomer) {
			$rentalWithThisCustomer->customer = $newCustomerName;
			$rentalWithThisCustomer->save();
		}
		
		
		$bookingsWithThisCustomer = \App\Booking::where('customer', 'LIKE', '%'.$oldCustomerName.'%')->get();
		
		foreach ($bookingsWithThisCustomer as $bookingWithThisCustomer) {
			$bookingWithThisCustomer->customer = $newCustomerName;
			$bookingWithThisCustomer->save();
		}
		
		
		$salesWithThisCustomer = \App\Sale::where('customer', 'LIKE', '%'.$oldCustomerName.'%')->get();
		
		foreach ($salesWithThisCustomer as $saleWithThisCustomer) {
			$saleWithThisCustomer->customer = $newCustomerName;
			$saleWithThisCustomer->save();
		}
		
		
		$cartsWithThisCustomer = \App\Cart::where('customer', 'LIKE', '%'.$oldCustomerName.'%')->get();
		
		foreach ($cartsWithThisCustomer as $cartWithThisCustomer) {
			$cartWithThisCustomer->customer = $newCustomerName;
			$cartWithThisCustomer->save();
		}
		
				
		return redirect('/customers');
		
	}
	
	
	
	
	public function destroy(Customer $customer)
	
	{
		
		$customer->delete();
		
		return redirect('/customers');
		
	}
	
}
