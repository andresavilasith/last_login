<?php

namespace Tests\Feature;

use App\Helpers\DefaultDataTest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_register()
    {
        $this->withoutExceptionHandling();
        
        DefaultDataTest::data_seed();

        Storage::fake('public');

        $name = 'User New';
        $email = 'usernew@gmail.com';
        $password = '1234';
        $last_login_date = Carbon::now();
        $phone = '598518566';
        $image =  UploadedFile::fake()->image('test.png');

        
        $response = $this->post('/api/auth/register', [
            'name' => $name,
            'email' => $email,
            'image' => $image,
            'last_login_date' => $last_login_date,
            'phone' => $phone,
            'password' => $password
        ]);
        
        $response->assertStatus(201);
        
        $imageSaved = 'users/' . $image->hashName();
        
        $response->assertJsonStructure(['status', 'user']);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);

        $this->assertDatabaseCount('users', 3);

        Storage::disk('public')->assertExists($imageSaved);
    }

    /** @test */
    public function test_user_login()
    {
        $this->withoutExceptionHandling();

        DefaultDataTest::data_seed();

        $user = User::first();

        $email = $user->email;
        $password = '1234';

        $response = $this->post('/api/auth/login', [
            'email' => $email,
            'password' => $password
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }

    /** @test */
    public function test_user_logout()
    {
        DefaultDataTest::data_seed();
        $user = User::first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/auth/logout');

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'Successfully logged out'
            ]);
    }

     /** @test */
     public function test_get_user()
     {
         DefaultDataTest::data_seed();
 
         $user = User::first();
 
         $token = JWTAuth::fromUser($user);
 
         $response = $this->withHeaders([
             'Authorization' => 'Bearer ' . $token,
         ])->post('/api/auth/users');
 
         $response->assertStatus(200);
     }

    
}
