<?php

namespace App\Data\Repositories\Product;

use App\Product;

/**
 * Class EloquentRepository
 * @package App\Data\Repositories\Product
 */
class EloquentRepository implements ProductRepository
{
    public function createProduct($attributes)
    {
        return Product::create($attributes);
    }

    public function getAllProducts()
    {
        return Product::all();
    }

    public function updateAProduct($product)
    {
        $product->save();

        return $product;
    }

    public function deleteAProduct($product)
    {
        return $product->delete();
    }
}
