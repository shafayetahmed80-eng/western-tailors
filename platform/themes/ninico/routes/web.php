<?php

use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;
use Theme\Ninico\Http\Controllers\NinicoController;

Route::group(['controller' => NinicoController::class, 'middleware' => ['web', 'core']], function (): void {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function (): void {
        Route::group(['prefix' => 'ajax', 'as' => 'public.ajax.'], function (): void {
            Route::get('products', 'ajaxGetProducts')->name('products');
            Route::get('cart', 'ajaxCart')->name('cart');
            Route::get('search-products', 'ajaxSearchProducts')->name('search-products');
        });
    });
});

Theme::routes();
