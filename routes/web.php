<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// For Admin and User Login ====>
Route::get('redirect',[HomeController::class, 'redirect']);


// catagory page ====>
Route::get('/view_catagory',[AdminController::class, 'view_catagory']);

// add catagory ====>
Route::post('/add_catagory',[AdminController::class, 'add_catagory']);

// Delete catagory ====>
Route::get('/delete_catagory/{id}',[AdminController::class, 'delete_catagory']);

// Add Product ====>
Route::get('/view_product',[AdminController::class, 'view_product']);

//add product ====>
Route::post('/add_product',[AdminController::class, 'add_product']);

//Show product as admin ====>
Route::get('/show_product',[AdminController::class, 'show_product']);

//Delete Product as Admin ===>
Route::get('/delete_product/{id}',[AdminController::class, 'delete_product']);

//Update product as Admin ====>
Route::get('/update_product/{id}',[AdminController::class, 'update_product']);

//Update product as Admin ====>
Route::post('/edit_product/{id}',[AdminController::class, 'edit_product']);

// product Detais ====>
Route::get('product_details/{id}',[HomeController::class, 'product_details']);

//add to cart ====>
Route::post('/add_cart/{id}',[HomeController::class, 'add_cart']);

//show to cart ====>
Route::get('/show_cart',[HomeController::class, 'show_cart']);

//remove cart product as user ====>
Route::get('remove_cart/{id}',[HomeController::class, 'remove_cart']);

//cash order ================>>
Route::get('/cash_order',[HomeController::class, 'cash_order']);
















