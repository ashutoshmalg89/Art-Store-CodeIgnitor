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
    return view('page1');
});

Route::post('/login','Page1Controller@doLogin');
Route::post('/logout','Page1Controller@doLogout');
Route::post('/register','Page1Controller@doRegister');

Route::post('/userRegister','Page1Controller@userRegister');

Route::post('/search','Page1Controller@doSearch');
Route::post('/addCart','Page1Controller@addCart');
Route::post('/shopBasket','Page1Controller@shopBasket');

Route::post('/buy','Page1Controller@buy');

Route::get('/Page2',function (){

    return view('Page2');
});


