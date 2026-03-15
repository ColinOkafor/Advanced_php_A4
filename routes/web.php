<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserAuthController; // Added missing import

// Root redirects to blog to be helpful
Route::get('/', function () {
    return redirect('/blog');
});

// Public Blog Route
Route::get('/blog', [BlogController::class, 'index']);

// Protected Routes (User MUST be logged in)
// If they aren't, Laravel automatically redirects to the 'login' named route.
Route::middleware(['auth'])->group(function () {
    Route::get('/manage', [BlogController::class, 'manage']);
    Route::post('/publish', [BlogController::class, 'publish']);
    Route::delete('/delete/{id}', [BlogController::class, 'delete']);
    Route::get('/logout', [UserAuthController::class, 'logout']); // Moved logout here
});

// Guest Routes (User MUST NOT be logged in)
// If they are logged in, Laravel automatically redirects them away.
Route::middleware(['guest'])->controller(UserAuthController::class)->group(function() 
{
    Route::get("/register", "displayRegisterPage");
    Route::get("/login", "displayLoginPage")->name("login"); // 'name' is required for the auth middleware redirect
    Route::post("/attempt_register", "registerUser");
    Route::post("/attempt_login", "authenticate");
});