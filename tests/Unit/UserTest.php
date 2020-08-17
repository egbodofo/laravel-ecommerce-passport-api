<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersMayHaveManyProducts()
    {
        $user = create('App\User');

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->products);
    }
}
