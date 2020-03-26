<?php

namespace App\Http\Controllers;

use App\SalesItem;

use Illuminate\Http\Request;

class SalesItemsController extends Controller
{
    public function index()
	
	{
		$salesItems = SalesItem::all();
		
		$salesCategories = \App\SalesCategory::all();
		
		return view('sales-items.index', compact('salesItems', 'salesCategories'));
	}
	
	
	
	
	public function create()
		
	{
		
		$salesCategories = \App\SalesCategory::all();
		
		return view('sales-items.create', compact('salesCategories'));
	}
	
	
	
	public function show(SalesItem $salesItem)
	
	{
		
		return view('sales-items.show', compact('salesItem'));
		
	}
	
	
	
	
	public function store()
	
	{
		SalesItem::create(request(['title', 'quantity', 'category', 'price']));
		
		return redirect('/sales-items');
	}
	
	
	
	
	public function edit(SalesItem $salesItem)
	
	{
		
		$salesCategories = \App\SalesCategory::all();
		
		return view('sales-items.edit', compact('salesItem', 'salesCategories'));
		
	}
	
	
	
	
	public function update(SalesItem $salesItem)
	
	{

		
		$salesItem->update(request(['title', 'quantity', 'price', 'category']));
		
		return redirect('/sales-items');
		
	}
	
	
	
	
	public function destroy(SalesItem $salesItem)
	
	{
		
		
		$salesItem->delete();
		
		return redirect('/sales-items');
		
	}
}
