<?php

namespace App\Imports;

use App\Models\SubKegiatan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;


class SubKegiatanImport implements ToModel, WithHeadingRow,SkipsEmptyRows
{
    public function model(array $row)
    {
        return new SubKegiatan([
            'kewenangan'            => $row['kewenangan'] ?? null,
            'kode_klasifikasi'      => $row['kode_klasifikasi'] ?? null,
            'sub_kegiatan'          => $row['sub_kegiatan'] ?? null,
            'kinerja'               => $row['kinerja'] ?? null,
            'indikator'             => $row['indikator'] ?? null,
            'satuan'                => $row['satuan'] ?? null,
            'klasifikasi_belanja'   => $row['klasifikasi_belanja'] ?? null,
        ]);
    }
}
