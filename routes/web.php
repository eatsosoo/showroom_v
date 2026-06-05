<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\VehicleCategoryController;
use App\Http\Controllers\Admin\VehicleController;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.placeholder', ['title' => 'VinFast Hải Phòng']);
})->name('home');

Route::post('/lien-he', function (Request $request) {
    Lead::create($request->validate([
        'vehicle_id' => ['nullable', 'exists:vehicles,id'],
        'type' => ['nullable', 'in:contact,test_drive,quote,service'],
        'name' => ['required', 'string', 'max:191'],
        'phone' => ['required', 'string', 'max:50'],
        'email' => ['nullable', 'email', 'max:191'],
        'city' => ['nullable', 'string', 'max:191'],
        'appointment_at' => ['nullable', 'date'],
        'message' => ['nullable', 'string'],
    ]) + ['type' => $request->input('type', 'contact')]);

    return back()->with('success', 'Thông tin của anh/chị đã được ghi nhận.');
})->name('client.leads.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');

    Route::resource('vehicle-categories', VehicleCategoryController::class)->except('show');
    Route::resource('vehicles', VehicleController::class)->except('show');
    Route::resource('post-categories', PostCategoryController::class)->except('show');
    Route::resource('posts', PostController::class)->except('show');
    Route::resource('banners', BannerController::class)->except('show');
    Route::resource('site-settings', SiteSettingController::class)->except('show');
    Route::resource('leads', LeadController::class)->only(['index', 'show', 'update', 'destroy']);

    Route::get('/calendar', function () {
        return view('pages.calender', ['title' => 'Calendar']);
    })->name('calendar');

    Route::get('/profile', function () {
        return view('pages.profile', ['title' => 'Profile']);
    })->name('profile');

    Route::get('/form-elements', function () {
        return view('pages.form.form-elements', ['title' => 'Form Elements']);
    })->name('form-elements');

    Route::get('/basic-tables', function () {
        return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
    })->name('basic-tables');

    Route::get('/blank', function () {
        return view('pages.blank', ['title' => 'Blank']);
    })->name('blank');

    Route::get('/error-404', function () {
        return view('pages.errors.error-404', ['title' => 'Error 404']);
    })->name('error-404');

    Route::get('/line-chart', function () {
        return view('pages.chart.line-chart', ['title' => 'Line Chart']);
    })->name('line-chart');

    Route::get('/bar-chart', function () {
        return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
    })->name('bar-chart');

    Route::get('/signin', function () {
        return view('pages.auth.signin', ['title' => 'Sign In']);
    })->name('signin');

    Route::get('/signup', function () {
        return view('pages.auth.signup', ['title' => 'Sign Up']);
    })->name('signup');

    Route::get('/alerts', function () {
        return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
    })->name('alerts');

    Route::get('/avatars', function () {
        return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
    })->name('avatars');

    Route::get('/badge', function () {
        return view('pages.ui-elements.badges', ['title' => 'Badges']);
    })->name('badges');

    Route::get('/buttons', function () {
        return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
    })->name('buttons');

    Route::get('/image', function () {
        return view('pages.ui-elements.images', ['title' => 'Images']);
    })->name('images');

    Route::get('/videos', function () {
        return view('pages.ui-elements.videos', ['title' => 'Videos']);
    })->name('videos');
});
