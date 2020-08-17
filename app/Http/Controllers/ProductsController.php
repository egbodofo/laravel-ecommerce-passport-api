<?php

namespace App\Http\Controllers;

use App\Data\Repositories\Product\ProductRepository;
use App\Product;

class ProductsController extends Controller
{
    protected $product_repository;

    public function __construct(ProductRepository $product_repository)
    {
        $this->middleware('auth:api')->except(['index', 'show']);

        $this->product_repository = $product_repository;
    }

    public function index()
    {
        $products = $this->product_repository->getAllProducts();

        return response()->json([
            'products' => $products,
        ], 200);
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'description' => 'required|string'
        ]);

        $attributes['owner_id'] = auth()->id();

        $product = $this->product_repository->createProduct($attributes);

        return response()->json([
            'product' => $product,
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json([
            'product' => $product,
        ], 200);
    }

    public function update(Product $product)
    {
        $this->authorize('update', $product);

        $attributes = request()->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'description' => 'required|string'
        ]);

        $product->name = $attributes['name'];
        $product->brand = $attributes['brand'];
        $product->price = $attributes['price'];
        $product->image = $attributes['image'];
        $product->description = $attributes['description'];

        $this->product_repository->updateAProduct($product);

        return response()->json([
            'product' => $product,
        ], 201);
    }

    public function destroy(Product $product)
    {
        $this->authorize('update', $product);

        $this->product_repository->deleteAProduct($product);

        return response()->json([
            'message' => 'Product deleted successfully',
            'product' => $product,
        ], 201);
    }
}
