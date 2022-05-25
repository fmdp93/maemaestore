<?php

use App\Models\User;
use App\Http\Middleware\LoginCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RRController;
use App\Http\Controllers\PINController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SettingsController;
use App\Http\Middleware\InventoryMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Test\CarsController;
use App\Http\Controllers\LogManagerController;
use App\Http\Controllers\Test\LoginController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\CashierAccountsController;
use App\Http\Controllers\CashierProductsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PageUnauthorized;
use App\Http\Controllers\SuppliersController;
use App\Http\Middleware\PinMiddleware;
use App\Http\Middleware\RoleMiddleware;

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


Route::get('/', [IndexController::class, 'index']);
Route::post('/login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth'], function () {
  Route::post('/', [IndexController::class, 'index']);

  Route::get('/unauthorized/admin', [PageUnauthorized::class, 'admin']);
  // Route::group(['middleware' => 'can:do_admin,' . User::class], function () {
  Route::group(['middleware' => RoleMiddleware::class . ':admin'], function () {
    Route::get('/products', [ProductsController::class, 'index']);
    Route::get('/product/{id}', [ProductsController::class, 'getProduct'])
      ->where('id', '[0-9]+');
    Route::get('/products/print-barcode/', [ProductsController::class, 'printBarcode']);
    Route::get('/products/add-product', [ProductsController::class, 'addProduct']);
    Route::get('/product/get-item-code', [ProductsController::class, 'getNewItemCode']);

    Route::post('/product/add', [ProductsController::class, 'store']);
    Route::post('/product/update', [ProductsController::class, 'updateProduct']);
    Route::delete('/product/delete', [ProductsController::class, 'delete']);

    Route::get('/product/search', [ProductsController::class, 'search']);
    Route::get('/products/category/add', [CategoryController::class, 'index']);
    Route::post('/category/add', [CategoryController::class, 'store']);
    Route::delete('/category/delete', [CategoryController::class, 'delete']);

    Route::get('/inventory', [InventoryController::class, 'index'])
      ->middleware(InventoryMiddleware::class);
    Route::post('/inventory/archive', [InventoryController::class, 'archive'])
      ->name('inventory_archive');
    Route::get('/inventory/archives', [InventoryController::class, 'archives'])
      ->name('inventory_archives');
    Route::post('/inventory/unarchive', [InventoryController::class, 'unarchive'])
      ->name('inventory_unarchive');

    // Async
    Route::get('/inventory/archive-search', [InventoryController::class, 'archiveSearch'])
      ->name('inventory_archive_search');

    Route::get('/inventory/orders', [InventoryController::class, 'orders']);
    Route::get('/inventory/purchase-order', [InventoryController::class, 'purchaseOrder']);
    Route::get('/inventory/suppliers', [SuppliersController::class, 'index'])
      ->name('suppliers');
    Route::get('/inventory/suppliers/search', [SuppliersController::class, 'searchSupplier'])
      ->name('search_supplier');

    Route::get('/inventory/add-supplier', [SuppliersController::class, 'add_supplier'])
      ->name('add_supplier');
    Route::post('/inventory/add-supplier/submit', [SuppliersController::class, 'add_supplier_submit'])
      ->name('add_supplier_submit');
    Route::get('/inventory/edit-supplier', [SuppliersController::class, 'edit_supplier'])
      ->name('edit_supplier');
    Route::post('/inventory/edit-supplier/submit', [SuppliersController::class, 'edit_supplier_submit'])
      ->name('edit_supplier_submit');
    Route::delete('/inventory/delete-supplier', [SuppliersController::class, 'delete_supplier'])
      ->name('delete_supplier');

    Route::post('/inventory/order-received', [InventoryController::class, 'orderReceived']);
    Route::post('/inventory/purchase-order-cancel', [InventoryController::class, 'orderCancel'])
      ->name('purchase_order_cancel');
    Route::get('/inventory/order-products', [InventoryController::class, 'orderProducts']);
    Route::post('/inventory/add', [InventoryController::class, 'store']);
    Route::get('/purchase-order/search', [InventoryController::class, 'purchaseOrderSearch']);
    Route::get('/inventory/search', [InventoryController::class, 'inventorySearch']);
    Route::get('/vendor/search', [SuppliersController::class, 'searchVendor']);

    Route::get('/sales-report', [SalesReportController::class, 'index']);
    Route::get('/sales-report/transaction', [SalesReportController::class, 'posTransaction2Product'])
      ->name('pos_transaction2product');

    Route::get('/accounts', [AccountsController::class, 'index']);
    Route::get('/accounts/add-cashier', [AccountsController::class, 'addCashier']);
    Route::post('/accounts/add-cashier/add', [AccountsController::class, 'addCashierSubmit']);
    Route::get('/accounts/edit-account', [AccountsController::class, 'editAccount']);
    Route::post('/accounts/edit-account/save', [AccountsController::class, 'editAccountSave']);
    Route::delete('/accounts/delete-cashier', [AccountsController::class, 'deleteCashier']);

    Route::get('/log-manager/set-pin', [PINController::class, 'setPinFlashAdmin']);

    $pin_mw = PinMiddleware::class;
    $action = action([PINController::class, 'setPinFlashAdmin']);
    Route::group(['middleware' => "$pin_mw:$action"], function () {
      Route::get('/log-manager', [LogManagerController::class, 'index']);
      Route::get('/log-manager/product', [LogManagerController::class, 'product']);
      Route::get('/log-manager/inventory', [LogManagerController::class, 'inventory']);
      Route::get('/log-manager/account', [LogManagerController::class, 'account']);
      Route::get('/log-manager/login', [LogManagerController::class, 'login']);
    });
    Route::get('/log-manager/check-pin', [LogManagerController::class, 'checkPin']);

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/settings/backup-db', [SettingsController::class, 'backupDb'])->name('backup_db');
    Route::post('/settings/restore-db', [SettingsController::class, 'restoreDb'])->name('restore_db');

    Route::get('/switch-user', [UserController::class, 'index']);
  });

  Route::get('/unauthorized/cashier', [PageUnauthorized::class, 'cashier']);
  // Route::group(['middleware' => 'can:do_cashier,' . User::class], function () {
  Route::group(['middleware' => RoleMiddleware::class . ':cashier'], function () {
    Route::get('/pos/set-pin', [PINController::class, 'setPinFlashCashier']);

    Route::get('/pos', [POSController::class, 'index']);
    Route::get('/pos/inventory-search', [POSController::class, 'inventorySearch']);
    Route::get('/pos/get-table-row', [POSController::class, 'getTableRow']);
    Route::post('/pos/checkout', [POSController::class, 'checkout']);
    Route::get('/pos/finish', [POSController::class, 'finish']);
    Route::get('/pos/receipt', [POSController::class, 'receipt']);
    Route::get('/pos/receipt-url', [POSController::class, 'receiptUrl']);

    // Return Refunds routes

    $pin_mw = PinMiddleware::class;
    $action = action([PINController::class, 'setPinFlashCashier']);
    Route::group(['middleware' => "$pin_mw:$action"], function () {
      Route::get('/pos/return-refund', [RRController::class, 'index']);
      Route::post('/pos/return-refund-submit', [RRController::class, 'store']);
    });

    Route::get('/rr/inventory-search', [RRController::class, 'inventorySearch']);
    Route::get('/rr/get-table-row', [RRController::class, 'getTableRow']);

    // Cashier/products
    Route::get('/cashier-products', [CashierProductsController::class, 'index']);
    // Async Requests
    Route::get('/cashier/products/search', [CashierProductsController::class, 'search']);

    Route::get('/cashier-settings', [CashierAccountsController::class, 'editAccount']);
    Route::post('/cashier-settings/update', [CashierAccountsController::class, 'editAccountSave']);

    Route::get('/customer', [CustomerController::class, 'index'])
      ->name('customer');
    Route::get('/customer/add', [CustomerController::class, 'add_customer'])
    ->name('add_customer');
    Route::post('/customer/add_submit', [CustomerController::class, 'add_customer_submit'])
      ->name('add_customer_submit');
    Route::get('/customer/edit', [CustomerController::class, 'edit_customer'])
      ->name('edit_customer');
    Route::post('/customer/edit_submit', [CustomerController::class, 'edit_customer_submit'])
      ->name('edit_customer_submit');
    Route::delete('/customer/delete', [CustomerController::class, 'delete_customer'])
      ->name('delete_customer');
    // Asnyc
    Route::get('/customer/search-for-table', [CustomerController::class, 'searchForTable'])
      ->name('customer_search_for_table');
    Route::get('/customer/search-for-pos', [CustomerController::class, 'searchForPos'])
      ->name('customer_search_for_pos');
  });

  Route::get('/pin/validate-pin', [PINController::class, 'validatePin']);
  Route::post('/pin/submit-pin', [PINController::class, 'submitPin']);
  // Route::get('/settings', [SettingsController::class, 'index']);
  Route::get('/logout', [UserController::class, 'logout']);
});



// Route::get('/login/about', [LoginController::class, 'about']);
// Route::get('/login/{id}', [LoginController::class, 'user'])
//   ->where('id', '\d+');

// // Multiple parameter filtered by pattern
// Route::get('/product/{name}/{brand_id}', [TestController::class, 'product'])
//   ->where([
//     'name' => '[a-zA-Z]+',
//     'brand_id' => '\d+',
//   ])->name('show_product');