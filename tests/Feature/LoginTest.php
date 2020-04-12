<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    public function testLoginPageLoaded()
    {
        $response = $this->get('/login');

        $response->assertSee("Login");

    }

    public function testUserCanLoginWithGoodPass()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'demopass'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCanLoginWithBadPass()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('demopass'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'hibasjelszo',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

}
