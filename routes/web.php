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



