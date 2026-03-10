<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StripeController;


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


Route::get('/', [ItemController::class, 'index']);

Route::get('/register', function () {
    return view('auth/register');
});

Route::get('/login', function () {
    return view('auth/login');
})->name('login');;

Route::get('/mypage', [ProfileController::class, 'show'])->middleware('auth');

Route::post('/mypage/profile', [ProfileController::class, 'update']);

Route::get('/item/{item_id}', [ItemController::class, 'show']);
Route::post('/item/{item_id}/like', [ItemController::class, 'like'])
    ->middleware('auth');
Route::post('/item/{item_id}/comments', [CommentController::class, 'store'])
    ->middleware('auth');

Route::get('/go', function () {
    return view('items.create');
});

Route::get('/sell', [ItemController::class, 'sell']);
Route::post('/sell', [ItemController::class, 'list']);

Route::get('/purchase/{item_id}', [PurchaseController::class, 'index']);
Route::post('/purchase/payment/{item}', [PurchaseController::class, 'updatePaymentMethod'])->name('purchase.payment');
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'edit']);
Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'update']);


Route::post('/charge', [StripeController::class, 'charge']);

Route::post('/stripe/webhook', [StripeController::class, 'handle']);


Route::middleware('auth')->group(function () {

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->intended('mypage/profile');
    })->middleware('signed')->name('verification.verify');

    Route::get('/mypage/profile', [ProfileController::class, 'create'])
        ->middleware('verified');

    Route::post('/purchase/{item}', [PurchaseController::class, 'start'])->name('purchase.start');
});
