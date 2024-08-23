<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;

Route::namespace('App\Http\Controllers\API')->middleware([])->group(function() {
    Route::prefix('posts')->group(function() {
        Route::get('/{blog_id?}', 'BlogController@getData');        
        Route::post('/{blog_id?}', 'BlogController@saveBlog');
    });
});    
    