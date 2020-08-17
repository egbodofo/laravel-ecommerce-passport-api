<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProductsTest extends TestCase
{
    use RefreshDatabase;

    function testUnauthorizedUsersMayNotUpdateProduct()
    {
        $this->withExceptionHandling();

        $header = $this->signIn();

        $product = create('App\Product',
            ['owner_id' => create('App\User')->id]
        );

        $this->patch($product->path(), [], $header)
            ->assertStatus(403);
    }

    function testAProductCanBeUpdatedByItsOwner()
    {
        $user = create('App\User');

        $token = $user->createAccessToken();
        $header = ['Authorization' => "Bearer $token"];

        $product = create('App\Product',
            ['owner_id' => $user->id]
        );

        $attributes = [
            'name' => 'Changed',
            'brand' => 'Changed body.',
            'image' => 'Changed',
            'price' => 666,
            'description' => 'Changed'
        ];

        $this->patch($product->path(), $attributes, $header);

        tap($product->fresh(), function ($product) {
            $this->assertEquals('Changed', $product->name);
            $this->assertEquals('Changed body.', $product->brand);
            $this->assertEquals('Changed', $product->image);
            $this->assertEquals('666', $product->price);
            $this->assertEquals('Changed', $product->description);
        });
    }
}
