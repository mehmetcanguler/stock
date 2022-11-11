<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        $barcode = Str::slug($product->brand).'-'.Str::slug($product->name) .'-'. Str::slug($request->colour) .'-'. Str::slug($request->size) .'-'. $request->product_id;
        if(ProductDetail::whereProductId($request->product_id)->whereSize($request->size)->whereColour($request->colour)->first() !=null)
        {
            $productDetail =ProductDetail::whereProductId($request->product_id)->whereSize($request->size)->whereColour($request->colour)->first();
            $productDetail->qty = $productDetail->qty + $request->qty;
            $productDetail->save();
            $productDetail =ProductDetail::with('product')->find($productDetail->id);

            return response()->json($productDetail);
        }
        $productDetail = ProductDetail::create([
            'product_id' => $request->product_id,
            'size' => $request->size,
            'price' => $request->price,
            'colour' => $request->colour,
            'qty' => $request->qty,
            'barcode'=>$barcode
        ]);
        $productDetail =ProductDetail::with('product')->find($productDetail->id);

        return response()->json($productDetail);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ProductDetail $productDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductDetail $productDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductDetail $productDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductDetail $productDetail)
    {
        //
    }
}
