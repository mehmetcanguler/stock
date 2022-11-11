<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['products'] = Product::get();
        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['genders'] = ['0'=>'Erkek','1'=>'Kız'];
        $data['categories'] = Category::get();
        $data['products'] = Product::with('category')->orderBy('created_at', 'desc')->get();
        // return view('admin.product.create', $data);
        return response()->json($data);
    }

    public function productDetail($id)
    {
        $data['years'] = [
            '0.3' => '3 AY',
            '0.6' => '6 AY',
            '0.9' => '9 AY',
            '0.12' => '12 AY',
            '0.18' => '18 AY',
            '0.24' => '24 AY',
            '3' => '3 YAŞ',
            '4' => '4 YAŞ',
            '5' => '5 YAŞ',
            '6' => '6 YAŞ',
            '7' => '7 YAŞ',
            '8' => '8 YAŞ',
            '9' => '9 YAŞ',
            '10' => '10 YAŞ',
            '11' => '11 YAŞ',
            '12' => '12 YAŞ',
            '13' => '13 YAŞ',
            '14' => '14 YAŞ',
            '15' => '15 YAŞ',
            '16' => '16 YAŞ',
        ];
        $colours =[
            'siyah',
            'lacivert',
            'kahverengi',
            'bej',
            'hardal sarısı',
            'gri',
            'açık mavi',
            'koyu mavi',
            'sarı',
            'kırmızı',
            'bordo',
            'haki yeşil',
            'asker yeşili',
            'turuncu',
            'turkuaz',
            'mor',
            'pembe',
            'fuşya',
            'krem rengi',
            'beyaz'

        ];
        $data['colours']  = $colours;
        $data['product_id'] = $id;
        $data['products'] = Product::with('category')->get();
        $data['productDetail'] = ProductDetail::with('product')->get();

        return view('admin.productDetail.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->image;
        // $image = '';
        // if ($request->hasFile('image')) {
        //     if ($request->file('image')->isValid()) {
        //         $filenameWithExt = $request->image->getClientOriginalName();
        //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //         $extension = $request->image->extension();
        //         $image = Str::lower($filename . time());
        //         $image = 'uploads/products/' . Str::slug($image) . '.' . $extension;
        //         $request->file('image')->move(public_path("uploads/products"), $image);
        //     }
        // }
        // $product = Product::create([
        //     'category_id' => $request->category_id,
        //     'name' => $request->name,
        //     'brand' => $request->brand,
        //     'slug' => Str::slug($request->name),
        //     'content' => $request->content,
        //     'gender' => $request->gender
        // ]);
        // if ($image != null) {
        //     $product->image = $image;
        //     $product->save();
        // }
        // $data = Product::with('category')->find($product->id);
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data['categories'] = Category::get();
        $data['product'] = $product;
        return view('admin.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $filenameWithExt = $request->image->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->image->extension();
                $image = Str::lower($filename . time());
                $image = 'uploads/products/' . Str::slug($image) . '.' . $extension;
                $request->file('image')->move(public_path("uploads/products"), $image);
                $product->image = $image;
                $product->save();
            }
        }
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'size' => $request->size,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'piece' => $request->piece,
            'gender' => $request->gender
        ]);
        return redirect()->route('admin.product.index')->withStatus('Ürün başarıyla güncellendi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.index')->withStatus("Ürün başarıyla silindi");
    }
}
