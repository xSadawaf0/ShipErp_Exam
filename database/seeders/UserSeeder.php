<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
Use App\Models\User;
use Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Test User';
        $user->email = 'email@test.com';
        $user->password = Hash::make('12345678');
        $user->save();
    }
}
