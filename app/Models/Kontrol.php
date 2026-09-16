<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrol extends Model
{    protected $table = 'tbl_kontrol';
     protected $fillable = ['tipe', 'status'];

     //  Pilihan status yang valid (bisa kamu gunakan untuk dropdown)
    public static function getStatusOptions($tipe)
    {
        return match ($tipe) {
            'RAP_Akses' => ['Buka', 'Tutup'],
            'RAP_Status' => ['RAP Awal','RAP Penyesuaian','RAP Perubahan Pertama', 'RAP Perubahan II', 'RAP Perubahan III'],
            default => [],
        };
    }
}
