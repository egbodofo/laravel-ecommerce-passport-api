<?php

namespace App\Data\Repositories\Product;

/**
 * Interface ProductRepository
 * @package App\Data\Repositories\Product
 */
interface ProductRepository
{
    /**
     * @return mixed
     */
    public function createProduct($attributes);

    public function getAllProducts();

    public function updateAProduct($product);

    public function deleteAProduct($product);
}
