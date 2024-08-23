<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function(){
    return Redirect::to(route('user.home'));
    echo Hash::make('Assi1234@');
})->name('home');

Route::prefix('user')->name('user.')->namespace('App\Http\Controllers')->middleware('auth','url_access:user')->group(function() {
    Route::get('/home', 'Dashboard@index')->name('home');
    /*Route::prefix('blog')->name('blog.')->group(function() {        
        Route::get('/', 'BlogController@index')->name('list');
        Route::match(['get','post'],'request/{action_type}/{blog_id?}', 'BlogController@handleRequest')->name('request_control');
        // Route::get('/edit', 'BlogController@index')->name('edit');
        // Route::get('/delete', 'BlogController@index')->name('delete');        
        Route::get('/appprove/{id}', 'BlogController@index')->name('delete');
    });*/
});