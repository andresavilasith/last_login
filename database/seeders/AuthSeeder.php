<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('public/users');
        Storage::makeDirectory('public/users');

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => '1234'
        ]);
    }
}
