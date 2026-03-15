<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserAuthController;

// Root redirects to blog to be helpful
Route::get('/', function () {
    return redirect('/blog');
});

// Public Blog Route
Route::get('/blog', [BlogController::class, 'index']);

// Protected Routes (User MUST be logged in)
Route::middleware(['auth'])->group(function () {
    Route::get('/manage', [BlogController::class, 'manage']);
    
    // The single route handling BOTH publish and save buttons
    Route::post('/manage/process', [BlogController::class, 'processForm']);
    
    // Deleting published articles
    Route::delete('/delete/{id}', [BlogController::class, 'delete']);
    
    // Logout
    Route::get('/logout', [UserAuthController::class, 'logout']); 
    
    // Snapshot Routes (Moved inside auth so they are protected)
    Route::get('/snapshot/load/{id}', [BlogController::class, 'loadSnapshot']);
    Route::get('/snapshot/delete/{id}', [BlogController::class, 'deleteSnapshot']);
});

// Guest Routes (User MUST NOT be logged in)
Route::middleware(['guest'])->controller(UserAuthController::class)->group(function() 
{
    Route::get("/register", "displayRegisterPage");
    Route::get("/login", "displayLoginPage")->name("login"); 
    Route::post("/attempt_register", "registerUser");
    Route::post("/attempt_login", "authenticate");
});