<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;



//Route::get('/manage', function () {
    return view('manage');
//});


Route::get('/blog', [BlogController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('/manage', [BlogController::class, 'manage']);
    Route::post('/publish', [BlogController::class, 'publish']);
    Route::delete('/delete/{id}', [BlogController::class, 'delete']);
});



Route::controller(UserAuthController::class)->group(function() 
{
    Route::get("/register", "displayRegisterPage")->middleware("guest");
    Route::get("/login", "displayLoginPage")->name("login")->middleware("guest");
    Route::get("/logout", "logout");

    Route::post("/attempt_register", "registerUser");
    Route::post("/attempt_login", "authenticate");


});