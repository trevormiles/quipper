<?php

namespace App\Http\Controllers;

use App\BookingItem;

use Illuminate\Http\Request;

class BookingItemsController extends Controller
{
    public function index()
	
	{
		$bookingItems = BookingItem::all();
		
		$bookingCategories = \App\BookingCategory::all();
		
		return view('booking-items.index', compact('bookingItems', 'bookingCategories'));
	}
	
	
	
	
	public function create()
		
	{
		
		$bookingCategories = \App\BookingCategory::all();
		
		return view('booking-items.create', compact('bookingCategories'));
	}
	
	
	
	public function show(BookingItem $bookingItem)
	
	{
		
		return view('booking-items.show', compact('bookingItem'));
		
	}
	
	
	
	
	public function store()
	
	{
		BookingItem::create(request(['title', 'category', 'firstHourRate', 'additionalHourRate']));
		
		return redirect('/booking-items');
	}
	
	
	
	
	public function edit(BookingItem $bookingItem)
	
	{
		
		$bookingCategories = \App\BookingCategory::all();
		
		return view('booking-items.edit', compact('bookingItem', 'bookingCategories'));
		
	}
	
	
	
	
	public function update(BookingItem $bookingItem)
	
	{

		
		$bookingItem->update(request(['title', 'firstHourRate', 'additionalHourRate', 'category']));
		
		return redirect('/booking-items');
		
	}
	
	
	
	
	public function destroy(BookingItem $bookingItem)
	
	{
		
		
		$bookingItem->delete();
		
		return redirect('/booking-items');
		
	}
}
