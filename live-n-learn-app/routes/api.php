<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\AvailabilityDatesController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SchoolController;

use App\Http\Controllers\TripController;
use App\Http\Controllers\TripItineraryController;
use App\Http\Controllers\TripImageController;
use App\Http\Controllers\TripFlightController;

use App\Http\Controllers\MasterItineraryController;
use App\Http\Controllers\MasterItineraryIndexController;
use App\Http\Controllers\MasterItineraryImageController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMediaFileController;
use App\Http\Controllers\UserPaymentMethodController;

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\InvoicePaymentController;

use App\Http\Controllers\InboundProgramController;
use App\Http\Controllers\InboundProgramFlightController;

use App\Http\Controllers\MessageController;
use App\Http\Controllers\MediaFileController;

use App\Http\Controllers\UserTripController;
use App\Http\Controllers\FormSignatureController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Version 1 Routes
Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Public Routes
    |--------------------------------------------------------------------------
    */
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [UserController::class, 'forgot_password'])->name('password.email');
    Route::post('reset-password', [UserController::class, 'reset_password'])->name('password.update');

    Route::post('trip_registration/{trip:code}', [UserTripController::class, 'trip_registration']);
    Route::post('resend_registration', [AuthController::class, 'resend_registration']);
    Route::post('enter_registration_key', [AuthController::class, 'enter_registration_key']);

    Route::get('trip/{trip:code}/lookup', [TripController::class, 'code_lookup']);

    Route::get('email_test/{user}/', [UserTripController::class, 'email_test']);

    /*
    |--------------------------------------------------------------------------
    | Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::apiResource('partner', PartnerController::class);
        Route::apiResource('location', LocationController::class)->except(['destroy']);
        Route::apiResource('media_file', MediaFileController::class);
        Route::apiResource('availability_dates', AvailabilityDatesController::class);

        /*
        |--------------------------------------------------------------------------
        | User Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('user', UserController::class);
        Route::apiResource('user/{user}/user_media_file', UserMediaFileController::class)->except(['update']);
        Route::apiResource('user/{user}/user_payment_method', UserPaymentMethodController::class)->except(['update']);

        // GET
        Route::get('profile', [UserController::class, 'profile']);
        Route::get('user_with_trips/{user}', [UserController::class, 'show_with_trips']);
        Route::get('user_with_parent/{user}', [UserController::class, 'show_with_parent']);

        // POST
        Route::post('user/{user}/upload_passport', [UserController::class, 'upload_passport']);

        /*
        |--------------------------------------------------------------------------
        | Airport Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('airport', AirportController::class)->only(['index', 'show']);

        // GET
        Route::get('airport_lookup_code/{code}', [AirportController::class, 'code_lookup']);
        Route::get('airport_lookup_location/{country}/{city?}', [AirportController::class, 'index_by_location']);
        Route::get('airport_lookup_city/{city}/', [AirportController::class, 'index_by_city']);

        Route::get('countries', [AirportController::class, 'list_available_countries']);


        /*
        |--------------------------------------------------------------------------
        | School Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('school', SchoolController::class)->except(['destroy']);

        // GET
        // Route::get('school/{school:code}/lookup', [SchoolController::class, 'code_lookup']);

        // POST
        Route::post('school/{school}/trip/{trip}/assign', [SchoolController::class, 'assign_trip']);

        /*
        |--------------------------------------------------------------------------
        | Trip Routes
        |--------------------------------------------------------------------------
        */
        // API Resources
        Route::apiResource('trip', TripController::class);
        Route::apiResource('trip/{trip}/trip_itinerary', TripItineraryController::class)->except(['destroy']);
        Route::apiResource('trip/{trip}/trip_image', TripImageController::class)->except(['update']);
        Route::apiResource('trip/{trip}/trip_flight', TripFlightController::class);

        // GET
        Route::get('trip/{trip}/departure_flights', [TripFlightController::class, 'index_departure']);
        Route::get('trip/{trip}/return_flights', [TripFlightController::class, 'index_return']);
        Route::get('trip_flights', [TripFlightController::class, 'list_all_flights']);

        // POST
        Route::post('trip/{trip}/activate', [TripController::class, 'generate_code']);
        Route::post('trip/{trip}/update_destinations', [TripController::class, 'update_destinations']);
        Route::post('trip/{trip}/duplicate', [TripController::class, 'duplicate']);
        Route::post('trip/{trip}/itinerary/{master_itinerary}/assign', [TripController::class, 'assign_itinerary']);

        Route::post('trip/{trip}/add_user/{user}', [TripController::class, 'add_user']);
        Route::post('trip/{trip}/remove_user/{user}', [TripController::class, 'remove_user']);

        /*
        |--------------------------------------------------------------------------
        | Master Itinerary Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('master_itinerary', MasterItineraryController::class);
        Route::apiResource('master_itinerary/{master_itinerary}/master_itinerary_index', 
            MasterItineraryIndexController::class)->except(['destroy']);
        Route::apiResource('master_itinerary/{master_itinerary}/master_itinerary_image', 
            MasterItineraryImageController::class)->except(['update']);
        
        // GET
        Route::get('master_itinerary/{master_itinerary:code}/lookup', [MasterItineraryController::class, 'code_lookup']);

        // POST
        Route::post('master_itinerary/{master_itinerary}/duplicate', [MasterItineraryController::class, 'duplicate']);
        Route::post('master_itinerary/{master_itinerary}/update_destinations', [MasterItineraryController::class, 'update_destinations']);

        /*
        |--------------------------------------------------------------------------
        | Inbound Program Routes
        |--------------------------------------------------------------------------
        */
        // API Resources
        Route::apiResource('inbound_program', InboundProgramController::class);
        Route::apiResource('inbound_program/{inbound_program}/inbound_program_flight', InboundProgramFlightController::class);

        // GET
        Route::get('inbound_program/{inbound_program:code}/lookup', [InboundProgramController::class, 'code_lookup']);
        Route::get('inbound_program/{inbound_program}/departure_flights', [InboundProgramFlightController::class, 'index_departure']);
        Route::get('inbound_program/{inbound_program}/return_flights', [InboundProgramFlightController::class, 'index_return']);
        Route::get('inbound_program_flights', [InboundProgramFlightController::class, 'list_all_flights']);

        // POST
        Route::post('inbound_program/{inbound_program}/activate', [InboundProgramController::class, 'generate_code']);
        Route::post('inbound_program/{inbound_program}/add_user/{user}', [InboundProgramController::class, 'add_user']);
        Route::post('inbound_program/{inbound_program}/remove_user/{user}', [InboundProgramController::class, 'remove_user']);

        /*
        |--------------------------------------------------------------------------
        | Invoice Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('invoice', InvoiceController::class);
        Route::apiResource('invoice/{invoice}/invoice_item', InvoiceItemController::class);
        Route::apiResource('invoice/{invoice}/invoice_payment', InvoicePaymentController::class);

        // GET
        Route::get('user/{user}/trip/{trip}/invoice', [InvoiceController::class, 'show_by_trip_user']);
        Route::get('user/{user}/invoice', [InvoiceController::class, 'get_user_invoices']);

        // POST
        Route::post('invoice/{invoice}/make_payment', [InvoiceController::class, 'make_payment']);

        /*
        |--------------------------------------------------------------------------
        | Message Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('message', MessageController::class)->except(['update', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Form Signature Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('user/{user}/trip/{trip}/form_signature', FormSignatureController::class);

    });
});
