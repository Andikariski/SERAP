<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaguInduk extends Model
{
    protected $table = 'tbl_pagu_induk';

    protected $fillable = [
        'pagu_SG',
        'pagu_BG',
        'pagu_DTI',
        'pagu_SiLPA_Melanjutkan',
        'pagu_SiLPA_Efisiensi',
        'tahun_pagu',
        'status'
    ];

     public function paguOpd()
    {
        return $this->hasMany(Pagu::class, 'tahun_pagu', 'tahun_pagu');
    }

     protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Kalau status diubah jadi Aktif
            if ($model->status === 'Aktif') {
                // Nonaktifkan semua tahun lain
                static::where('id', '!=', $model->id)
                    ->update(['status' => 'Nonaktif']);
            }
        });
    }
}
