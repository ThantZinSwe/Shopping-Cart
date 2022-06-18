<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // \App\Models\User::factory(10)->create();

        User::create( array(
            'name'     => 'Admin',
            'role'     => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make( 'admin123' ),
            'image'    => 'image/profile.png',
        ) );

        User::create( array(
            'name'     => 'Thant Zin Swe',
            'email'    => 'thantzinswe@gmail.com',
            'password' => Hash::make( 'thantzinswe123' ),
            'image'    => 'image/profile.png',
        ) );
    }
}
