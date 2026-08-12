<?php

use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\Web\Api\BookController;
use App\Http\Controllers\Web\Api\CategoryController;
use App\Http\Controllers\Web\Api\ContactUsController;
use App\Http\Controllers\Web\Api\SubscriberController;
use App\Models\AboutUs;
use App\Models\Subscriber;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Route;

// Site Info
Route::get('/site/info', function () {
    $query = SystemSetting::query();

    $data = $query->select(
        'system_title',
        'system_short_title',
        'logo',
        'favicon',
        'banner_image',
        'banner_title',
        'banner_description',
        'contact_description',
        'copyright_text'
    )->first();

    if ($data) {
        $data->logo = asset($data->logo);
        $data->favicon = asset($data->favicon);
        $data->banner_image = asset($data->banner_image);
    }

    return response()->json(['success' => true, 'data' => $data], 200);
});

// About Us Info
Route::get('/aboutUs', function () {
    $data = AboutUs::select('title', 'description', 'image')->first();

    if ($data) {
        $data->image = asset($data->image); // convert image path to URL
    }

    return response()->json(['success' => true, 'data' => $data], 200);
});

// Category List
Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'category');
});

// Book List
Route::controller(BookController::class)->group(function () {
    Route::get('/book', 'book');
    Route::get('/book/{id}', 'book_details');
});

// Contact Us
Route::controller(ContactUsController::class)->group(function () {
    Route::post('/contact-us', 'contactUs');
});

// Subscribe Us
Route::controller(SubscriberController::class)->group(function () {
    Route::post('/subscribe-us', 'subscribeUs');
});




// Route::controller(UserAuthController::class)->group(function () {
//     Route::post('login', 'login');
//     Route::post('register', 'register');

//     // Resend Otp
//     Route::post('resend-otp', 'resendOtp');

//     // Forget Password
//     Route::post('forget-password', 'forgetPassword');
//     Route::post('verify-otp-password', 'varifyOtpWithOutAuth');
//     Route::post('reset-password', 'resetPassword');

//     // Google Login
//     Route::post('google/login', 'googleLogin');
// });

