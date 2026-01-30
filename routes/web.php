<?php

use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\EventController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\AuthController;
use App\Http\Controllers\Site\TicketController;
use App\Http\Controllers\Site\NewsletterController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');


Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{event}', [EventController::class, 'show'])->name('show');
});



Route::prefix('contact')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'show'])->name('index');
    Route::post('/', [ContactController::class, 'store'])->name('store');
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::post('/create', [CheckoutController::class, 'create'])->name('create');
    Route::get('/{hash}', [CheckoutController::class, 'index'])->name('index');
    Route::post('/{hash}', [CheckoutController::class, 'store'])->name('store');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'store'])->name('register.store');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('my-tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('my-tickets/{registration}', [TicketController::class, 'show'])->name('tickets.show');
});
