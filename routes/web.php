<?php

	use App\Http\Controllers\AdminController;
	use App\Http\Controllers\ApplicationController;
	use App\Http\Controllers\Auth\AuthenticatedSessionController;
	use App\Http\Controllers\CategoryController;
	use App\Http\Controllers\ForgotPasswordController;
	use App\Http\Controllers\FreelancerDashboardController;
	use App\Http\Controllers\IndexController;
	use App\Http\Controllers\LoginController;
	use App\Http\Controllers\OtpController;
	use App\Http\Controllers\RatingController;
	use App\Http\Controllers\RegisterController;
	use App\Http\Controllers\ServiceController;
	use App\Http\Controllers\MessageController;
	use Illuminate\Support\Facades\Route;


	Route::get('/contacts', function () {
		return view('contacts');
	});

	//General Routes
	Route::get('/', [IndexController::class, 'index']);
	Route::get('/otp', [OtpController::class, 'showForm'])->name('otp.form');
	Route::post('/otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');
	Route::post('/otp-resend', [OtpController::class, 'resendOtp'])->name('otp.resend');
	Route::get('/search', [ServiceController::class, 'search'])->name('services.search');
	Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
	Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
	Route::get('freelancer/{id}', [ServiceController::class, 'services'])->name('freelancer.services');
	Route::get('/creators', [FreelancerDashboardController::class, 'creator'])->name('creators.index');

	//Pasword Resets
	Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
	Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
	Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
	Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

	//Authentication Routes
	Route::get('/login', [LoginController::class, 'index'])->name('login');
	Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('login');
	Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
	Route::get('/register', [RegisterController::class, 'index']);
	Route::post('/register', [RegisterController::class, 'register']);

	//Authenticable Roots
	Route::middleware(['auth'])->group(function () {
		Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.view');
		Route::patch('/applications/{id}', [ApplicationController::class, 'complete'])->name('applications.update');
		Route::post('/apply', [ApplicationController::class, 'apply'])->name('applications.apply');
		Route::delete('/my/{application}', [ApplicationController::class, 'cancel'])->name('applications.cancel');
		Route::post('/rate', [RatingController::class, 'store'])->name('ratings.store');
		Route::get('/profile', [RegisterController::class, 'profile'])->name('profile');
		Route::patch('/profile/{id}', [RegisterController::class, 'update'])->name('profile.edit');
		Route::get('/my', [ServiceController::class, 'my'])->name('services.my');
		Route::get('/chat/{user}', [MessageController::class, 'show'])->name('chat.show');
		Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
		Route::post('/messages/mark-as-read', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');
		Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
	});

	//Admin Routes
	Route::middleware(['auth', 'admin'])->group(function () {
		Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
		Route::patch('freelancers/{id}/verify', [AdminController::class, 'verify'])->name('admin.verify');
		Route::patch('freelancers/{id}/revoke', [AdminController::class, 'revoke'])->name('admin.revoke');
		Route::patch('freelancers/{id}/suspend', [AdminController::class, 'suspend'])->name('admin.suspend');
		Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
		Route::post('/admin/notify', [AdminController::class, 'createService'])->name('admin.create');
		Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
		Route::delete('admin/category/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');
		Route::patch('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
		Route::patch('/admin/services/{id}/feature', [ServiceController::class, 'feature'])->name('admin.feature');
		Route::patch('/admin/services/{id}/removeFeature', [ServiceController::class, 'removeFeature'])->name('admin.removeFeature');

	});

	//Freelancer Routes
	Route::middleware(['auth', 'freelancer'])->group(function () {
//		Route::get('/services/create', [ServiceController::class, 'create']);
		Route::post('/services/store', [ServiceController::class, 'store'])->name('services.store');
		Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->can('edit', 'service')->name('services.edit');
		Route::patch('/services/{service}', [ServiceController::class, 'update'])->can('edit', 'service')->name('services.update');
		Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

	});
