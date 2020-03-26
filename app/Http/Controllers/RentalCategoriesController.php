<?php

namespace App\Http\Controllers;

use App\RentalCategory;

use Illuminate\Http\Request;

class RentalCategoriesController extends Controller
{
    
	public function index()
		
	{
		
		$rentalCategories = RentalCategory::all();
		
		return view('rental-categories.index', compact('rentalCategories'));
		
	}
	
	
	
	
	public function create()
		
	{
		return view('rental-categories.create');
	}
	
	
	
	
	public function show(RentalCategory $rentalCategory)
	
	{
		
		return view('rental-categories.show', compact('rentalCategory'));
		
	}
	
	
	
	public function store()
	
	{
		$rentalCategory = new RentalCategory();
		
		$rentalCategory->category = request('category');
		
		$rentalCategory->save();
		
		return redirect('/rental-categories');
	}
	
	
	
	
	public function edit(RentalCategory $rentalCategory)
	
	{
		
		
		return view('rental-categories.edit', compact('rentalCategory'));
		
	}
	
	
	
	
	public function update(RentalCategory $rentalCategory)
	
	{
		
		$oldRentalCategoryName = request('oldName');
		$newRentalCategoryName = request('category');
		
		$rentalItems = \App\RentalItem::where('category', '=', $oldRentalCategoryName)->get();
		
		foreach ($rentalItems as $rentalItem) {
			$rentalItem->category = $newRentalCategoryName;
			$rentalItem->save();
		}
		
		$rentalCategory->update(request(['category']));
		
		return redirect('/rental-categories');
		
	}
	
	
	
	
	public function destroy(RentalCategory $rentalCategory)
	
	{
		
		
		$rentalCategory->delete();
		
		return redirect('/rental-categories');
		
	}
	
}
