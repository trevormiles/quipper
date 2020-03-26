<?php

namespace App\Http\Controllers;

use App\Cart;

use App\Customer;

use App\Rental;

use App\Booking;

use DB;

use Illuminate\Http\Request;

class CartsController extends Controller
{
	
    public function index()
	
	{	
		
		$carts = \App\Cart::all();
		
		$customers = \App\Customer::all();
		
		return view('carts.index', compact('carts', 'customers'));
		
	}
	
	
	public function cartsUpdate()
		
	{	
		
		$checkedItemsString = request('checkedItemsArray');
		$checkedItemsArray = (explode(",",$checkedItemsString));
		$customer = $checkedItemsArray[0];
		array_shift($checkedItemsArray);
		
		foreach ($checkedItemsArray as $checkedItem) {
			
			$cart = Cart::findOrFail($checkedItem);
			$cart->status = "inactive";
			
			$cart->update();
		}
		
		return redirect('/carts?cart=' . $customer);
	}
	
	
	
	public function deleteCart(Cart $cart)
		
	{
		
		$cart->status = "inactive";
		$cart->save();
		
		if (!empty($cart->rentalID)) {
			$rentalIDToDelete = $cart->rentalID;
			$rentalToDelete = \App\Rental::where('id', $rentalIDToDelete)->update(array('status' => "inactive"));
		}
		
		if (!empty($cart->bookingID)) {
			$bookingIDToDelete = $cart->bookingID;
			$bookingToDelete = \App\Booking::where('id', $bookingIDToDelete)->update(array('status' => "inactive"));
		}
		
		return redirect('/carts');
		
	}
	
	
}
