<?php

namespace App\Http\Controllers;

use App\RentalItem;

use Illuminate\Http\Request;

class RentalItemsController extends Controller
{
    public function index()
	
	{
		$rentalItems = RentalItem::all();
		
		$rentalCategories = \App\RentalCategory::all();
		
		return view('rental-items.index', compact('rentalItems', 'rentalCategories'));
	}
	
	
	
	
	public function create()
		
	{
		
		$rentalCategories = \App\RentalCategory::all();
		
		return view('rental-items.create', compact('rentalCategories'));
	}
	
	
	
	public function show(RentalItem $rentalItem)
	
	{
		
		return view('rental-items.show', compact('rentalItem'));
		
	}
	
	
	
	
	public function store()
	
	{
		RentalItem::create(request(['title', 'quantity', 'category', 'firstDayRate', 'secondDayRate']));
		
		return redirect('/rental-items');
	}
	
	
	
	
	public function edit(RentalItem $rentalItem)
	
	{
		
		$rentalCategories = \App\RentalCategory::all();
		
		return view('rental-items.edit', compact('rentalItem', 'rentalCategories'));
		
	}
	
	
	
	
	public function update(RentalItem $rentalItem)
	
	{

		
		$rentalItem->update(request(['title', 'quantity', 'firstDayRate', 'secondDayRate', 'category']));
		
		return redirect('/rental-items');
		
	}
	
	
	
	
	public function destroy(RentalItem $rentalItem)
	
	{
		
		
		$rentalItem->delete();
		
		return redirect('/rental-items');
		
	}
}
