<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rap extends Model
{
    // use HasFactory;

    protected $table = 'tbl_rap';

    protected $fillable = [
        'kewenangan',
        'fkid_sub_kegiatan',
        'fkid_aktivitas_utama',
        'fkid_opd',
        'jenis_kegiatan',
        'volume_tahun_berjalan',
        'volume_silpa_melanjutkan',
        'volume_silpa_efisiensi',
        'volume_total',
        'satuan_volume',
        'pagu_tahun_berjalan',
        'pagu_silpa_melanjutkan',
        'pagu_silpa_efisiensi',
        'pagu_total',
        'sumber_dana',
        'lokasi',
        'titik_lokasi',
        'sasaran',
        'ppsb',
        'penerima_manfaat',
        'sinergi_dana_lain',
        'multiyears',
        'jadwal_awal',
        'jadwal_akhir',
        'keterangan',
        'kode_klasifikasi',
        'sub_kegiatan',
        'kinerja',
        'indikator',
        'satuan',
        'klasifikasi_belanja',
        'aktivitas_utama',
        'tema_pembangunan',
        'program_prioritas',
        'target_keluaran_strategis',
        'validasi',
        'data_rka',
        'data_kak',
        'data_lainya',

    ];

    /**
     * Relasi ke SubKegiatan
     */
    public function subKegiatan()
    {
        return $this->belongsTo(SubKegiatan::class, 'fkid_sub_kegiatan');
    }

    /**
     * Relasi ke AktivitasUtama
     */
    public function aktivitasUtama()
    {
        return $this->belongsTo(AktivitasUtama::class, 'fkid_aktivitas_utama');
    }

    /**
     * Relasi ke OPD
     */
    public function opd()
    {
        return $this->belongsTo(OPD::class, 'fkid_opd');
    }

}
