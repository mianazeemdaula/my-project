<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Shop\ShopOrderController;
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

Route::get('/', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'doLogin']);
Route::get('shop/reg', [SignupController::class, 'shopStep1']);
Route::post('shop/reg', [SignupController::class, 'doShopStep1']);
Route::get('shop/reg/cat', [SignupController::class, 'shopStep2']);
Route::post('shop/reg/cat', [SignupController::class, 'doShopStep2']);
Route::get('shop/reg/final', [SignupController::class, 'signup']);
Route::post('shop/reg/final', [SignupController::class, 'doSignup']);

Route::group(['middleware' => ['auth']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('shopdetails', [ShopController::class, 'profile']);
    Route::post('shopdetails', [ShopController::class, 'doProfile']);
    Route::get('shop-reviews', [ShopController::class, 'reviews']);
    Route::get('shop-configuration', [ShopController::class, 'configuration']);
    Route::post('shop-configuration', [ShopController::class, 'doConfiguration']);

    Route::resource('shop/order', ShopOrderController::class);

    Route::view('merchant', 'merchants.dashboard');
    Route::view('admin', 'admin.dashboard');
    Route::view('pending', 'admin.dispatcher.pending');
    Route::view('approved', 'admin.dispatcher.approved');
    Route::view('processing', 'admin.dispatcher.processing');
    Route::view('completed', 'admin.dispatcher.completed');
    Route::view('cancelled', 'admin.dispatcher.cancelled');
    Route::view('approvedmerchant', 'admin.merchant.approvedmerchant');
    Route::view('pendingmerchant', 'admin.merchant.pendingmerchant');
    Route::view('rejectedmerchant', 'admin.merchant.rejectedmerchant');
    Route::view('documentmerchant', 'admin.merchant.documentmerchant');
    Route::view('addmerchant', 'admin.merchant.addmerchant');
    Route::view('orderdetailsmerchant', 'admin.merchant.orderdetailsmerchant');
    Route::view('orderdetails-1merchant', 'admin.merchant.orderdetails-1merchant');
    Route::view('shoplicensemerchant', 'admin.merchant.shoplicensemerchant');
    Route::view('users', 'admin.user.users');
    Route::view('adduser', 'admin.user.adduser');
    Route::view('documents', 'admin.documents');
    Route::view('promocode', 'admin.promocode');
    Route::view('cities', 'admin.cities');
    Route::view('reports', 'admin.reports');
    Route::view('accounting', 'admin.accounting');
    Route::view('notification', 'admin.notification');
    Route::view('orderdetails', 'merchants.orders.orderdetails');
    Route::view('product', 'merchants.products.product');
    Route::view('addcategory', 'merchants.products.addcategory');
    Route::view('editcategory', 'merchants.products.editcategory');
    Route::view('addproduct-1', 'merchants.products.addproduct-1');
    Route::view('addproduct', 'merchants.products.addproduct');
    Route::view('editproduct', 'merchants.products.editproduct');
    Route::view('manageoption', 'merchants.products.manageoption');
    Route::view('addnewaddons-category', 'merchants.products.addnewaddons-category');
    Route::view('addnewaddons', 'merchants.products.addnewaddons');



});

