<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSingleResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{

    public function __construct()
    {
        // Selain Index dan Show perlu Autentikasi Token
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return ProductResource::collection(Product::get()); //Default All Row Fetched (Tidak direkomendasikan untuk skala besar)
        // return ProductResource::collection(Product::simplePaginate(10)); //Umum
        return ProductResource::collection(Product::latest()->paginate(10)); //Mengirim result dengan Pagination + Meta untuk memudahkan Frontend
        // return ProductResource::collection(Product::cursorPaginate(10)); //Untuk handle data banyak, infinite scrolling dan API, tidak ada page number
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // Pengaman
        $this->authorize('if_admin');

        // manual validation, yg bagus di ProductRequest
        // if ($request->price < 10000) {
        //     throw ValidationException::withMessages([
        //         'price' => 'Your price is too low',
        //     ]);
        // }

        // $product = Product::create([
        //     'name' => $request->name,
        //     // Penerapan Slug #1 - Normal/Umum
        //     // 'slug' => strtolower(Str::slug($request->name . '-' . time())),
        //     'description' => $request->description,
        //     'price' => $request->price,
        //     'category_id' => $request->category_id,
        // ]);

        // Clean Code (Karna namanya sama bisa langsung)
        $product = Product::create($request->toArray());

        return response()->json([
            'message' => 'Product was created.',
            'data' => new ProductSingleResource($product),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) //detail produk
    {
        // return $product; //(manual)
        return new ProductSingleResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        // if ($request->price < 10000) {
        //     throw ValidationException::withMessages([
        //         'price' => 'Your price is too low',
        //     ]);
        // }

        // Cara tidak baik, tapi jika ingin mengubah "slug", atau hal lain yg seharusnya tidak perlu diubah.
        // $attributes = $request->toArray();
        // $attributes['slug'] = Str::slug(Str::random(5));
        // $product->update($attributes);

        $product->update($request->toArray());

        return response()->json([
            'message' => 'Product was updated.',
            'data' => new ProductSingleResource($product),
        ]);
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
        return response()->json([
            'message' => 'Product was deleted.',
        ]);
    }
}
