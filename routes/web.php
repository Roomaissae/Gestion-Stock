<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Log;

Route::get('/',[dashboardController::class,'index'])->name('dashboard');

//Liste des produits
Route::resource('products', ProductController::class);
//ajouter & supprime & modifier produits
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/api/products/{product}', [ProductController::class, 'show'])->name('api.products.show');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
//Produit par categories
Route::get('products.bycat', [CategoryController::class, 'productsByCategory'])->name('products.bycat');
Route::get('products.bycat/{category}', [CategoryController::class, 'getProductsByCategory'])->name('products.filter.by.category');

//liste des fournisseurs
Route::resource('suppliers', SuppliersController::class);
//Produits par fournisseur
Route::get('/products-by-supplier', [dashboardController::class, 'productsBySupplier'])->name('products.by.supplier');
Route::get('/api/products-by-supplier/{supplier}', [dashboardController::class, 'getProductsBySupplier'])->name('api.products.by.supplier');

//Liste coustumers
Route::resource('customers', CustomerController::class);
//recherche a un customer
Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
Route::get('/api/customers/search/{term}', [CustomerController::class, 'searchTerm'])->name('customers.search.term');
//ajouter & supprime & modifier customer:
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
Route::get('/customers/{customer}/delete', [CustomerController::class, 'delete'])->name('customers.delete');
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

// Products by Store routes
Route::get('/products-by-store', [dashboardController::class, 'productsByStore'])->name('products.by.store');
Route::get('/api/products-by-store/{store}', [dashboardController::class, 'getProductsByStore'])->name('api.products.by.store');
//mailing
Route::get('/send-mail', [MailController::class, 'index']);

//session & cookie
Route::post("/saveCookie", [dashboardController::class, 'saveCookie'])->name("saveCookie");
Route::post("/saveSession", [dashboardController::class, 'saveSession'])->name("saveSession");
Route::post('/saveAvatar', [DashboardController::class, 'saveAvatar'])->name('saveAvatar');
//Authentification
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//mot de pass oublie
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
//changer langue :
Route::get('/changeLocale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'es', 'fr', 'ar'])) {
        Log::info('Current locale: ' . ($locale ?? 'not set'));
        session()->put('locale', $locale);
        Log::info('Current session: ' . (session('locale') ?? 'not set'));
     }
    return redirect()->back();
});

//Export 
Route::get('products-export', [ProductController::class, 'export'])->name('products.export');
//import 
Route::post('products-import', [ProductController::class, 'import'])->name('products.import');