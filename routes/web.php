<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Test email route – sends a test email to amit.owninfotech@gmail.com (remove or protect in production)
Route::get('/testemail', function () {
    $to = 'amit.owninfotech@gmail.com';
    try {
        Mail::raw(
            'This is a test email from your Wedding Event project. If you received this, mail is working correctly.' . "\n\n" .
            'Sent at: ' . now()->toDateTimeString() . "\n" .
            'APP_ENV: ' . config('app.env') . "\n" .
            'MAIL_MAILER: ' . config('mail.default'),
            function ($message) use ($to) {
                $message->to($to)
                    ->subject('Wedding Event – Test Email');
            }
        );
        return response()->view('testemail-result', ['success' => true, 'to' => $to], 200);
    } catch (\Exception $e) {
        \Log::error('Test email failed: ' . $e->getMessage());
        return response()->view('testemail-result', [
            'success' => false,
            'to' => $to,
            'error' => $e->getMessage(),
        ], 500);
    }
})->name('testemail');

use App\Http\Controllers\PicturesVideosController;

Route::get('/pictures-videos', [PicturesVideosController::class, 'index'])->name('pictures_videos');
Route::get('/pictures-videos/{category}', [PicturesVideosController::class, 'showCategory'])->name('pictures_videos.category');

// Book Appointments Route
use App\Http\Controllers\BookAppointmentsController;
Route::get('/book-appointments', [BookAppointmentsController::class, 'index'])->name('book.appointments');

// Ask the Host (public page; post actions require auth)
use App\Http\Controllers\AskTheHostController;

Route::get('/ask-the-host', [AskTheHostController::class, 'index'])->name('ask.the.host');
Route::post('/ask-the-host/questions', [AskTheHostController::class, 'storeQuestion'])->name('ask.the.host.questions.store')->middleware('auth');
Route::post('/ask-the-host/questions/{query}/replies', [AskTheHostController::class, 'storeReply'])->name('ask.the.host.replies.store')->middleware('auth');

// Local Attractions
use App\Http\Controllers\LocalAttractionsController;

Route::get('/local-attractions', [LocalAttractionsController::class, 'index'])->name('local.attractions');

// Updates by Family
use App\Http\Controllers\UpdatesByFamilyController;

Route::get('/updates-by-family', [UpdatesByFamilyController::class, 'index'])->name('updates.by.family');
Route::post('/updates-by-family', [UpdatesByFamilyController::class, 'store'])->name('updates.by.family.store')->middleware('auth');
Route::patch('/updates-by-family/{update}', [UpdatesByFamilyController::class, 'update'])->name('updates.by.family.update')->middleware('auth');
Route::delete('/updates-by-family/{update}', [UpdatesByFamilyController::class, 'destroy'])->name('updates.by.family.destroy')->middleware('auth');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/profile/update', [AdminDashboardController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/admin/profile/image', [AdminDashboardController::class, 'updateProfileImage'])->name('admin.profile.image');
    Route::post('/admin/users/create', [AdminDashboardController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users/{id}/approve', [AdminDashboardController::class, 'approveUser'])->name('admin.users.approve');
    Route::post('/admin/users/{id}/reject', [AdminDashboardController::class, 'rejectUser'])->name('admin.users.reject');
    Route::post('/admin/media/delete', [AdminDashboardController::class, 'deleteMedia'])->name('admin.media.delete');
    Route::get('/admin/media/download', [AdminDashboardController::class, 'downloadMedia'])->name('admin.media.download');
    Route::post('/admin/page-sections/update', [AdminDashboardController::class, 'updatePageSection'])->name('admin.page-sections.update');

    // Local Attractions (admin)
    Route::post('/admin/local-attractions', [AdminDashboardController::class, 'storeLocalAttraction'])->name('admin.local-attractions.store');
    Route::post('/admin/local-attractions/{id}', [AdminDashboardController::class, 'updateLocalAttraction'])->name('admin.local-attractions.update');
    Route::post('/admin/local-attractions/{id}/delete', [AdminDashboardController::class, 'destroyLocalAttraction'])->name('admin.local-attractions.destroy');

    Route::post('/admin/notes', [AdminDashboardController::class, 'storeNote'])->name('admin.notes.store');
    Route::post('/admin/notes/{id}', [AdminDashboardController::class, 'updateNote'])->name('admin.notes.update');
    Route::post('/admin/notes/{id}/delete', [AdminDashboardController::class, 'destroyNote'])->name('admin.notes.destroy');

    Route::post('/admin/book-appointments/entries', [AdminDashboardController::class, 'storeBookAppointmentEntry'])->name('admin.book-appointments.entries.store');
    Route::post('/admin/book-appointments/entries/{id}', [AdminDashboardController::class, 'updateBookAppointmentEntry'])->name('admin.book-appointments.entries.update');
    Route::post('/admin/book-appointments/entries/{id}/delete', [AdminDashboardController::class, 'destroyBookAppointmentEntry'])->name('admin.book-appointments.entries.destroy');

    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/user/profile/update', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/user/profile/image', [UserDashboardController::class, 'updateProfileImage'])->name('user.profile.image');
    
    // Media upload route
    Route::post('/pictures-videos/{category}/upload', [PicturesVideosController::class, 'uploadMedia'])->name('pictures_videos.upload');
    // Serve image/video inline (auth required – used for gallery display so URLs require login)
    Route::get('/pictures-videos/serve/{mediaId}/{type}/{index}', [PicturesVideosController::class, 'serveMedia'])->name('pictures_videos.serve');
    // Download image/video (auth required)
    Route::get('/pictures-videos/download/{mediaId}/{type}/{index}', [PicturesVideosController::class, 'downloadMedia'])->name('pictures_videos.download');
});
