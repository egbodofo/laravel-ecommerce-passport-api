<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class createUserTest extends TestCase
{
    use RefreshDatabase;

    function testAGuestCanRegister()
    {
        $attributes = [
            'firstname' => 'John',
            'lastname' => 'John',
            'phoneNumber' => '08012345678',
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
        ];

        $this->post(route('register'), $attributes)
            ->assertStatus(201)
            ->assertJson([
                'user' => true,
                'token' => true
            ]);
    }

    function testAUserCanLogin()
    {
        create('App\User', [
            'email' => 'john@toptal.com',
            'password' => bcrypt('toptal123'),
        ]);

        $attributes = [
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
        ];

        $this->post(route('login'), [
            'email' => 'john@topl.com',
            'password' => 'topt123',
        ])->assertStatus(401);

        $this->post(route('login'), $attributes)
            ->assertStatus(201)
            ->assertJson([
                'user' => true,
                'token' => true
            ]);
    }

    function testAUserCanLogout()
    {
        $header = $this->signIn();

        $this->json('post', '/api/logout', [], $header)
            ->assertStatus(200);
    }

    function testAUserRegistrationRequiresAFirstname()
    {
        $this->publishUser(['firstname' => null])
            ->assertSessionHasErrors('firstname');
    }

    function testAUserRegistrationRequiresALastname()
    {
        $this->publishUser(['lastname' => null])
            ->assertSessionHasErrors('lastname');
    }

    function testAUserRegistrationRequiresAPhoneNumber()
    {
        $this->publishUser(['phoneNumber' => null])
            ->assertSessionHasErrors('phoneNumber');
    }

    function testAUserRegistrationRequiresAnEmail()
    {
        $this->publishUser(['email' => null])
            ->assertSessionHasErrors('email');
    }

    function testAUserRegistrationRequiresAPassword()
    {
        $this->publishUser(['password' => null])
            ->assertSessionHasErrors('password');
    }

    public function publishUser($overrides = [])
    {
        $this->withExceptionHandling();

        $attributes = make('App\User', $overrides);

        return $this->post(route('register'), $attributes->toArray());
    }
}
