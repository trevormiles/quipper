<?php

namespace App\Http\Controllers;

use App\SalesCategory;

use Illuminate\Http\Request;

class SalesCategoriesController extends Controller
{
    
	public function index()
		
	{
		
		$salesCategories = SalesCategory::all();
		
		return view('sales-categories.index', compact('salesCategories'));
		
	}
	
	
	
	
	public function create()
		
	{
		return view('sales-categories.create');
	}
	
	
	
	
	public function show(SalesCategory $salesCategory)
	
	{
		
		return view('sales-categories.show', compact('salesCategory'));
		
	}
	
	
	
	public function store()
	
	{
		$salesCategory = new SalesCategory();
		
		$salesCategory->category = request('category');
		
		$salesCategory->save();
		
		return redirect('/sales-categories');
	}
	
	
	
	
	public function edit(SalesCategory $salesCategory)
	
	{
		
		
		return view('sales-categories.edit', compact('salesCategory'));
		
	}
	
	
	
	
	public function update(SalesCategory $salesCategory)
	
	{
		
		$oldSalesCategoryName = request('oldName');
		$newSalesCategoryName = request('category');
		
		$salesItems = \App\SalesItem::where('category', '=', $oldSalesCategoryName)->get();
		
		foreach ($salesItems as $salesItem) {
			$salesItem->category = $newSalesCategoryName;
			$salesItem->save();
		}
		
		$salesCategory->update(request(['category']));
		
		return redirect('/sales-categories');
		
	}
	
	
	
	
	public function destroy(SalesCategory $salesCategory)
	
	{
		
		
		$salesCategory->delete();
		
		return redirect('/sales-categories');
		
	}
	
}
