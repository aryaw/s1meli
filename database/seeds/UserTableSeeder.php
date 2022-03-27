<?php

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credentials = [
            'email'    => 'administrator@gmail.com',
            'password' => '5up3r4adm1n',
        ];
        $user = Sentinel::register($credentials, true);
        $role = Sentinel::findRoleBySlug('administrator');
        $role->users()->attach($user);
    }
}
