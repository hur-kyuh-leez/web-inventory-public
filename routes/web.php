<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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

Auth::routes();



Route::get('/react', 'ReactController@index')->name('react');



// /으로오면 homecontroller에서 알하서 하고 이건 닉네임은 home이라 지정한다. 그리고 여길 들어가려면 미들웨어(auth)를 거쳐야 한다. name을 먼저 정해야지 미들웨어를 먼저 거치면 닉네임이 안적힌다.
Route::get('/', 'HomeController@index')->name('home')->middleware('auth')->middleware('approved');


// ::group 키워드는 모두 적용 하고 싶은 게 있을 때 쓴다. 여기 같은 경우 항상 승인 되어야 들어 갈 수 있게 만든다.

//Route::group(['middleware' => 'auth', 'prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}']], function () {
Route::group(['middleware' => 'auth'], function () {

    Route::get('/approval', 'HomeController@approval')->name('approval');
    Route::get('/notAdmin', 'HomeController@notAdmin')->name('notAdmin');

    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::match(['put', 'patch'], 'profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::match(['put', 'patch'], 'profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    Route::middleware(['adminState'])->group(function () {
        Route::resources([
            'users' => 'UserController',
            ]);
    });

    Route::middleware(['approved'])->group(function () {


        Route::resources([
            'providers' => 'ProviderController',
            'inventory/products' => 'ProductController',
            'clients' => 'ClientController',
            'inventory/categories' => 'ProductCategoryController',
            'transactions/transfer' => 'TransferController',
            'methods' => 'MethodController',
        ]);

        Route::resource('transactions', 'TransactionController')->except(['create', 'show']);
        Route::get('transactions/stats/{year?}/{month?}/{day?}', ['as' => 'transactions.stats', 'uses' => 'TransactionController@stats']);
        Route::get('transactions/{type}', ['as' => 'transactions.type', 'uses' => 'TransactionController@type']);
        Route::get('transactions/{type}/create', ['as' => 'transactions.create', 'uses' => 'TransactionController@create']);
        Route::get('transactions/{transaction}/edit', ['as' => 'transactions.edit', 'uses' => 'TransactionController@edit']);

        Route::get('inventory/stats/{year?}/{month?}/{day?}', ['as' => 'inventory.stats', 'uses' => 'InventoryController@stats']);



//        Route::resource('inventory/receipts', 'ReceiptController')->except(['edit', 'update']); // 여기서 edit 바꾸면 되나?
        Route::resource('inventory/receipts', 'ReceiptController')->except(['edit','update']); // 여기서 edit 바꾸면 되나?
        Route::get('inventory/receipts/{receipt}/edit', ['as' => 'receipts.edit', 'uses' => 'ReceiptController@edit']);
        Route::get('inventory/receipts/{receipt}/finalize', ['as' => 'receipts.finalize', 'uses' => 'ReceiptController@finalize']);
        Route::get('inventory/receipts/{receipt}/product/add', ['as' => 'receipts.product.add', 'uses' => 'ReceiptController@addproduct']);
        Route::get('inventory/receipts/{receipt}/product/{receivedproduct}/edit', ['as' => 'receipts.product.edit', 'uses' => 'ReceiptController@editproduct']);
        Route::post('inventory/receipts/{receipt}/product', ['as' => 'receipts.product.store', 'uses' => 'ReceiptController@storeproduct']);

        // 이거 어디서 보여주는 거 지? 내가 보는 창이 어디서 오는 지 모르겠다. 아니다 여기는 get이 아니니 보여지는 곳이 아니다.
        // 이럴 때 쓰는 것 이다. <form method="post" action="{{ route('receipts.product.update'
        // 그런데 왜 아무것도 보여지지 않는 inventory/receipts/{receipt}/product/{receivedproduct} 를 쓰지?
        // 왜 inventory/receipts/{receipt}/product/{receivedproduct}/edit 가 아니지? ReceiptController@updateproduct에서 redirect를 다른 곳으로 해서 상관 없나? 아닌거 같은데...
        Route::match(['put', 'patch'], 'inventory/receipts/{receipt}/product/{receivedproduct}', ['as' => 'receipts.product.update', 'uses' => 'ReceiptController@updateproduct']);

        Route::delete('inventory/receipts/{receipt}/product/{receivedproduct}', ['as' => 'receipts.product.destroy', 'uses' => 'ReceiptController@destroyproduct']);

        Route::resource('sales', 'SaleController')->except(['edit', 'update',]); //create is done in livewire Controllers

//        Route::get('sales/create', ['as' => 'sales.create', 'uses' => 'app\Http\Livewire\SalesCreate']);

        Route::get('sales/{sale}/finalize', ['as' => 'sales.finalize', 'uses' => 'SaleController@finalize']);
        Route::get('sales/{sale}/product/add', ['as' => 'sales.product.add', 'uses' => 'SaleController@addproduct']);
        Route::get('sales/{sale}/product/{soldproduct}/edit', ['as' => 'sales.product.edit', 'uses' => 'SaleController@editproduct']);
        Route::post('sales/{sale}/product', ['as' => 'sales.product.store', 'uses' => 'SaleController@storeproduct']);
        Route::match(['put', 'patch'], 'sales/{sale}/product/{soldproduct}', ['as' => 'sales.product.update', 'uses' => 'SaleController@updateproduct']);
        Route::delete('sales/{sale}/product/{soldproduct}', ['as' => 'sales.product.destroy', 'uses' => 'SaleController@destroyproduct']);

        Route::get('clients/{client}/transactions/add', ['as' => 'clients.transactions.add', 'uses' => 'ClientController@addtransaction']);
    });

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('icons', ['as' => 'pages.icons', 'uses' => 'PageController@icons']);
    Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'PageController@notifications']);
    Route::get('tables', ['as' => 'pages.tables', 'uses' => 'PageController@tables']);
    Route::get('typography', ['as' => 'pages.typography', 'uses' => 'PageController@typography']);
});
