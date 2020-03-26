<?php

namespace App\Http\Controllers;

use App\Sale;

use App\Cart;

use DB;

use Illuminate\Http\Request;

class SalesController extends Controller
{	
	
	public function create()
	
	{
		$customers = \App\Customer::all();
		
		$salesItems = \App\SalesItem::all();
		
		
		return view('sales.create', compact('customers', 'salesItems'));
	}
	
	
	
	
	
	public function create2()
	
	{
		$customers = \App\Customer::all();
		
		$salesItems = \App\SalesItem::all();
		
		$salesCategories = \App\SalesCategory::all();
		
		
		return view('sales.create2', compact('customers', 'salesItems', 'salesCategories'));
	}
	
	
	
	
	public function store()
	
	{
		$sale = new Sale();
		
		$sale->customer = request('customer');
		$sale->saleDate = request('saleDate');		
		$sale->items = request('items');
		$sale->itemsSum = request('itemsSum');
		
		$sale->save();
		
		
		// Decrease each item sold by the quantity
		$allItemsSold = request('items');
		$allItemsSold = json_decode($allItemsSold);
		
		foreach ($allItemsSold as $item) {
			$itemTitle = $item[0];
			$itemQuantity = $item[1];
			$inventoryItem= \App\SalesItem::where('title', '=', $itemTitle)->get();
			$inventoryQuantity = $inventoryItem[0]["quantity"];
			$newInventoryQuantity = $inventoryQuantity - $itemQuantity;
			\App\SalesItem::where('title', '=', $itemTitle)->update(array('quantity' => $newInventoryQuantity));
		}
																			  
		
		$cart = new Cart();
		
		$cart->customer = request('customer');
		$cart->salesID = $sale->id;
		$cart->status = "active";
		
		$cart->save();
		
		
		return redirect('/carts');
	}
	
	
}
