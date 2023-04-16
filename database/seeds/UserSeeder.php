<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            "stud_no" => "null",
            "first_name" => "admin",
            "last_name" => "admin",
            "mid_name" => "null",
            "suffix" => "null",
            "dobirth" => "null",
            "province" => "null",
            "town" => "null",
            "brgy" => "null",
            "parent_mid" => "null",
            "parent_first" => "null",
            "parent_last" => "null",
            "program" => "null",
            "user_type" => 1,
            "email" => "admin@mail.com",
            "password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi"
        ]);
    }
}
