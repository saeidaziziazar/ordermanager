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

Route::get('/', function () {
    return view('homepage');
})->middleware('auth');

Route::post('orders/report', 'OrderController@report')->middleware('checkorder');
Route::match(array('GET', 'POST'), 'orders/generalreport', 'OrderController@generalReport')->middleware(['auth', 'active',]);
Route::post('orders/viewed', 'OrderController@viewed')->middleware('selected');
Route::post('orders/returnviewed', 'OrderController@unviewed')->middleware('selected');
Route::post('orders/certain', 'OrderController@certain')->middleware('selected');
Route::post('orders/temporary', 'OrderController@temporary')->middleware('selected');
Route::get('orders/create/{id}', 'OrderController@create');
Route::post('order', 'OrderController@store');
Route::post('year/change', 'YearController@changeUserYear');
Route::match(array('GET', 'POST'),'acount', 'UserController@acount')->middleware(['auth', 'active',]);
Route::match(array('GET', 'POST'), 'orders', 'OrderController@index')->middleware(['auth', 'active',]);;

Route::delete('orders', 'OrderController@destroy')->middleware(['auth', 'active', 'selected']);
Route::delete('costumers', 'CostumerController@destroy')->middleware(['auth', 'active',]);
Route::delete('transportations', 'TransportationController@destroy')->middleware(['auth', 'active',]);
Route::delete('owners', 'OwnerController@destroy')->middleware(['auth', 'active']);
Route::delete('users', 'UserController@destroy')->middleware(['auth', 'active',]);

Route::resource('costumers', 'CostumerController', ['except' => ['show', 'destroy']]);
Route::resource('transportations', 'TransportationController', ['except' => ['show', 'destroy']]);
Route::resource('orders', 'OrderController', ['except' => ['destroy', 'index', 'store']]);
Route::resource('owners', 'OwnerController', ['except' => ['show', 'destroy']]);
Route::resource('users', 'UserController', ['except' => ['show', 'destroy']]);

Route::get('login', 'LoginController@loginForm')->name('login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');



Route::get('/test', function() {
    $orders = App\Order::all();
    return view('home')->with('orders', $orders);
});

