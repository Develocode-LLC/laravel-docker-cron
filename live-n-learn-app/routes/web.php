<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;

use App\Mail\UserRegistrationKey;
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

Route::get('{any?}', function() {
    return view('app');
})->where('any', '.*');

Route::get('/reset-password/{token}', function (string $token) {
    return;
})->name('password.reset');

Route::get('mailable', function () {
    $user = User::find(1);
 
    return new UserRegistrationKey($user);
});
