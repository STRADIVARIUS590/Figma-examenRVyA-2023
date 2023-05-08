<?php

namespace Database\Seeders;

use App\Models\Draw;
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

        foreach($jsonData as $draw){

            $d = new Draw([
                'user_id' => 1,
                'image' => json_encode($draw)     
            ]);
                
            $d->save();
        }
        
       
    }
}
