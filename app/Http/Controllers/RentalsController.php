<?php

namespace App\Http\Controllers;

use App\Rental;

use App\Customer;

use App\Cart;

use DB;

use Illuminate\Http\Request;

class RentalsController extends Controller
{
    public function index()
	
	{	
		$rentals = \App\Rental::all();
		
		$customers = \App\Customer::all();
		
		return view('rentals.index', compact('rentals', 'customers'));
		
	}
	
	public function create()
	
	{
		$customers = \App\Customer::all();
		
		$rentalItems = \App\RentalItem::all();
		
		
		return view('rentals.create', compact('customers', 'rentalItems'));
	}
	
	public function create2()
	
	{
		$customers = \App\Customer::all();
		
		$rentalItems = \App\RentalItem::all();
		
		
		return view('rentals.create2', compact('customers', 'rentalItems'));
	}
	
	
	public function show(Rental $rental)
	
	{
		
		return view('rentals.show', compact('rental'));
		
	}
	
	
	public function edit(Rental $rental)
	
	{
		$customers = \App\Customer::all();
		
		$rentalItems = \App\RentalItem::all();
		
		return view('rentals.edit', compact('rental', 'customers', 'rentalItems'));
		
	}
	
	
	
	public function edit2() 
		
	{
		
		$rentals = \App\Rental::all();
		
		$customers = \App\Customer::all();
		
		$rentalItems = \App\RentalItem::all();
		
		return view('rentals.edit2', compact('rentals', 'customers', 'rentalItems'));
		
	}
	
	
	
	
	public function store()
	
	{
		$rental = new Rental();
		
		$rental->customer = request('customer');
		$rental->startDate = request('startDate');
		$rental->endDate = request('endDate');		
		$rental->items = request('items');
		$rental->itemsSum = request('itemsSum');
		$rental->itemsStatus = "Reserved";
		$rental->status = request('status');
		
		$rental->save();
		
		
		$cart = new Cart();
		
		$cart->customer = request('customer');
		$cart->rentalID = $rental->id;
		$cart->status = "active";
		
		$cart->save();
		
		
		return redirect('/rentals');
	}
	
	
	
	
	public function update(Rental $rental)
		
	{
		
		$rental->customer = request('customer');
		$rental->startDate = request('startDate');
		$rental->endDate = request('endDate');
		$rental->items = request('items');
		$rental->itemsSum = request('itemsSum');
		$rental->itemsStatus = request('itemsStatus');
		$rental->status = request('status');
		
		$rental->save();
		
		if ($rental->status === "inactive") {
			return redirect('/rentals');
		} else {
			return redirect('/rentals/' . $rental->id );
		}
		
	}
	
	
	
	public function deleteRental(Rental $rental)
		
	{
		
		$rental->status = "inactive";
		$rental->save();
		
		\App\Cart::where('rentalID', $rental->id)->update(array('status' => "inactive"));
		
		return redirect('/rentals');
		
	}
	
	
	
	public function day()
		
	{
		return view('rentals.day');
	}
		
}
