<?php

namespace App\Http\Controllers;

use App\Receipt;
use App\Provider;
use App\Product;

use Carbon\Carbon;
use App\ReceivedProduct;
use Illuminate\Http\Request;
use App\Http\Requests\ReceiptRequest;


class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Receipt  $model
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = Receipt::orderBy('received_date', 'DESC')->paginate(25);

        return view('inventory.receipts.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $providers = Provider::all();

        return view('inventory.receipts.create', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ReceiptRequest  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptRequest $request, Receipt $receipt)
    {

        $receipt = $receipt->create($request->all());

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus(__('Receipt registered successfully, you can start adding the products belonging to it.'));
    }

    /**
     * Show the form for editing receipt.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {

        return view('inventory.receipts.edit', compact('receipt'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        return view('inventory.receipts.show', compact('receipt'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        if ($receipt->finalized_at)
        {
            foreach($receipt->products as $receivedproduct) {
                $receivedproduct->product->stock -= $receivedproduct->stock;
                $receivedproduct->product->stock_defective -= $receivedproduct->stock_defective;
                $receivedproduct->product->save();
            }
        }
        $receipt->delete();
        return redirect()
            ->route('receipts.index')
            ->withStatus(__('Receipt successfully removed.'));
    }

    /**
     * Finalize the Receipt for stop adding products.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function finalize(Receipt $receipt)
    {
        $receipt->finalized_at = Carbon::now()->toDateTimeString();
        $receipt->save();

        // 이제야 이해 했다. Model에서 belongTo/hasMany로 다른 모델이랑 연결한다. 그러면 이해가 쉽다
        // 예) $receipt->products 는 Receipt.php에 있는 products()으로 가면 hasMany()로 ReceivedProduct.php로 연결 되어 있다.
        foreach($receipt->products as $receivedproduct) {

            $receivedproduct->product->stock += $receivedproduct->stock;
            $receivedproduct->product->stock_defective += $receivedproduct->stock_defective;
            $receivedproduct->product->save();

        }

        return back()->withStatus(__('Receipt successfully completed.'));
    }

    /**
     * Add product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function addproduct(Receipt $receipt)
    {
        $products = Product::all();

        return view('inventory.receipts.addproduct', compact('receipt', 'products'));
    }

    /**
     * Add product on Receipt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function storeproduct(Request $request, Receipt $receipt, ReceivedProduct $receivedproduct)
    {
        $receivedproduct->create($request->all());

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus(__('Product added successfully.'));
    }

    /**
     * Editor product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function editproduct(Receipt $receipt, ReceivedProduct $receivedproduct)
    {
        $products = Product::all();

        return view('inventory.receipts.editproduct', compact('receipt', 'receivedproduct', 'products'));
    }

    /**
     * Update product on Receipt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function updateproduct(Request $request, Receipt $receipt, ReceivedProduct $receivedproduct)
    {
        $receivedproduct->update($request->all());

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus(__('Product edited successfully.'));
    }

    /**
     * Add product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroyproduct(Receipt $receipt, ReceivedProduct $receivedproduct)
    {

        $receivedproduct->delete();
        return redirect()
        ->route('receipts.show', $receipt)
        ->withStatus(__('Product removed successfully.'));
    }

}
