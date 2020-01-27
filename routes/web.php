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

//  Pages
Route::get('/', 'PageController@index')->name('pages.index');
Route::get('about', 'PageController@about')->name('pages.about');
Route::get('contact', 'PageController@contact')->name('pages.contact');
Route::get('dashboard', 'PageController@dashboard')->name('pages.dashboard');

//  Send contact mail
Route::post('send', 'ContactMailController@send')->name('mail.send');

//  User profile
Route::get('profile', 'ProfileController@show')->name('profiles.index');
Route::get('profile/edit', 'ProfileController@edit')->name('profiles.edit');
Route::post('profile/update', 'ProfileController@update')->name('profiles.update');

//  Posts
Route::get('posts/create', 'PostController@create')->name('posts.create');
Route::post('posts', 'PostController@store');
Route::get('posts/{slug}/edit', 'PostController@edit')->where('slug', '[0-9a-zA-Z-]+')->name('posts.edit');
Route::patch('posts/{slug}', 'PostController@update')->where('slug', '[0-9a-zA-Z-]+');
Route::delete('posts/{slug}', 'PostController@destroy')->where('slug', '[0-9a-zA-Z-]+');
Route::get('posts', 'PostController@index')->name('posts.index');
Route::get('posts/{slug}', 'PostController@show')->where('slug', '[0-9a-zA-Z-]+')->name('posts.show');

//  Categories
Route::get('categories', 'CategoryController@index')->name('categories.index');
Route::get('categories/{id}', 'CategoryController@show')->name('categories.show');
Route::post('categories', 'CategoryController@store')->name('categories.store');
Route::get('categories/{id}/edit', 'CategoryController@edit')->name('categories.edit');
Route::patch('categories/{id}', 'CategoryController@update')->name('categories.update');
Route::delete('categories/{id}', 'CategoryController@destroy')->name('categories.destroy');

//  Tags
Route::get('tags', 'TagController@index')->name('tags.index');
Route::get('tags/{id}', 'TagController@show')->name('tags.show');
Route::post('tags', 'TagController@store')->name('tags.store');
Route::get('tags/{id}/edit', 'TagController@edit')->name('tags.edit');
Route::patch('tags/{id}', 'TagController@update')->name('tags.update');
Route::delete('tags/{id}', 'TagController@destroy')->name('tags.destroy');

// Comments
Route::post('comments', 'CommentController@store')->name('comments.store');
Route::get('comments/{id}/edit', 'CommentController@edit')->name('comments.edit');
Route::patch('comments/{id}', 'CommentController@update')->name('comments.update');
Route::delete('comments/{id}', 'CommentController@destroy')->name('comments.destroy');


Auth::routes(['verify' => true]);

