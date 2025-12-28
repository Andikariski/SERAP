<?php

namespace App\Imports;

use App\Models\AktivitasUtama as ModelsAktivitasUtama;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;

class AktivitasUtama implements ToModel, WithHeadingRow,SkipsEmptyRows
{
    
    public function model(array $row)
    {
          return new ModelsAktivitasUtama([
            'aktivitas_utama'           => $row['aktivitas_utama'] ?? null,
            'tema_pembangunan'          => $row['tema_pembangunan'] ?? null,
            'program_prioritas'         => $row['program_prioritas'] ?? null,
            'target_keluaran_strategis' => $row['target_keluaran_strategis'] ?? null
        ]);
    }
}
