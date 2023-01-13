<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Site::query()->truncate();
        \App\User::query()->truncate();
        /**
         * Group 1 object: Provide seed for default administrator account
         */
        \App\User::create([
            'id' => 1,
            'email' => 'phucnguyen.snow@gmail.com',
            'password' => bcrypt('12345678'),
            'name' => 'Phuc Nguyen',
            'role' => 'admin',
        ]);
        \App\User::create([
            'id' => 2,
            'email' => 'client@example.com',
            'password' => bcrypt('12345678'),
            'name' => 'John Doe',
            'role' => 'user',
        ]);
    }
}
