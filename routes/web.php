<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website publik
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');

Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');
Route::get('/layanan/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/portofolio', [PortfolioController::class, 'index'])->name('portfolios.index');
Route::get('/portofolio/{portfolio}', [PortfolioController::class, 'show'])->name('portfolios.show');

Route::get('/pelatihan', [TrainingController::class, 'index'])->name('trainings.index');
Route::get('/pelatihan/{training}', [TrainingController::class, 'show'])->name('trainings.show');
Route::post('/pelatihan/jadwal/{schedule}/daftar', [TrainingController::class, 'register'])
    ->middleware('throttle:10,1')
    ->name('trainings.register');
Route::get('/pelatihan/pendaftaran/{code}', [TrainingController::class, 'registered'])
    ->middleware('throttle:30,1')
    ->where('code', '[A-Z0-9\-]{8,20}')
    ->name('trainings.registered');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [ContactController::class, 'show'])->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Autentikasi admin
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.attempt');
});
Route::post('/admin/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Panel admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    // Konten halaman
    Route::resource('services', Admin\ServiceController::class)->except('show');
    Route::resource('portfolios', Admin\PortfolioController::class)->except('show');
    Route::resource('testimonials', Admin\TestimonialController::class)->except('show');
    Route::resource('faqs', Admin\FaqController::class)->except('show');
    Route::resource('team', Admin\TeamMemberController::class)->except('show')->parameters(['team' => 'member']);

    // Pelatihan, jadwal & pendaftar
    Route::resource('trainings', Admin\TrainingController::class)->except('show');
    Route::get('trainings/{training}/schedules/create', [Admin\ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('trainings/{training}/schedules', [Admin\ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('schedules', [Admin\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('schedules/{schedule}', [Admin\ScheduleController::class, 'show'])->name('schedules.show');
    Route::get('schedules/{schedule}/edit', [Admin\ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('schedules/{schedule}', [Admin\ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('schedules/{schedule}', [Admin\ScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::get('schedules/{schedule}/export', [Admin\ScheduleController::class, 'export'])->name('schedules.export');

    Route::get('registrations', [Admin\RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('registrations/{registration}', [Admin\RegistrationController::class, 'show'])->name('registrations.show');
    Route::put('registrations/{registration}', [Admin\RegistrationController::class, 'update'])->name('registrations.update');
    Route::delete('registrations/{registration}', [Admin\RegistrationController::class, 'destroy'])->name('registrations.destroy');

    // Pesan masuk
    Route::get('messages', [Admin\MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/export', [Admin\MessageController::class, 'export'])->name('messages.export');
    Route::get('messages/{message}', [Admin\MessageController::class, 'show'])->name('messages.show');
    Route::put('messages/{message}', [Admin\MessageController::class, 'update'])->name('messages.update');
    Route::delete('messages/{message}', [Admin\MessageController::class, 'destroy'])->name('messages.destroy');

    // Blog
    Route::resource('posts', Admin\PostController::class)->except('show');

    // Pengaturan & akun
    Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    Route::get('account', [Admin\AccountController::class, 'edit'])->name('account.edit');
    Route::put('account', [Admin\AccountController::class, 'update'])->name('account.update');
    Route::resource('users', Admin\UserController::class)->except(['show']);
});
