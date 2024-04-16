<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Selling;
use App\Models\SellingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selling = Selling::with('customer', 'user')->get();
        return view('selling.selling-data', compact('selling'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = Product::whereNotIn('stock', [0])->get();
        return view('selling.selling', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $customer = Customer::create([
            'name' => $data['customer_name'],
            'address' => $data['customer_address'],
            'phone_number' => $data['customer_phone_number']
        ]);

        $total_price = 0;
        $products = Product::whereIn('id', $data['productCheck'])->get();


        foreach($products as $key => $product){
            $quantity = $data['quantity'][$key];

            $total_stock = $product->stock - $quantity;
            
            Product::where('id', $product->id)->update([
                'stock' => $total_stock
            ]);

            if($quantity > 0){
                $total_price += $product->price * $quantity;
            }
        }

        $selling = Selling::create([
            'customer_id' => $customer->id,
            'user_id' => Auth::user()->id,
            'total_price' => $total_price
        ]);

        foreach($products as $key => $product){
            $quantity = $data['quantity'][$key];
            $subtotal = $product->price * $quantity;

            SellingDetail::create([
                'product_id' => $product->id,
                'selling_id' => $selling->id,
                'subtotal' => $subtotal,
                'total_product' => $quantity,
            ]);
        }

        return redirect("/selling/detail/{$selling->id}");
    }

    /**
     * Display the specified resource.
     */
    public function show(Selling $selling, $id)
    {
        $sellingData = Selling::with( 'user', 'sellingDetails', 'sellingDetails.product', 'customer',)->where('id', $id)->first();
        return view('selling.payment-details', compact('sellingData'));
    }

    public function download($id){
        $sellingData = Selling::with( 'user', 'sellingDetails', 'sellingDetails.product', 'customer',)->where('id', $id)->first();
        return view('selling.invoice-download', compact('sellingData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Selling $selling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Selling $selling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Selling $selling, $id)
    {
        Selling::where('id', $id)->delete();
        return back()->with('success', 'Successfully Delete Product');
    }
}
