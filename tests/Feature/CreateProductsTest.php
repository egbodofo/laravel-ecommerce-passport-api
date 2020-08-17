<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateProductsTest extends TestCase
{
    use RefreshDatabase;

    function testGuestsMayNotCreateThreads()
    {
        $this->withExceptionHandling();

        $this->post('/api/products')
            ->assertRedirect('/api/login');
    }

    function testAUserCanCreateAProduct()
    {
        $header = $this->signIn();

        $attributes = [
            'name' => 'Samsung Gz',
            'brand' => 'Samsung',
            'image' => 'http//awesome',
            'price' => 847,
            'description' => 'This is awesome'
        ];

        $this->post('/api/products', $attributes, $header);

        $this->assertDatabaseHas('products', $attributes);
    }

    public function testAProductRequiresAName()
    {
        $this->withExceptionHandling();

        $headers = $this->signIn();

        $attributes = factory('App\Product')->raw(['name' => '']);

        $this->post('/api/products', $attributes, $headers)
            ->assertSessionHasErrors('name');
    }

    public function testAProductRequiresABrand()
    {
        $this->withExceptionHandling();

        $headers = $this->signIn();

        $attributes = factory('App\Product')->raw(['brand' => '']);

        $this->post('/api/products', $attributes, $headers)
            ->assertSessionHasErrors('brand');
    }

    public function testAProducRequiresAPrice()
    {
        $this->withExceptionHandling();

        $headers = $this->signIn();

        $attributes = factory('App\Product')->raw(['price' => '']);

        $this->post('/api/products', $attributes, $headers)
            ->assertSessionHasErrors('price');
    }

    public function testAProductRequiresAnImage()
    {
        $this->withExceptionHandling();

        $header = $this->signIn();

        $attributes = factory('App\Product')->raw(['image' => '']);

        $this->post('/api/products', $attributes, $header)
            ->assertSessionHasErrors('image');
    }

    public function testAProductRequiresADescription()
    {
        $this->withExceptionHandling();

        $header = $this->signIn();

        $attributes = factory('App\Product')->raw(['description' => '']);

        $this->post('/api/products', $attributes, $header)
            ->assertSessionHasErrors('description');
    }

    function testUnauthorizedUsersMayNotDeleteProduct()
    {
        $this->withExceptionHandling();

        $header = $this->signIn();

        $product = create('App\Product');

        $this->delete($product->path(), [], $header)
            ->assertStatus(403);
    }

    function testAuthorizedUserCanDeleteProduct()
    {
        $user = create('App\User');

        $token = $user->createAccessToken();
        $header = ['Authorization' => "Bearer $token"];

        $product = create('App\Product', ['owner_id' => $user->id]);

        $this->delete($product->path(), [], $header);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);

    }
}
