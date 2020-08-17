<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsAndUsersCanSeeAllProducts()
    {
        $product = create('App\Product');

        $this->get('/api/products')
            ->assertSee($product->name);
    }

    public function testUsersAndGuestsViewASingleProduct()
    {
        $product = create('App\Product');

        $this->get($product->path())
            ->assertSee($product->name);
    }
}
