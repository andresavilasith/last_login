<?php

namespace App\Helpers;

use App\Models\Document;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DefaultDataTest
{
    use RefreshDatabase;

    public static function data_seed()
    {
        User::factory()->create([
            'document_id' => 1,
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => '1234'
        ]);
        User::factory()->create([
            'document_id' => 2,
            'name' => 'user2',
            'email' => 'user2@user.com',
            'password' => '1234'
        ]);
    }
}