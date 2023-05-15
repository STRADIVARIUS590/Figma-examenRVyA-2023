<?php

namespace Database\Seeders;

use App\Models\Draw;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DrawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = json_decode(file_get_contents("database/jsons/draws.json"), true);

        $user_ids = User::pluck('id');

        foreach($jsonData as $draw){
            $d = new Draw([
                'name' => $draw['name'],
                'user_id' => $user_ids->random(),
                'image' => json_encode([ 'canvas' => $draw['canvas'],'figures' =>  $draw['figures']])   
            ]);
            $d->save();
        }
        
       
    }
}
