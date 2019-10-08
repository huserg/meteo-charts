<?php

use Illuminate\Database\Seeder;
use App\Models\User;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->name = 'R-Men';
        $admin->email = 'huser.gaetan@hotmail.com';
        $admin->password = bcrypt('secret');
        $admin->save();
    }
}
