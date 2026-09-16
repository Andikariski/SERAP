<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RapStatusOption; // tambah ini

class RapStatusOptionSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'RAP Awal',
            'RAP Penyesuaian',
            'RAP Perubahan Pertama',
            'RAP Perubahan II',
            'RAP Perubahan III',
        ];

        foreach ($items as $i => $nama) {
            RapStatusOption::firstOrCreate(
                ['nama' => $nama],
                ['urutan' => $i + 1]
            );
        }
    }
}