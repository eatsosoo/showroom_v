<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\VehicleCategoryController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::redirect('/login', '/admin/signin')->name('login');
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

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
    Route::middleware('guest')->group(function () {
        Route::get('/signin', [AuthController::class, 'showLogin'])->name('signin');
        Route::post('/signin', [AuthController::class, 'login'])->name('signin.store');
        Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup');
        Route::post('/signup', [AuthController::class, 'register'])->name('signup.store');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', AdminDashboardController::class)->middleware('permission:dashboard.view')->name('dashboard');

        Route::resource('vehicle-categories', VehicleCategoryController::class)->except('show')->middleware('permission:vehicles.manage');
        Route::resource('vehicles', VehicleController::class)->except('show')->middleware('permission:vehicles.manage');
        Route::resource('post-categories', PostCategoryController::class)->except('show')->middleware('permission:posts.manage');
        Route::resource('posts', PostController::class)->except('show')->middleware('permission:posts.manage');
        Route::resource('banners', BannerController::class)->except('show')->middleware('permission:banners.manage');
        Route::resource('site-settings', SiteSettingController::class)->except('show')->middleware('permission:settings.manage');
        Route::resource('leads', LeadController::class)->only(['index', 'show', 'update', 'destroy'])->middleware('permission:leads.manage');

        Route::get('/roles', [RolePermissionController::class, 'index'])->middleware('permission:roles.manage')->name('roles.index');
        Route::post('/roles', [RolePermissionController::class, 'storeRole'])->middleware('permission:roles.manage')->name('roles.store');
        Route::put('/roles/{role}/permissions', [RolePermissionController::class, 'updateRolePermissions'])->middleware('permission:roles.manage')->name('roles.permissions.update');
        Route::post('/permissions', [RolePermissionController::class, 'storePermission'])->middleware('permission:roles.manage')->name('permissions.store');

        Route::get('/calendar', function () {
            return view('pages.calender', ['title' => __('app.pages.calendar')]);
        })->name('calendar');

        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/form-elements', function () {
            return view('pages.form.form-elements', ['title' => __('app.pages.form_elements')]);
        })->name('form-elements');

        Route::get('/basic-tables', function () {
            return view('pages.tables.basic-tables', ['title' => __('app.pages.basic_tables')]);
        })->name('basic-tables');

        Route::get('/blank', function () {
            return view('pages.blank', ['title' => __('app.pages.blank')]);
        })->name('blank');

        Route::get('/error-404', function () {
            return view('pages.errors.error-404', ['title' => __('app.pages.error_404')]);
        })->name('error-404');

        Route::get('/line-chart', function () {
            return view('pages.chart.line-chart', ['title' => __('app.pages.line_chart')]);
        })->name('line-chart');

        Route::get('/bar-chart', function () {
            return view('pages.chart.bar-chart', ['title' => __('app.pages.bar_chart')]);
        })->name('bar-chart');

        Route::get('/alerts', function () {
            return view('pages.ui-elements.alerts', ['title' => __('app.pages.alerts')]);
        })->name('alerts');

        Route::get('/avatars', function () {
            return view('pages.ui-elements.avatars', ['title' => __('app.pages.avatars')]);
        })->name('avatars');

        Route::get('/badge', function () {
            return view('pages.ui-elements.badges', ['title' => __('app.pages.badges')]);
        })->name('badges');

        Route::get('/buttons', function () {
            return view('pages.ui-elements.buttons', ['title' => __('app.pages.buttons')]);
        })->name('buttons');

        Route::get('/image', function () {
            return view('pages.ui-elements.images', ['title' => __('app.pages.images')]);
        })->name('images');

        Route::get('/videos', function () {
            return view('pages.ui-elements.videos', ['title' => __('app.pages.videos')]);
        })->name('videos');
    });
});
