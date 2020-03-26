<?php

namespace App\Http\Controllers;

use App\Customer;

use DB;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
	
    public function index()
	
	{	
		
		$customers = \App\Customer::all();
		
		return view('transactions.index', compact('customers'));
		
	}
	
	
}
