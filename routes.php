<?php

Route::resource('books', 'booksController');
Route::get('/', 'BooksController@index');
Route::get('/books/(:number)/delete','booksController@destroy');



Route::resource('authors', 'AuthorsController');
Route::get('/authors', 'AuthorsController@index');
Route::get('/authors/(:number)/delete','AuthorsController@destroy');


Route::resource('publishers', 'PublishersController');
Route::get('/publishers', 'PublishersController@index');
Route::get('/publishers/(:number)/delete', 'PublishersController@destroy');



Route::dispatch();
?>