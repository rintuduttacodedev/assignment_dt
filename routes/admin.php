<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->middleware('auth','url_access:admin')->group(function() {
    Route::get('/dashboard', 'Dashboard@index')->name('home');
    Route::prefix('blog')->name('blog.')->group(function() {        
        Route::get('/', 'BlogController@index')->name('list');
        Route::match(['get','post'],'request/{action_type}/{blog_id?}', 'BlogController@handleRequest')->name('request_control');
        // Route::get('/edit', 'BlogController@index')->name('edit');
        // Route::get('/delete', 'BlogController@index')->name('delete');        
        Route::get('/appprove/{id}', 'BlogController@index')->name('delete');
    });
});    
    