<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testAProductHasAPath()
    {
        $product = create('App\Product');

        $this->assertEquals("/api/products/{$product->id}", $product->path());
    }

    public function testAProductHasAnOwner()
    {
        $product = create('App\Product');

        $this->assertInstanceOf('App\User', $product->owner);
    }
}
