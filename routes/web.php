<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Yb_AppointmentController;
use App\Http\Controllers\Yb_AdminController;
use App\Http\Controllers\Yb_SettingController;
use App\Http\Controllers\Yb_HomeController;
use App\Http\Controllers\Yb_ServiceController;
use App\Http\Controllers\Yb_AgentController;
use App\Http\Controllers\Yb_GalleryCategoryController;
use App\Http\Controllers\Yb_GalleryImageController;
use App\Http\Controllers\Yb_ClientController;
use App\Http\Controllers\Yb_PageController;
use App\Http\Controllers\Yb_TimeSlotController;
use App\Http\Controllers\Yb_PaymentMethodController;
use App\Http\Controllers\Yb_BannerController;



Route::group(['middleware' => 'protectedPage'], function () {
    // Route::post('/',[Yb_AdminController::class,'yb_index']);
    Route::any('/admin', [Yb_AdminController::class, 'yb_index']);
    Route::get('admin/logout', [Yb_AdminController::class, 'yb_logout']);
    Route::get('admin/dashboard', [Yb_AdminController::class, 'yb_dashboard']);
    Route::post('admin/appointment/get-service-row', [Yb_AppointmentController::class, 'get_service_row']);
    Route::post('admin/appointment/get-service-price', [Yb_AppointmentController::class, 'get_service_price']);
    Route::get('admin/appointment/{id}/print', [Yb_AppointmentController::class, 'print_appointment']);
    Route::post('admin/appointment/change_status', [Yb_AppointmentController::class, 'changeStatus']);
    Route::post('admin/appointment/update_status', [Yb_AppointmentController::class, 'updateStatus']);
    Route::resource('admin/appointment', Yb_AppointmentController::class);
    Route::any('admin/services/homepage_services', [Yb_ServiceController::class, 'homepage_services']);
    Route::resource('admin/services', Yb_ServiceController::class);
    Route::resource('admin/agents', Yb_AgentController::class);
    Route::resource('admin/gallery_cat', Yb_GalleryCategoryController::class);
    Route::resource('admin/gallery_img', Yb_GalleryImageController::class);
    Route::resource('admin/pages', Yb_PageController::class);
    Route::post('admin/client/change_status', [Yb_ClientController::class, 'changeStatus']);
    Route::resource('admin/client', Yb_ClientController::class);
    Route::resource('admin/time_slot', Yb_TimeSlotController::class);
    Route::resource('admin/payment-method', Yb_PaymentMethodController::class);
    Route::post('admin/payment-method/status', [Yb_PaymentMethodController::class, 'changeStatus']);
    Route::any('admin/general-settings', [Yb_SettingController::class, 'yb_general_settings']);
    Route::any('admin/profile-settings', [Yb_SettingController::class, 'yb_profile_settings']);
    Route::post('admin/change-password', [Yb_SettingController::class, 'yb_change_password']);
    Route::any('admin/social-settings', [Yb_SettingController::class, 'yb_social_settings']);
    Route::resource('admin/banner-slider', Yb_BannerController::class);
    Route::post('admin/page_showIn_header', [Yb_PageController::class, 'show_in_header']);
    Route::post('admin/page_showIn_footer', [Yb_PageController::class, 'show_in_footer']);
    Route::get('admin/contact', [Yb_SettingController::class, 'yb_contact']);
    Route::post('admin/contact/{id}', [Yb_SettingController::class, 'yb_Contactview']);
    Route::get('admin/clientbill', [Yb_AppointmentController::class, 'yb_ClientBill']);
    Route::get('admin/report', [Yb_SettingController::class, 'yb_incomeReport']);
});

Route::get('/', [Yb_HomeController::class, 'index']);
Route::post('get-clients', [Yb_HomeController::class, 'yb_get_service_agents']);
Route::any('/services', [Yb_HomeController::class, 'yb_all_services']);
Route::get('/service/{slug}', [Yb_HomeController::class, 'yb_single_service']);
Route::post('/show-newClient-services', [Yb_HomeController::class, 'yb_show_newClient_services']);
Route::get('agents', [Yb_HomeController::class, 'yb_all_agents']);
Route::get('gallery', [Yb_HomeController::class, 'yb_all_gallery']);
Route::get('gallery/{slug}', [Yb_HomeController::class, 'yb_category_gallery']);
Route::get('contact', [Yb_HomeController::class, 'yb_contact']);
Route::post('contact', [Yb_HomeController::class, 'yb_contactStore']);
Route::get('appointment-booking', [Yb_HomeController::class, 'yb_appointment_booking']);
Route::post('appointment', [Yb_HomeController::class, 'yb_create_appointment']);
Route::any('appointment/checkout/status', [Yb_HomeController::class, 'yb_paymentStatus']);
Route::get('appointment/payment/success', [Yb_HomeController::class, 'yb_appointment_payment_success'])->name('payment.success');

Route::get('appointment/paypal/success', [Yb_HomeController::class, 'yb_appointment_success'])->name('paypal.success');
Route::get('appointment/payment/failed', [Yb_HomeController::class, 'yb_appointment_failed'])->name('paypal.cancel');

Route::get('stripe/success', [Yb_HomeController::class, 'stripeSuccess'])->name('stripe.success');
Route::get('stripe/cancel', [Yb_HomeController::class, 'stripeCancel'])->name('stripe.cancel');

Route::get('stripe/appointment/checkout', [Yb_HomeController::class, 'yb_stripe_view']);
Route::get('authorize/appointment/checkout', [Yb_HomeController::class, 'yb_authorizeNet_view']);
Route::get('my_appointment', [Yb_HomeController::class, 'yb_MyAppointment']);
Route::any('change-password', [Yb_ClientController::class, 'yb_change_password']);
Route::any('forgot-password', [Yb_ClientController::class, 'yb_forgot_password']);
Route::post('update-password', [Yb_ClientController::class, 'yb_reset_passwordUpdate']);
Route::get('reset-password', [Yb_ClientController::class, 'yb_reset_password']);
Route::any('login', [Yb_ClientController::class, 'yb_login']);
Route::any('logout', [Yb_ClientController::class, 'yb_logout']);
Route::get('page/{slug}', [Yb_HomeController::class, 'yb_customPage']);
