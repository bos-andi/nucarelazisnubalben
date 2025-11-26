<?php

use App\Http\Controllers\Admin\AdSenseController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContributorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ImageUploadController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SystemUpdateController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/berita', [SiteController::class, 'news'])->name('news');
Route::get('/program', [SiteController::class, 'programs'])->name('programs');
Route::get('/galeri', [SiteController::class, 'gallery'])->name('gallery');
Route::get('/galeri/{gallery}', [SiteController::class, 'galleryShow'])->name('gallery.show');
Route::get('/kontak', [SiteController::class, 'contact'])->name('contact');
Route::get('/visi-misi', [SiteController::class, 'visiMisi'])->name('visi-misi');
Route::get('/sambutan', [SiteController::class, 'sambutan'])->name('sambutan');
Route::get('/struktur', [SiteController::class, 'struktur'])->name('struktur');
Route::get('/author/{user}', [SiteController::class, 'authorProfile'])->name('author.profile');

// Admin login route (harus sebelum guest middleware)
Route::get('/adminlur', function() {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return app(AuthController::class)->showLoginForm();
})->name('admin.login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Forgot Password Routes
    Route::get('/adminlur/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/adminlur/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')
    ->prefix('dashboard')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('articles', ArticleController::class)->except(['show']);
        Route::resource('gallery', GalleryController::class)->except(['show']);
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {
        Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('admin.upload-image');
    });

Route::middleware(['auth', 'superadmin'])
    ->prefix('dashboard/master-data')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('tags', TagController::class)->except(['show']);
        Route::resource('programs', ProgramController::class)->except(['show']);
    });

Route::middleware(['auth', 'superadmin'])
    ->prefix('dashboard')
    ->name('admin.')
    ->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::get('/adsense', [AdSenseController::class, 'index'])->name('adsense.index');
        Route::put('/adsense', [AdSenseController::class, 'update'])->name('adsense.update');
        
        Route::get('/contributors', [ContributorController::class, 'index'])->name('contributors.index');
        Route::patch('/contributors/{user}/approve', [ContributorController::class, 'approve'])->name('contributors.approve');
        Route::delete('/contributors/{user}/reject', [ContributorController::class, 'reject'])->name('contributors.reject');
        Route::patch('/contributors/{user}/revoke', [ContributorController::class, 'revoke'])->name('contributors.revoke');
        Route::post('/contributors/{user}/reset-password', [ContributorController::class, 'resetPassword'])->name('contributors.reset-password');
        Route::post('/contributors/{user}/change-password', [ContributorController::class, 'changePassword'])->name('contributors.change-password');
        
        // Organization Management
        Route::get('/organization', [OrganizationController::class, 'index'])->name('organization.index');
        Route::put('/organization/welcome', [OrganizationController::class, 'updateWelcome'])->name('organization.update-welcome');
        Route::put('/organization/structure', [OrganizationController::class, 'updateStructure'])->name('organization.update-structure');
        
        // Contact Management
        Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
        Route::put('/contact', [ContactController::class, 'update'])->name('contact.update');
        
        // System Updates (Superadmin only)
        Route::prefix('system-updates')->name('system-updates.')->group(function () {
            Route::get('/', [SystemUpdateController::class, 'index'])->name('index');
            Route::post('/init-repository', [SystemUpdateController::class, 'initRepository'])->name('init-repository');
            Route::post('/add-remote-origin', [SystemUpdateController::class, 'addRemoteOrigin'])->name('add-remote-origin');
            Route::post('/check-updates', [SystemUpdateController::class, 'checkUpdates'])->name('check-updates');
            Route::post('/deploy', [SystemUpdateController::class, 'deploy'])->name('deploy');
            Route::post('/rollback', [SystemUpdateController::class, 'rollback'])->name('rollback');
            Route::get('/{update}/status', [SystemUpdateController::class, 'status'])->name('status');
            Route::get('/{update}/logs', [SystemUpdateController::class, 'logs'])->name('logs');
            Route::delete('/{update}', [SystemUpdateController::class, 'destroy'])->name('destroy');
        });
    });

// Article route harus di paling bawah agar tidak conflict dengan route lain
Route::get('/{article:slug}', [SiteController::class, 'show'])
    ->name('articles.show')
    ->where('article', '^(?!login|register|adminlur|dashboard|berita|program|galeri|kontak|sambutan|struktur|home).*$');
