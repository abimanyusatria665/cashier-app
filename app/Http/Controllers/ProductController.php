<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        return view('product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'name' => 'required',
                'price' => 'required',
                'stock' => 'required'
            ]);
            Product::create($data);
    
            return redirect('/product')->with('success', "Successfully create product");

        } catch (\Throwable $th) {
            
            return back()->withInput()->with('fail', "Failed To Create Product");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id)
    {
        $product = Product::where('id', $id)->first();
        return view('product.update', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required',
                'price' => 'required',
                'stock' => 'required'
            ]);
    
    
            Product::where('id', $id)->update($data);
            
            return redirect('/product')->with('success', 'Success Update Product');
        
        } catch (\Throwable $th) {

            return back()->withInput()->with('fail', 'Failed To Update Product');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        Product::where('id', $id)->delete();
        return redirect('/product')->with('success', 'Success Delete Product');
    }
}
