<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Requests\HospitalEmailVerificationRequest;
use App\Livewire\Portal\StepOne;
use App\Livewire\Portal\StepTwo;
use App\Livewire\Portal\StepThree;
use App\Livewire\Portal\Dashboard;
use App\Livewire\Portal\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('pages.welcome');
})->name('home');

Route::get('/news', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/news/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');


Route::get('/portal/login', Login::class)
    ->name('portal.login')
    ->middleware('guest:hospital');

Route::post('/portal/login', [AuthController::class, 'login'])
    ->name('portal.login.post')
    ->middleware('guest:hospital');

Route::post('/portal/logout', [AuthController::class, 'logout'])
    ->name('portal.logout')
    ->middleware('auth:hospital');

Route::get('/portal/apply', StepOne::class)
    ->name('portal.apply')
    ->middleware('guest:hospital');

Route::middleware('auth:hospital')->group(function () {

    Route::get('/portal/apply/step-2', StepTwo::class)
        ->name('portal.apply.step2');

    Route::get('/portal/apply/step-3', StepThree::class)
        ->name('portal.apply.step3');

    Route::get('/portal/disqualified', function () {
        return view('portal.disqualified');
    })->name('portal.disqualified');

    Route::get('/portal/dashboard', Dashboard::class)
        ->name('portal.dashboard');

    Route::get('/portal/email/verify', function () {
        return view('portal.verify-email');
    })->middleware('auth:hospital')->name('verification.notice');

    Route::get('/portal/email/verify/{id}/{hash}', function (HospitalEmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('portal.apply.step2')
            ->with('verified', 'Your email has been verified. Please continue your application.');
    })->middleware(['auth:hospital', 'signed'])->name('verification.verify');

    Route::post('/portal/email/resend', function (Request $request) {
        $request->user('hospital')->sendEmailVerificationNotification();
        return back()->with('message', 'A new verification link has been sent to your email address.');
    })->middleware(['auth:hospital', 'throttle:6,1'])->name('verification.send');
});


Route::get('/portal', function () {
    if (Auth::guard('hospital')->check()) {
        return redirect()->route('portal.dashboard');
    }
    return redirect()->route('portal.apply');
})->name('portal');
