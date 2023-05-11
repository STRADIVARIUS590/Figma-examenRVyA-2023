<?php

namespace Database\Seeders;

use App\Models\Draw;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = json_decode(file_get_contents("database/jsons/users.json"), true);

        foreach ($values as $value) { 
            $user = User::create($value);
            $user->password = bcrypt($value['password']);
            $user->save();
        }
    }
}
