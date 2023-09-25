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
// for mail varification just add ----->middleware('auth','verified') [note go also config/fortify and uncomment] =======>
Route::get('redirect',[HomeController::class, 'redirect'])->middleware('auth','verified');


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




//For Stripe payment getwway==========>
Route::get('/stripe/{totalprice}',[HomeController::class, 'stripe']);
//mod this ===== Route::post('stripe', 'stripePost')->name('stripe.post');====>>
Route::post('stripe/{totalprice}',[HomeController::class,'stripePost'])->name('stripe.post');


// for view order as admin =====>
Route::get('/order',[AdminController::class, 'order']);

//For Delivered ========>
Route::get('/delivered/{id}',[AdminController::class, 'delivered']);

//For Download PDF ====> 
Route::get('/print_pdf/{id}',[AdminController::class, 'print_pdf']);


//For Sending Email as admin =====>
Route::get('/send_email/{id}',[AdminController::class, 'send_email']);

//For Sending Email as admin from form ====>
Route::post('/send_user_email/{id}',[AdminController::class, 'send_user_email']);

//For search as admin in Order table ========>
Route::get('/search',[AdminController::class, 'search']);

//Order Show and Cancel =====>
Route::get('/show_order',[HomeController::class, 'show_order']);

//for cancel order=====>
Route::get('/cancel_order/{id}',[HomeController::class, 'cancel_order']);

//for comment =====>
Route::post('/add_comment',[HomeController::class, 'add_comment']);

//for reply ====>
Route::post('/add_reply',[HomeController::class, 'add_reply']);

//Product search ====>
Route::get('/product_search',[HomeController::class, 'product_search']);



//for view product as user in home page ====>
Route::get('products',[HomeController::class, 'products']);
// all Product search ====>
Route::get('/product_search_all',[HomeController::class, 'product_search_all']);
























