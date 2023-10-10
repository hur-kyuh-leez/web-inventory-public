<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use App\Sale;
use App\Product;
use Carbon\Carbon;
use App\SoldProduct;
use App\Transaction;
use App\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::latest()->paginate(25);

        return view('sales.index', compact('sales'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        $users = User::get(['id','name']);

        return view('sales.create', compact('clients', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SaleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request, Sale $model)
    {
        $existent = Sale::where('client_id', $request->get('client_id'))->where('finalized_at', null)->get();



        // 이걸 없애는 이유는 추가로 넣을 수 있게 하려고
//        if($existent->count()) {
//            return back()->withError('There is already an unfinished sale belonging to this customer. <a href="'.route('sales.show', $existent->first()).'">Click here to go to it</a>');
//        }

        $sale = $model->create($request->all());

        return redirect()
            ->route('sales.show', ['sale' => $sale->id])
            ->withStatus(__('Sale registered successfully, you can start registering products and transactions.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return view('sales.show', ['sale' => $sale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        if ($sale->finalized_at){
            foreach ($sale->products as $sold_product) {
                $sold_product->product->stock += $sold_product->qty;
                $sold_product->product->save();
            }
            $sale->client->balance += $sale->total_amount;
            $sale->client->save();
        }

        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->withStatus(__('The sale record has been successfully deleted.'));
    }

    public function finalize(Sale $sale)
    {
        $sale->total_amount = $sale->products->sum('total_amount');

        foreach ($sale->products as $sold_product) {
            $product_name = $sold_product->product->name;
            $product_stock = $sold_product->product->stock;
            if($sold_product->qty > $product_stock) return back()->withError("The product '$product_name' does not have enough stock. Only has $product_stock units.");
        }

        foreach ($sale->products as $sold_product) {
            $sold_product->product->stock -= $sold_product->qty;
            $sold_product->product->save();
        }

        $sale->finalized_at = Carbon::now()->toDateTimeString();
        $sale->client->balance -= $sale->total_amount;
        $sale->save();
        $sale->client->save();

        return back()->withStatus(__('The sale has been successfully completed.'));
    }

    public function addproduct(Sale $sale)
    {
        $products = Product::all();
        $soldproducts = SoldProduct::all();


        $upgradable  = false;
        // 만약 고객이 한번도 업그레이드를 하지 않았을 때 (한 고객당 평생 딱 한번 업그레이드 할 수 있음)
        if(!($sale->client_id->upgraded_bool ?? false))
        {
            // 업그레이드 가능 한 지 확인 하기
            $effectiveDate = date('Y-m-d', strtotime("-6 months", strtotime($sale->order_date ?? $sale->created_at))); // 6개월 전 날짜
            $set_array = [15, 64, 52, 60]; // 세트로 인정되는 상품들

            foreach ($soldproducts as $soldproduct)
            {
                if($soldproduct->sale->client->id == $sale->client->id and ($soldproduct->sale->order_date ?? $soldproduct->sale->created_at) > $effectiveDate) //현재 해당 고객이 6개월 이내 샀으면
                {
                    if (in_array($soldproduct->product_id, $set_array, true))  // 세트를 샀는 지 확인 하고
                    {
                        // 만약 있다면
                        $upgradable = true;
                        break;
                    }
                }
            }
        }
        return view('sales.addproduct', compact('sale', 'products', 'upgradable'));
    }

    public function storeproduct(Request $request, Sale $sale, SoldProduct $soldProduct)
    {
        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldProduct->create($request->all());

        return redirect()
            ->route('sales.show', ['sale' => $sale])
            ->withStatus(__('Product successfully registered.'));
    }

    public function editproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $products = Product::all();

        return view('sales.editproduct', compact('sale', 'soldproduct', 'products'));
    }

    public function updateproduct(Request $request, Sale $sale, SoldProduct $soldproduct)
    {
        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldproduct->update($request->all());

        return redirect()->route('sales.show', $sale)->withStatus(__('Product successfully modified.'));
    }

    public function destroyproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $soldproduct->delete();

        return back()->withStatus(__('The product has been disposed of successfully.'));
    }

    public function addtransaction(Sale $sale)
    {
        $payment_methods = PaymentMethod::all();

        return view('sales.addtransaction', compact('sale', 'payment_methods'));
    }

    public function storetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        switch($request->all()['type']) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: ' . $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: ' . $request->all('sale_id')]);

                if($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1) ]);
                }
                break;
        }

        $transaction->create($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus(__('Successfully registered transaction.'));
    }

    public function edittransaction(Sale $sale, Transaction $transaction)
    {
        $payment_methods = PaymentMethod::all();

        return view('sales.edittransaction', compact('sale', 'transaction', 'payment_methods'));
    }

    public function updatetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        switch($request->get('type')) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: '. $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: '. $request->get('sale_id')]);

                if($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }
        $transaction->update($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus(__('Successfully modified transaction.'));
    }

    public function destroytransaction(Sale $sale, Transaction $transaction)
    {
        $transaction->delete();

        return back()->withStatus(__('Transaction deleted successfully.'));
    }
}
