<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jam;

class JamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jams = [
            [
                'id_user' => null,
                'name' => "Rolex Daytona Paul Newman",
                'serialNumber' => "6239",
                'imageUrl' => "gambar/jam1.jpg",
            ],
            [
                'id_user' => null,
                'name' => "Patek Philippe Nautilus 5711",
                'serialNumber' => "5711/1A-010",
                'imageUrl' => "gambar/jam2.jpg",
            ],
        ];
        foreach($jams as $value) {
            $jam = Jam::create($value);
        }
    }
}
