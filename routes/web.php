<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Display the form to create a new password
Route::view('/', 'create')->name('passwords.create');

// Handle the form submission for creating a new password
Route::post('/passwords', [PasswordController::class, 'store'])->name('passwords.store');

// Display and handle the decryption form
Route::match(['get', 'post'], '/passwords/decrypt', [PasswordController::class, 'show'])->name('passwords.decrypt');
