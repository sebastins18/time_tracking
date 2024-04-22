<?php

Route::get('/', 'LoginController@index');
Route::post('/', 'LoginController@handleLogin');
Route::get('/logout', 'LoginController@logout');

Route::get('/user/dashboard_user', 'DashboardController@userDashboard');

Route::resource('event', 'EventController');
Route::get('/event/details/(:number)', 'EventController@show');
Route::get('/event/(:number)/delete', 'EventController@destroy');
Route::post('/event/create2', 'EventController@create2');

Route::get('/event/(:number)/guests', 'EventGuestController@showGuests');
Route::get('/event/(:number)/guests/(:number)/delete', 'EventGuestController@deleteGuest');
Route::get('/event/(:number)/guests/add', 'EventGuestController@addGuestsView');
Route::post('/event/(:number)/add_guests', 'EventGuestController@addGuests');

Route::get('/dashboard/view', 'DashboardController@userDashboard');


Route::get('/user/dashboard_admin', 'UserController@dashboard_admin');
Route::get('/user/dashboard_user', 'UserController@dashboard_user');

Route::resource('user', 'UserController');
Route::get('/user', 'UserController@index');
Route::get('/user/(:number)/delete', 'UserController@destroy');

Route::resource('books', 'BooksController');
Route::get('/', 'BooksController@index');
Route::get('/books/(:number)/delete', 'BooksController@destroy');

Route::dispatch();
?>
