<?php

use Illuminate\Support\Facades\Route;

Route::get( 'admin/login-23032001', 'Admin\AuthController@showLogin' );
Route::post( 'admin/login-23032001', 'Admin\AuthController@postLogin' )->name( 'admin.login' );

Route::get( 'error', 'Admin\AuthController@error' )->name( 'admin.error' );

//Admin
Route::group( array( 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'adminCheck' ), function () {
    Route::get( '/dashboard', 'PageController@home' )->name( 'dashboard' );

    Route::resource( '/category', 'CategoryController' );
    Route::get( 'category-search', 'CategoryController@search' )->name( 'category.search' );

    Route::resource( '/product', 'ProductController' );
    Route::get( 'product-search', 'ProductController@search' )->name( 'product.search' );

    Route::get( '/order-pending', 'ProductOrderController@pending' )->name( 'order.pending' );
    Route::get( '/order/{id}', 'ProductOrderController@orderCancel' );
    Route::get( '/order-make-complete/{id}', 'ProductOrderController@makeComplete' )->name( 'order.makeComplete' );
    Route::get( '/order-complete', 'ProductOrderController@complete' )->name( 'order.complete' );

    Route::get( '/customer-list', 'CustomerController@customerList' )->name( 'customer.list' );
    Route::get( '/customer-list-search', 'CustomerController@search' )->name( 'customer.search' );

    Route::get( '/logout', 'AuthController@logout' )->name( 'admin.logout' );
} );

//User
Route::group( array( 'middleware' => 'cartCount' ), function () {
    Route::get( '/login', 'AuthController@showLogin' )->name( 'showLogin' );
    Route::post( '/login', 'AuthController@postLogin' )->name( 'login' );

    Route::get( '/register', 'AuthController@showRegister' )->name( 'showRegister' );
    Route::post( '/register', 'AuthController@postRegister' )->name( 'register' );

    Route::get( '/', 'PageController@home' )->name( 'home' );

    Route::get( '/product-list', 'PageController@productList' );
    Route::get( '/discount-product-list', 'PageController@discountProductList' );
    Route::get( '/product-detail/{slug}', 'PageController@productDetail' )->name( 'productDetail' );
    Route::get( '/product-favourite', 'PageController@productFavourite' );

    Route::get( '/product-add-cart', 'OrderAndCartController@addToCart' )->name( 'addToCart' );
    Route::get( '/product-cart-list', 'OrderAndCartController@cartList' )->name( 'cartList' );
    Route::get( '/product-update-cart', 'OrderAndCartController@updateCart' )->name( 'updateCart' );
    Route::get( '/product-delete-cart', 'OrderAndCartController@deleteCart' );

    Route::get( 'make-order', 'OrderAndCartController@makeOrder' )->name( 'makeOrder' );
    Route::get( 'make-all-order', 'OrderAndCartController@makeAllOrder' )->name( 'makeAllOrder' );

    Route::get( 'message', 'PageController@message' )->name( 'message' );

    Route::get( 'user-profile', 'PageController@userProfile' )->name( 'userProfile' );
    Route::get( 'user-order-history', 'PageController@orderHistory' );
    Route::post( 'chg-user-img', 'PageController@chgUserImg' )->name( 'chgUserImg' );

    Route::get( '/logout', 'AuthController@logout' )->name( 'logout' );
} );
