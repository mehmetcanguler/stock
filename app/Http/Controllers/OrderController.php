<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['orders'] = Order::with('order_detail')->get();
        return view('admin.order.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $maxOrder = (count($request->post()) - 1) / 4;
        $total = 0.00;

        for ($i = 0; $i < $maxOrder; $i++) {
            $total = $total + $request->price[$i];
        }

        $order = Order::create([
            'total' => $total
        ]);

        for ($i = 0; $i < $maxOrder; $i++) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $request->product_id[$i],
                'piece' => $request->piece[$i],
                'price' => $request->price[$i],
            ]);
            $product = Product::find($request->product_id[$i]);
            $product->piece =  $product->piece - $request->piece[$i];
            $product->save();
        }
        return redirect()->route('admin.order.index')->withStatus('Sipariş başarılı');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
