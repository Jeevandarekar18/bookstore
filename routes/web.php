<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/profile', 'pages.profile')->name('profile');
Route::view('/cart', 'pages.cart')->name('cart');
Route::view('/orders', 'pages.orders')->name('orders');
Route::view('/admin', 'pages.admin')->name('admin.dashboard');
