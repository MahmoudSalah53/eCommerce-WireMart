<?php

use App\Http\Controllers\AboutShopController;
use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDiscountController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\AdminProductContoller;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\CustomerMainController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterSubCategoryController;
use App\Http\Controllers\OrderConfirmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\SellerMainController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerStoreController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ShowAllProducts;
use App\Http\Controllers\UserController;
use App\Livewire\HomepageComponent;
use App\Models\AboutShop;
use App\Models\Cart;
use App\Models\ShowProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::controller(HomePageController::class)->group(function() {
    Route::get('/', 'index')->name('home');
});
Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/about', [HomePageController::class, 'about'])->name('aboutshop');
Route::get('/terms', [HomePageController::class, 'terms'])->name('termsshop');
Route::get('/products', [HomePageController::class, 'showAllProducts'])->name('all.products');
Route::get('/information/{product}', [ShowProduct::class, 'show'])->name('information.show');
Route::get('/categories/{id}', [HomePageController::class, 'showCategory'])->name('categories.show');

// Locale Controller

Route::get('locale/{lang}', [LocaleController::class, 'setLocale']);

// Route to edit the About page (only accessible to admin)
Route::middleware('auth')->group(function() {
    Route::get('/about/edit', [AboutShopController::class, 'edit'])->name('aboutshop.edit');
    Route::put('/about/update', [AboutShopController::class, 'update'])->name('aboutshop.update');
});


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/order/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
Route::get('/paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('paypal.cancel');

Route::get('/cart/count', function () {
    return response()->json([
        'count' => Auth::check() ? Cart::where('user_id', Auth::id())->count() : 0
    ]);
})->name('cart.count');


Route::get('/admin/dashboard', function () {
    return view('admin.admin');
})->middleware(['auth', 'verified', 'rolemanager:admin'])->name('admin');

// admin routes
Route::middleware(['auth', 'verified', 'rolemanager:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::controller(AdminMainController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('admin');
            Route::get('/settings', 'setting')->name('admin.settings');
            Route::put('/setting/homepagesetting/update', 'update')->name('admin.homepagesetting.update');
            Route::get('/manage/users', 'manage_user')->name('admin.manage.user');
            Route::get('/manage/stores', 'manage_stores')->name('admin.manage.store');
            Route::get('/order/history', 'order_history')->name('admin.order.history');
            Route::get('/profile', 'profile')->name('admin.profile');
            Route::put('/profile/{id}', 'updateProfile')->name('admin.profileupdate');
            Route::put('/password/{id}', 'updatePassword')->name('admin.passwordupdate');
            Route::put('/activate/{id}', 'activate')->name('activate.product');
            Route::put('/updateUser/{id}', 'changeRole')->name('updateUser.user');
            Route::DELETE('/deleteProduct/{id}', 'destroyProduct')->name('delete.product');
            Route::DELETE('/deleteUser/{id}', 'destroyUser')->name('delete.user');
            Route::DELETE('/deleteAccount', 'destroyAccount')->name('delete.account');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('/category/create', 'index')->name('category.create');
            Route::get('/category/manage', 'manage')->name('category.manage');
        });

        Route::controller(SubCategoryController::class)->group(function () {
            Route::get('/subcategory/create', 'index')->name('subcategory.create');
            Route::get('/subcategory/manage', 'manage')->name('subcategory.manage');
        });

        Route::controller(ManagementController::class)->group(function () {
            Route::get('/product/manage', 'productIndex')->name('product.manage');
            Route::get('/user/manage', 'userIndex')->name('user.manage');
            Route::delete('/product/{id}', 'destroyProduct')->name('productAdmin.destroy');
        });

        Route::controller(MasterCategoryController::class)->group(function () {
            Route::post('/store/category', 'storecat')->name('store.cat');
            Route::get('/category/{id}/edit', 'showcat')->name('show.cat');
            Route::put('/category/{id}', 'update')->name('category.update');
            Route::delete('/category/{id}', 'destroy')->name('category.destroy');
        });

        Route::controller(MasterSubCategoryController::class)->group(function () {
            Route::post('/subcategories', 'store')->name('subcategories.store');
            Route::get('/subcategories/{id}/edit', 'show')->name('subcategories.show');
            Route::put('/subcategory/{id}', 'update')->name('subcategory.update');
            Route::delete('/subcategories/{id}', 'destroy')->name('subcategories.destroy');
        });
    });
});

// vendor routes
Route::middleware(['auth', 'verified', 'rolemanager:vendor'])->group(function () {
    Route::prefix('vendor')->group(function () {
        Route::controller(SellerMainController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('vendor');
            Route::get('/order/history', 'orderhistory')->name('vendor.order.history');
            Route::get('/profile', 'profile')->name('vendor.profile');
            Route::put('/profile/{id}', 'updateProfile')->name('vendor.profileupdate');
            Route::put('/password/{id}', 'updatePassword')->name('vendor.passwordupdate');
            Route::DELETE('/deleteAccount', 'destroyAccount')->name('delete.seller');
        });

        Route::controller(SellerProductController::class)->group(function () {
            Route::get('/product/create', 'index')->name('vendor.product');
            Route::get('/product/manage', 'manage')->name('vendor.product.manage');
            Route::post('/product', 'store')->name('products.store');
            Route::get('/product/{id}/edit', 'edit')->name('products.edit');
            Route::put('/product/{id}', 'update')->name('products.update');
            Route::delete('/product/{id}', 'destroy')->name('product.destroy');
        });

        Route::controller(SellerStoreController::class)->group(function () {
            Route::get('/store/create', 'index')->name('vendor.store');
            Route::get('/store/manage', 'manage')->name('vendor.store.manage');
            Route::post('/store', 'store')->name('store.store');
            Route::get('/store/{id}/edit', 'edit')->name('store.edit');
            Route::put('/store/{id}', 'update')->name('store.update');
            Route::delete('/store/{id}', 'destroy')->name('store.destroy');
        });
    });
});

// customer rautes
Route::middleware(['auth', 'verified', 'rolemanager:customer'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::controller(CustomerMainController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
            Route::get('/order/history', 'history')->name('customer.history');
            Route::get('/setting/payment', 'payment')->name('customer.payment');
            Route::get('/profile', 'profile')->name('customer.profile');
            Route::put('/profile/{id}', 'updateProfile')->name('customer.profileupdate');
            Route::put('/password/{id}', 'updatePassword')->name('customer.passwordupdate');
            Route::DELETE('/deleteAccount', 'destroyAccount')->name('delete.customer');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
