<?php

namespace App\Http\Controllers;

use App\BookingCategory;

use Illuminate\Http\Request;

class BookingCategoriesController extends Controller
{
    
	public function index()
		
	{
		
		$bookingCategories = BookingCategory::all();
		
		return view('booking-categories.index', compact('bookingCategories'));
		
	}
	
	
	
	
	public function create()
		
	{
		return view('booking-categories.create');
	}
	
	
	
	
	public function show(BookingCategory $bookingCategory)
	
	{
		
		return view('booking-categories.show', compact('bookingCategory'));
		
	}
	
	
	
	public function store()
	
	{
		$bookingCategory = new BookingCategory();
		
		$bookingCategory->category = request('category');
		
		$bookingCategory->save();
		
		return redirect('/booking-categories');
	}
	
	
	
	
	public function edit(BookingCategory $bookingCategory)
	
	{
		
		
		return view('booking-categories.edit', compact('bookingCategory'));
		
	}
	
	
	
	
	public function update(BookingCategory $bookingCategory)
	
	{
		
		$oldBookingCategoryName = request('oldName');
		$newBookingCategoryName = request('category');
		
		$bookingItems = \App\BookingItem::where('category', '=', $oldBookingCategoryName)->get();
		
		foreach ($bookingItems as $bookingItem) {
			$bookingItem->category = $newBookingCategoryName;
			$bookingItem->save();
		}
		
		$bookingCategory->update(request(['category']));
		
		return redirect('/booking-categories');
		
	}
	
	
	
	
	public function destroy(BookingCategory $bookingCategory)
	
	{
		
		
		$bookingCategory->delete();
		
		return redirect('/booking-categories');
		
	}
	
}
