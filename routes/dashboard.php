<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ShopController;
use App\Http\Controllers\Dashboard\ShopProductController;

use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\SaleController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

/****************************** START ADMIN ROUTES ******************************/
Route::Group(['prefix' => 'admin', 'middleware' => ['auth','lang']], function () { 
    Route::prefix('lang')->name('lang.')->group( function () {
        Route::controller(LangController::class)->group( function () {
            Route::get('/ar' ,  'ar')->name('ar');
            Route::get('/en' ,  'en')->name('en');
        });
    });

    

    Route::get('/home', [HomeController::class, 'index'])->name('home');


    Route::get('productDetails/{id}', [ProductController::class, 'details'])->name('product.details');
    Route::get('shopProductsQuantity/{id}', [ShopProductController::class, 'shopProductsQuantity'])->name('shopProductsQuantity');


    //category
    Route::resource('category', CategoryController::class);
    Route::post('categoryDeleteSelected', [CategoryController::class, 'deleteSelected'])->name('category.deleteSelected');
    Route::get('categoryShowNotification/{id}/{notification_id}', [CategoryController::class, 'showNotification'])->name('category.showNotification');



    //product
    Route::resource('product', ProductController::class);
    Route::post('productDeleteSelected', [ProductController::class, 'deleteSelected'])->name('product.deleteSelected');
    Route::get('productShowNotification/{id}/{notification_id}', [ProductController::class, 'showNotification'])->name('product.showNotification');



    //shop
    Route::resource('shop', ShopController::class);
    Route::post('shopDeleteSelected', [ShopController::class, 'deleteSelected'])->name('shop.deleteSelected');
    Route::get('shopShowNotification/{id}/{notification_id}', [ShopController::class, 'showNotification'])->name('shop.showNotification');



    //shopProduct
    Route::resource('shopProduct', ShopProductController::class);
    Route::post('shopProductDeleteSelected', [ShopProductController::class, 'deleteSelected'])->name('shopProduct.deleteSelected');
    Route::get('shopProductShowNotification/{id}/{notification_id}', [ShopProductController::class, 'showNotification'])->name('shopProduct.showNotification');

    Route::get('shopProducts/fetch', [ShopProductController::class, 'fetchDetails'])->name('shopProducts.fetch');
    Route::get('shopProducts/fetchLast', [ShopProductController::class, 'fetchLastDetails'])->name('shopProducts.fetchLast');
    Route::post('shopProducts/store', [ShopProductController::class, 'storeDetails'])->name('shopProducts.store');
    Route::delete('shopProducts/destroy/{id}', [ShopProductController::class, 'destroyDetails'])->name('shopProducts.destroy');


    //roles
    Route::resource('role', RoleController::class);
    Route::post('roleDelete', [RoleController::class, 'delete'])->name('role.delete');



    //user
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('userDeleteSelected', [UserController::class, 'deleteSelected'])->name('user.deleteSelected');
    Route::get('userShowNotification/{id}', [UserController::class, 'showNotification'])->name('user.showNotification');   
    Route::get('userChangeStatus/{id}', [UserController::class, 'changeStatus'])->name('user.changeStatus');



    //customer
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/{id}', [CustomerController::class, 'show'])->name('customer.show');
    Route::post('customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('customer/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('customer/destroy/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    Route::post('customerDeleteSelected', [CustomerController::class, 'deleteSelected'])->name('customer.deleteSelected');
    Route::get('customerShowNotification/{id}', [CustomerController::class, 'showNotification'])->name('customer.showNotification');   
    Route::get('customerChangeStatus/{id}', [CustomerController::class, 'changeStatus'])->name('customer.changeStatus');



    //customer
    // Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    // Route::post('customer/store', [CustomerController::class, 'store'])->name('customer.store');
    // Route::get('customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    // Route::post('customer/update', [CustomerController::class, 'update'])->name('customer.update');
    // Route::delete('customer/destroy', [CustomerController::class, 'destroy'])->name('customer.destroy');
    // Route::post('customerDeleteSelected', [CustomerController::class, 'deleteSelected'])->name('customer.deleteSelected');
    // Route::get('customerShowNotification/{id}/{notification_id}', [CustomerController::class, 'showNotification'])->name('customer.showNotification');



    //sale
    Route::get('sale', [SaleController::class, 'index'])->name('sale.index');
    Route::get('sale/create', [SaleController::class, 'create'])->name('sale.create');
    Route::post('sale/store', [SaleController::class, 'store'])->name('sale.store');
    Route::get('sale/edit/{id}', [SaleController::class, 'edit'])->name('sale.edit');
    Route::post('sale/update', [SaleController::class, 'update'])->name('sale.update');
    Route::delete('sale/destroy', [SaleController::class, 'destroy'])->name('sale.destroy');
    Route::post('saleDeleteSelected', [SaleController::class, 'deleteSelected'])->name('sale.deleteSelected');
    Route::get('saleShowNotification/{id}/{notification_id}', [SaleController::class, 'showNotification'])->name('sale.showNotification');

    Route::get('details/fetch', [SaleController::class, 'fetchDetails'])->name('details.fetch');
    Route::get('details/fetchLast', [SaleController::class, 'fetchLastDetails'])->name('details.fetchLast');
    Route::post('details/store', [SaleController::class, 'storeDetails'])->name('details.store');
    Route::delete('details/destroy/{id}', [SaleController::class, 'destroyDetails'])->name('details.destroy');



    //general routes
    Route::get('show_file/{folder_name}/{photo_name}', [GeneralController::class, 'show_file'])->name('show_file');
    Route::get('download_file/{folder_name}/{photo_name}', [GeneralController::class, 'download_file'])->name('download_file');
    Route::get('allNotifications', [GeneralController::class, 'allNotifications'])->name('allNotifications');
    Route::get('markAllAsRead', [GeneralController::class, 'markAllAsRead'])->name('markAllAsRead');

});
/****************************** END ADMIN ROUTES ******************************/