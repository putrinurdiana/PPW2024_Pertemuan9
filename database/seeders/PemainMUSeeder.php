<?php

namespace Database\Seeders;

use App\Models\pemainmu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemainMUSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            pemainmu::create([
                'nama_pemain' => fake() ->name(),
                'no_punggung' => fake() ->numberBetween(1, 25),
                'posisi' => fake() ->sentence(2),

            ]);
        }
    }
}
