<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Draw;
use App\Models\User;

class DrawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(User::all() as $user){
            $draw = Draw::create([
                'name' => 'Proyecto ' . $user->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
