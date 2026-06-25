<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\TeacherCompetitionController;
use App\Http\Controllers\GradingController;

use App\Http\Controllers\StudentArtworkController;
use App\Http\Controllers\StudentPortfolioController;
use App\Http\Controllers\StudentCertificateController;

use App\Http\Controllers\AdminTemplateController;

use App\Http\Controllers\DeactivationRequestController;
use App\Http\Controllers\AccountDeactivationController;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminPaymentController;


/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/manual', fn() => view('manual'))->name('manual');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect (Role-Based)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        'admin'     => redirect()->route('admin.dashboard'),
        'teacher'   => redirect()->route('teacher.dashboard'),
        'caregiver' => redirect()->route('caregiver.dashboard'),
        default     => redirect()->route('student.dashboard'),
    };

})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Global Notifications Route
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::post('/notifications/{id}/read', function ($id) {

        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return back();

    })->name('notifications.read');

});


/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/verify-email/{id}/{hash}', function (EmailVerificationRequest $request) {

    $request->fulfill();

    return redirect()->route('dashboard');

})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');

})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/profile/password', [ProfileController::class, 'editPassword'])
        ->name('profile.password.edit');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');

    Route::post('/request-deactivation', [DeactivationRequestController::class, 'request'])
        ->name('request.deactivation');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'index'])
            ->name('dashboard');

        Route::resource('users', AdminUserController::class)
            ->except(['show']);

        Route::post('/users/{id}/unlock', [AdminUserController::class, 'unlock'])
            ->name('users.unlock');

        Route::put('/users/{id}/assign-caregiver', [AdminUserController::class, 'assignCaregiver'])
            ->name('users.assignCaregiver');

        Route::resource('competitions', CompetitionController::class);

        Route::patch('/competitions/{id}/cancel',
            [CompetitionController::class, 'cancel']
        )->name('competitions.cancel');

        Route::get('/grading', [GradingController::class, 'index'])
            ->name('grading.index');

        Route::get('/grading/{id}/edit', [GradingController::class, 'edit'])
            ->name('grading.edit');

        Route::put('/grading/{id}', [GradingController::class, 'update'])
            ->name('grading.update');

        Route::post('/grading/generate/{id}', [GradingController::class, 'generate'])
            ->name('grading.generate');

        Route::get('/templates', [AdminTemplateController::class, 'index'])
            ->name('templates.index');

        Route::post('/templates', [AdminTemplateController::class, 'update'])
            ->name('templates.update');

        Route::get('/deactivation-requests', [AccountDeactivationController::class, 'index'])
            ->name('deactivation.index');

        Route::post('/deactivation/approve/{id}', [AccountDeactivationController::class, 'approve'])
            ->name('deactivation.approve');

        Route::post('/deactivation/reactivate/{id}', [AccountDeactivationController::class, 'reactivate'])
            ->name('deactivation.reactivate');

        Route::get('/payments', [AdminPaymentController::class, 'index'])
            ->name('payments.index');

        Route::delete('/payments/{id}', [AdminPaymentController::class, 'destroy'])
            ->name('payments.destroy');
    });


/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role.teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        Route::get('/', [TeacherController::class, 'index'])
            ->name('dashboard');

        Route::resource('competitions', TeacherCompetitionController::class);

        Route::get('/grading', [GradingController::class, 'index'])
            ->name('grading.index');

        Route::get('/grading/{id}/edit', [GradingController::class, 'edit'])
            ->name('grading.edit');

        Route::put('/grading/{id}', [GradingController::class, 'update'])
            ->name('grading.update');

        Route::post('/grading/generate/{id}', [GradingController::class, 'generate'])
            ->name('grading.generate');
    });


/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role.student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/', [StudentDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/competitions', [CompetitionController::class, 'index'])
            ->name('competitions.index');

        Route::get('/competitions/{id}', [CompetitionController::class, 'show'])
            ->name('competitions.show');

        Route::get('/artworks', [StudentArtworkController::class, 'index'])
            ->name('artworks.index');

        Route::get('/artworks/create', [StudentArtworkController::class, 'create'])
            ->name('artworks.create');

        Route::post('/artworks', [StudentArtworkController::class, 'store'])
            ->name('artworks.store');

        Route::get('/portfolio', [StudentPortfolioController::class, 'index'])
            ->name('portfolio.index');

        Route::post('/portfolio', [StudentPortfolioController::class, 'store'])
            ->name('portfolio.store');

        Route::get('/portfolio/{id}/edit', [StudentPortfolioController::class, 'edit'])
            ->name('portfolio.edit');

        Route::put('/portfolio/{id}', [StudentPortfolioController::class, 'update'])
            ->name('portfolio.update');

        Route::delete('/portfolio/{id}', [StudentPortfolioController::class, 'destroy'])
            ->name('portfolio.destroy');

        Route::get('/certificates', [StudentCertificateController::class, 'index'])
            ->name('certificates.index');

        Route::get('/checkout/{id}', [PaymentController::class, 'checkout'])
            ->name('checkout');

        Route::get('/payment/success/{id}', [PaymentController::class, 'success'])
            ->name('payment.success');

        Route::get('/payment/cancel/{id}', [PaymentController::class, 'cancel'])
            ->name('payment.cancel');

        Route::get('/receipt/{id}', [PaymentController::class, 'showReceipt'])
            ->name('receipt');
    });


/*
|--------------------------------------------------------------------------
| Caregiver Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role.caregiver'])
    ->prefix('caregiver')
    ->name('caregiver.')
    ->group(function () {

        Route::get('/', [CaregiverController::class, 'index'])
            ->name('dashboard');

        Route::get('/children', [CaregiverController::class, 'children'])
            ->name('children');

        Route::get('/children/{id}', [CaregiverController::class, 'showChild'])
            ->name('children.show');

        Route::get('/submissions', [CaregiverController::class, 'submissions'])
            ->name('submissions');

        Route::get('/submissions/{id}', [CaregiverController::class, 'studentSubmissions'])
            ->name('submissions.show');

        Route::get('/certificates', [CaregiverController::class, 'certificates'])
            ->name('certificates');

        Route::get('/certificates/{id}', [CaregiverController::class, 'studentCertificates'])
            ->name('certificates.show');

        Route::get('/performance/{id}', [CaregiverController::class, 'performance'])
            ->name('performance');
    });


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';