<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        $user = new User;
        $user->firstname = 'Jon';
        $user->lastname = 'Doe';
        $user->email = 'jon@doe.com';
        $user->password = bcrypt('mypassword');
        $user->telephone = '5557771234';
        $user->admin = 1;
        $user->save();
    }
}