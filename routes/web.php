<?php

use App\Livewire\LiveChat;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\SellerEditController;
use App\Http\Controllers\RoleRequestController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminHistoryController;
use App\Http\Controllers\ProductOrderController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\OtpWaVerificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\CmsController;


Route::post('/clear-chats', [ChatController::class, 'clearChats'])->name('clear.chats');




Route::get('/', function () {
    return view('home');
});


Route::get('/tutorial', [TutorialController::class, 'index'])->name('tutorial.index');



// Custom login and registration form route
Route::get('/log-reg', function () {
    return view('auth.log-reg');
})->name('log-reg');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.log-reg');
})->middleware('guest')->name('login');

Route::get('/contact-us', function () {
    return view('contact-us');
});


Route::get('/faq', function () {
    return view('faq');
});
Route::get('/coba', function () {
    return view('coba_wa');
});
Route::get('/product-slider', [ProductController::class, 'showProductSlider'])->name('Product');

Route::get('/categories', function () {
    return view('categories');
});

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/edit-profile', function () {
    return view('edit-profile');
});

Route::get('/seller/seller-edit', [SellerEditController::class, 'index'])->name('seller-edit');

Route::get('/stores', [TokoController::class, 'showStores'])->name('Toko');
Route::get('/search-toko', [TokoController::class, 'search']);
Route::post('/detailed-store', [TokoController::class, 'detailStore'])->name('Detail Toko');

Route::get('/profile-user', function () {
    return view('/profile-user');
});



Route::get('/term-condition', function () {
    return view('term-condition');
});


Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// Registration Routes
Route::get('/register', function () {
    return view('auth.log-reg');
})->middleware('guest')->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');


//send message
Route::post('/send-whatsapp', [RegisteredUserController::class, 'sendMessage'])->name('send.whatsapp');


Route::get('/whatsapp-form', function () {
    return view('auth/send_whatsapp');
});

Route::view('/home', 'home')->name('home');


// ROUTE SELLER PAGE
Route::prefix('seller')->name('seller.')->group(function () {
    Route::resource('products', ProductController::class)->middleware('role:seller');
    Route::resource('products_orders', ProductOrderController::class);
    Route::put('/edit_toko/{id}', [TokoController::class, 'update'])->name('toko.update')->middleware('permission:edit-toko');
    Route::get('/edit_toko/{id}', [TokoController::class, 'edit'])->name('toko.edit')->middleware('permission:edit-toko');
    Route::resource('/seller/seller-edit', ProductController::class);
    Route::delete('/seller-edit/{product}', [ProductController::class, 'destroy'])->name('toko.delete')->middleware('role:seller');
});

// ROUTE ADMIN  PAGE
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/main-admin', [PaymentController::class, 'index'])->name('dashboard-main')->middleware('permission:main-admin');

    Route::get('/dashboard-cms', function () {
        return view('admin.dashboard-cms');
    })->middleware('permission:dasboard-cms');

    Route::resource('users', UserController::class)->middleware('permission:users');

    Route::resource('stores', TokoController::class)->middleware('permission:stores');

    Route::get('/role-requests', [RoleRequestController::class, 'index'])->name('role-requests.index')->middleware('permission:role-requests');

    Route::resource('categories', CategoryController::class)->middleware('role:admin');

    Route::get('/admin/history', [AdminHistoryController::class, 'index'])->name('admin.history.index')->middleware('permission:histories');

    Route::resource('history', AdminHistoryController::class)->middleware('role:admin');

    Route::resource('faqs', FaqController::class)->middleware('permission:faqs');


    Route::get('backups', [BackupController::class, 'index'])->middleware('permission:backups');
    Route::post('backups/manual', [BackupController::class, 'manualBackup'])->name('backups.manual')->middleware('permission:backups');

    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('edit.profile');
    Route::post('/profile/edit', [AdminProfileController::class, 'update'])->name('update.profile');

    Route::get('/company', [CmsController::class, 'index'])->name('company.index');
    Route::get('/company/edit/{id}', [CmsController::class, 'edit'])->name('company.edit');
    Route::post('/company/edit/{id}', [CmsController::class, 'update'])->name('company.update');
});

// Biarkan ini di luar prefix admin
Route::get('/admin/backups/download/{filename}', [BackupController::class, 'downloadBackup'])->name('admin.backups.download');



require __DIR__ . '/auth.php';


Route::get('/dashboard', function () {
    return 'This is the dashboard route.';
})->name('dashboard');


// ROUTES GOOGLE

Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);


//  ruote untuk memeriksa sesi
Route::get('/test-session', function () {
    session(['test' => 'value']);
    return session('test');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/user-edit-profile', [UserProfileController::class, 'edit'])->name('coba.edit');
    Route::get('/edit-profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/edit-profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::delete('/edit-profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Route untuk menampilkan form checkout
    Route::get('/checkout', [CheckoutController::class, 'showCheckoutDetails'])->name('checkout.details');

    // Route untuk menyimpan order
    Route::post('/checkout', [CheckoutController::class, 'storeOrder'])->name('checkout.store');

    // Route untuk menampilkan halaman history
    Route::get('/history', [CheckoutController::class, 'showOrderHistory'])->name('checkout.history');
});
Route::get('/cart/add/{productId}', [CartController::class, 'add'])->name('add.to.cart');
Route::get('/cart/decrement/{productId}', [CartController::class, 'decrement'])->name('decrement.from.cart');
Route::get('/cart/remove/{productId}', [CartController::class, 'remove'])->name('remove.from.cart');

Route::get('/data', [CartController::class, 'data']);

Route::get('/categories', [ProductController::class, 'showProducts'])->name('products.list');
Route::get('/categories/search', [ProductController::class, 'search'])->name('search');

Route::get('/categories', [CategoryController::class, 'showCategories'])->name('categories.index');
// Route::get('/main-admin', [PaymentController::class, 'index'])->name('admin.dashboard-main');


//INI ROLE REQUEST FUNCTION
Route::post('/role-request/approve/{id}', [RoleRequestController::class, 'approve'])->name('role-request.approve');
Route::post('/role-request/cancel/{id}', [RoleRequestController::class, 'cancel'])->name('role-request.cancel');
// Route::post('/role-request/store/{id}', [RoleRequestController::class, 'store'])->name('role-request.store');
Route::post('/role-request/store', [RoleRequestController::class, 'store'])->name('role-request.store');




Route::get('/dashboard-forms', function () {
    return view('admin.dashboard-forms');
});

Route::get('/dashboard-404', function () {
    return view('admin.dashboard-404');
});

Route::get('/dashboard-blank', function () {
    return view('admin.dashboard-blank');
});

Route::get('/dashboard-buttons', function () {
    return view('admin.dashboard-buttons');
});

Route::get('/dashboard-users', function () {
    return view('admin.dashboard-users');
});

Route::get('/dashboard-role', function () {
    return view('admin.dashboard-role');
});

Route::get('/dashboard-profile', function () {
    return view('admin.dashboard-profile');
});
Route::get('/admin-profile', function () {
    return view('admin.edit-profile');
});


Route::get('/card', function () {
    return view('cards');
});


Route::get('/dashboard-toko', function () {
    return view('admin.dashboard-toko');
});

Route::get('/cobain', function () {
    return view('cobain');
});

//OTP
Route::get('/otp', function () {
    return view('auth.otp-verif');
});

Route::get('/lc', function () {
    return view('admin.dashboard-404');
});

Route::post('/verify-wa-otp', [OtpWaVerificationController::class, 'verify'])->name('verify.wa.otp');
Route::get('/resend-otp', [OtpWaVerificationController::class, 'resendOtp'])->name('resend.otp');


Route::post('/save-cart', [CartController::class, 'saveCart'])->name('save-cart');

Route::get('/get-alamat-by-cluster/{id}', [CheckoutController::class, 'getAlamatByCluster']);
Route::get('/get-nomor-by-blok/{blokId}', [CheckoutController::class, 'getNomorByBlok']);

Route::resource('faqs', FaqController::class);

Route::get('/faq', [FaqController::class, 'showFaqPage'])->name('faq.page');


// Live Chat Livewire
Route::get('/live-chat/{user}', LiveChat::class)->name('live-chat');
Route::get('/home', [UserController::class, 'home'])->name('home');
Route::post('/rate-product/{id}', [ProductController::class, 'rateProduct'])->name('rate.product');


Route::delete('/orders/{id}', [CheckoutController::class, 'destroyOrder'])->name('orders.destroy');

Route::delete('/admin/backups/{filename}', [BackupController::class, 'deleteBackup'])->name('admin.backups.delete');


//FORGOT PASSWORD
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot.password');
Route::get('/otp-forgot', function () {
    return view('auth.verify-otp-forgot');
});
Route::get('/reset-password-forgot', function () {
    return view('auth.reset-password-forgot');
})->name('reset-password-forgot');
//1
Route::post('/verify-forgot-otp', [ForgotPasswordController::class, 'verify'])->name('verify.forgot.otp');
//2
Route::get('/resend-otp-forgot', [ForgotPasswordController::class, 'resendOtp'])->name('resend.otp.forgot');

Route::post('/forgot-password-otp', [ForgotPasswordController::class, 'sendOtp'])->name('forgot.password.otp');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');

