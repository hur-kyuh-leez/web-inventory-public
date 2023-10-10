<?php

header('access-control-allow-origin: *');
header('Access-Control-Allow-Headers: *');

use App\Client;
use App\User;
use App\PaymentMethod;
use App\Receipt;
use App\Product;
use App\ReceivedProduct;

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




// getting product name and id using barcode
Route::get('product/{barcode?}', function($barcode=null) {

    return $barcode ? Product::where('barcode', $barcode)->get(['id','name','stock']) : null;
});

// post receipt api
Route::post('receipt', function(Request $request) {

    return Receipt::create($request->all());
});

// post received_product api
Route::post('received_product', function(Request $request) {
    return ReceivedProduct::create($request->all());
});








//// Protected API routes
//Route::group(['middleware' =>['auth:sanctum']], function () {
//    Route::post('/logout', function (Request $request) {
//        $request->user()->currentAccessToken()->delete();
//        return [
//            'message' => 'Logged out'
//        ];
//    });
//});
//
//
//
//
//
//
//
//
//
//
//Route::get('/clients', function() {
//    return Client::all();
//});
//
//// getting foreign data using keyword 'with'
//Route::get('/receipt', function() {
//    return Receipt::with('products')->get();
//});
//
//// storing data
//Route::post('/receipt', function(Request $request) {
//    return Receipt::create($request->all());
//});
//
//
//
//
//
//
//
//
// posting to DB
Route::post('/payment-method', function(Request $request) {
    // validation
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ]);

    $paymentMethod = PaymentMethod::create([
        'name' => $validatedData['name'],
        'description' => $validatedData['description'],
    ]);

    print($paymentMethod);

    return response()->json([
    ], 201);

});
//
//
//
//Route::get('/payment-method', function() {
//    return PaymentMethod::all();
//});
//
//
//
//
//
//
//
//Route::post('/login', function(Request $request){
//
//    $fields = $request->validate([
//        'email' => 'required|string',
//        'password' => 'required|string'
//    ]);
//
//    // Check email
//    $user = User::where('email', $fields['email'])->first();
//
//    // Check password
//    if( !$user || !Hash::check($fields['password'], $user->password)) {
//        return response([
//            'message' => __('Wrong email or password')
//        ], 401);
//    }
//
//    $token = $user->createToken('loginToken')->plainTextToken;
//
//    $response = [
//        'user' => $user,
//        'token' => $token
//    ];
//
//    return response($response, 201);
//
//});
