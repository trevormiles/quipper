<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*

	GET /projects (index)
	GET /projects/create (create)
	GET /projects/1 (show)
	POST /projects (store)
	GET /projects/1/edit (edit)
	PATCH /projects/1 (update)
	DELETE /projects/1 (destroy)

*/

/*
Route::get('/', 'RentalsController@index');
Route::get('/create', 'RentalsController@create');
Route::get('/{rental}', 'RentalsController@show');
Route::post('/', 'RentalsController@store');
Route::get('/{rental}/edit', 'RentalsController@edit');
Route::patch('/{rental}', 'RentalsController@update');
Route::delete('/{rental}', 'RentalsController@destroy');
*/

Route::get('/', function () {
	return redirect('/rentals');
});

// Rentals Routes
Route::resource('/rentals', 'RentalsController');
Route::get('/rentals-day', 'RentalsController@day');
Route::patch('/{rental}/rental-delete', 'RentalsController@deleteRental');
Route::get('/rentals-create2', 'RentalsController@create2');
Route::get('/rentals-edit2', 'RentalsController@edit2');


// Booking Routes
Route::resource('/booking', 'BookingsController');
Route::get('/booking-day', 'BookingsController@day');
Route::patch('/{booking}/booking-delete', 'BookingsController@deleteBooking');
Route::patch('/{booking}/past-booking-delete', 'BookingsController@deletePastBooking');
Route::get('/booking-create2', 'BookingsController@create2');
Route::get('/booking-edit2', 'BookingsController@edit2');
Route::get('/booking-past', 'BookingsController@past');


// Carts Routes
Route::resource('/carts', 'CartsController');
Route::patch('/carts-update', 'CartsController@cartsUpdate');
Route::patch('/{cart}/cart-delete', 'CartsController@deleteCart');


// Accounting/Transaction Routes
Route::resource('/accounting', 'TransactionsController');


// Customers Routes
Route::resource('customers', 'CustomersController');
Route::post('/new-customer-from-rentals', 'CustomersController@newCustomerFromRentals');
Route::post('/new-customer-from-edit-rentals', 'CustomersController@newCustomerFromEditRentals');
Route::post('/new-customer-from-sales', 'CustomersController@newCustomerFromSales');
Route::post('/new-customer-from-booking', 'CustomersController@newCustomerFromBooking');
Route::post('/new-customer-from-edit-booking', 'CustomersController@newCustomerFromEditBooking');
Route::patch('/customer-delete/{customer}', 'CustomersController@deleteCustomer');


// Rental Items Routes
Route::resource('/rental-items', 'RentalItemsController');


// Rental Categories Routes
Route::resource('/rental-categories', 'RentalCategoriesController');


// Sales Categories Routes
Route::resource('/sales-categories', 'SalesCategoriesController');


// Booking Categories Routes
Route::resource('/booking-categories', 'BookingCategoriesController');


// Sales Items Routes
Route::resource('/sales-items', 'SalesItemsController');


// Booking Items Routes
Route::resource('/booking-items', 'BookingItemsController');


// Settings Routes
Route::get('/settings', 'SettingsController@edit');
Route::patch('/update-main-navigation', 'SettingsController@updateMenuItems');
Route::patch('/update-organization-name', 'SettingsController@updateOrganizationName');


// Sales Routes
Route::get('sales/create', 'SalesController@create');
Route::get('sales-create2', 'SalesController@create2');
Route::post('/sales', 'SalesController@store');
