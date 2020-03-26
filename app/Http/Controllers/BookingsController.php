<?php

namespace App\Http\Controllers;

use App\Booking;

use App\Customer;

use App\Cart;

use DB;

use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function index()
	
	{	
		$bookings = \App\Booking::all();
		
		$customers = \App\Customer::all();
		
		return view('booking.index', compact('bookings', 'customers'));
		
	}
	
	public function create()
	
	{
		$customers = \App\Customer::all();
		
		$bookingItems = \App\BookingItem::all();
		
		
		return view('booking.create', compact('customers', 'bookingItems'));
	}
	
	public function create2()
	
	{
		$customers = \App\Customer::all();
		
		$bookingItems = \App\BookingItem::all();
		
		
		return view('booking.create2', compact('customers', 'bookingItems'));
	}
	
	
	public function show(Booking $booking)
	
	{
		
		return view('booking.show', compact('booking'));
		
	}
	
	
	public function edit(Booking $booking)
	
	{
		$customers = \App\Customer::all();
		
		$bookingItems = \App\BookingItem::all();
		
		return view('booking.edit', compact('booking', 'customers', 'bookingItems'));
		
	}
	
	
	
	public function edit2() 
		
	{
		
		$bookings = \App\Booking::all();
		
		$customers = \App\Customer::all();
		
		$bookingItems = \App\BookingItem::all();
		
		return view('booking.edit2', compact('bookings', 'customers', 'bookingItems'));
		
	}
	
	
	
	
	public function store()
	
	{
		$booking = new Booking();
		
		$booking->customer = request('customer');
		$booking->bookingDate = request('date');
		$booking->startTime = request('startTime');
		$booking->endTime = request('endTime');
		$booking->items = request('items');
		$booking->itemsSum = request('itemsSum');
		$booking->status = "active";
		
		$booking->save();
		
		
		$cart = new Cart();
		
		$cart->customer = request('customer');
		$cart->bookingID = $booking->id;
		$cart->status = "active";
		
		$cart->save();
		
		return redirect('/booking');
		
	}
	
	
	
	
	public function update(Booking $booking)
		
	{
		
		$booking->customer = request('customer');
		$booking->bookingDate = request('date');
		$booking->startTime = request('startTime');
		$booking->endTime = request('endTime');
		$booking->items = request('items');
		$booking->itemsSum = request('itemsSum');
		
		$booking->save();
		
		return redirect('/booking/' . $booking->id );
		
	}
	
	
	
	
	public function deleteBooking(Booking $booking)
		
	{
		
		$booking->status = "inactive";
		$booking->save();
		
		\App\Cart::where('bookingID', $booking->id)->update(array('status' => "inactive"));
		
		return redirect('/booking');
		
	}
	
	
	
	
	
	public function deletePastBooking(Booking $booking)
		
	{
		
		$booking->status = "inactive";
		$booking->save();
		
		\App\Cart::where('bookingID', $booking->id)->update(array('status' => "inactive"));
		
		return redirect('/booking-past');
		
	}
	
	
	
	
	
	public function day()
		
	{
		$bookingItems = \App\BookingItem::all();
		return view('booking.day', compact('bookingItems'));
	}
	
	
	
	
	
	
	public function past()
	
	{	
		$bookings = \App\Booking::all();
		
		$customers = \App\Customer::all();
		
		return view('booking.past', compact('bookings', 'customers'));
		
	}
	
	
		
}
