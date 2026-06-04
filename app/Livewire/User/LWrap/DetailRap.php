<?php

namespace App\Livewire\User\LWrap;

use Livewire\Component;
use App\Models\Rap as ModelsRap;
use Livewire\Attributes\Layout;


class DetailRap extends Component
{
    // Sub Kegiatan Initialisasi
    public $id_sub_kegiatan;
    public $kode_klasifikasi;
    public $klasifikasi_belanja;
    public $satuan;
    public $indikator;
    public $kinerja;
    public $fkid_opd;
    public $kewenangan;
    public $sub_kegiatan;

    // Activitas Utama Initialisasi
    public $id_aktivitas_utama;
    public $aktivitas_utama;
    public $tema_pembangunan;
    public $program_prioritas;
    public $target_keluaran_strategis;

    // Auth::user()->opd_id;
    public $jenis_kegiatan;
    public $volume_tahun_berjalan;
    public $volume_silpa_melanjutkan;
    public $volume_silpa_efisiensi;
    public $volume_total;
    public $pagu_tahun_berjalan;
    public $pagu_silpa_melanjutkan;
    public $pagu_silpa_efisiensi;
    public $pagu_total;
    public $sumber_dana;
    public $lokasi;
    public $titik_lokasi;
    public $sasaran;
    public $ppsb;
    public $penerima_manfaat;
    public $sinergi_dana_lain;
    public $multiyears;
    public $jadwal_awal;
    public $jadwal_akhir;
    public $keterangan;
    public $data_rka;
    public $data_kak;
    public $data_lainya;

    public $showSisaPagu;
    public $sisaPaguBG;
    public $sisaPaguSG;
    public $sisaPaguDTI;
    public $rapId;

    public $sisa_pagu_form;
    public $type;

    public function mount($id)
    {
        $rap = ModelsRap::findOrFail($id);
        $this->rapId = $rap->id;

        $this->type = request()->query('type'); 

        // LOAD SEMUA FIELD SAMA SEPERTI SIMPAN()
        $this->setDataToForm($rap);
    }

    private function setDataToForm($rap)
    {
        $this->rapId                    = $rap->id;

        $this->kewenangan               = $rap->kewenangan;
        $this->id_sub_kegiatan          = $rap->fkid_sub_kegiatan;
        $this->id_aktivitas_utama       = $rap->fkid_aktivitas_utama;
        $this->jenis_kegiatan           = $rap->jenis_kegiatan;

        $this->volume_tahun_berjalan    = $rap->volume_tahun_berjalan;
        $this->volume_silpa_melanjutkan = $rap->volume_silpa_melanjutkan;
        $this->volume_silpa_efisiensi   = $rap->volume_silpa_efisiensi;

        $this->satuan                   = $rap->satuan_volume;

        // format angka ke string berformat titik
        $this->pagu_tahun_berjalan      = number_format($rap->pagu_tahun_berjalan, 0, ',', '.');
        $this->pagu_silpa_melanjutkan   = number_format($rap->pagu_silpa_melanjutkan, 0, ',', '.');
        $this->pagu_silpa_efisiensi     = number_format($rap->pagu_silpa_efisiensi, 0, ',', '.');

        $this->sumber_dana              = $rap->sumber_dana;
        $this->lokasi                   = $rap->lokasi;
        $this->titik_lokasi             = $rap->titik_lokasi;
        $this->sasaran                  = $rap->sasaran;
        $this->ppsb                     = $rap->ppsb;
        $this->penerima_manfaat         = $rap->penerima_manfaat;
        $this->sinergi_dana_lain        = $rap->sinergi_dana_lain;
        $this->multiyears               = $rap->multiyears;

        $this->jadwal_awal              = $rap->jadwal_awal;
        $this->jadwal_akhir             = $rap->jadwal_akhir;

        $this->keterangan               = $rap->keterangan;

        $this->kode_klasifikasi         = $rap->kode_klasifikasi;
        $this->sub_kegiatan             = $rap->sub_kegiatan;
        $this->kinerja                  = $rap->kinerja;
        $this->indikator                = $rap->indikator;
        $this->klasifikasi_belanja      = $rap->klasifikasi_belanja;
        $this->aktivitas_utama          = $rap->aktivitas_utama;
        $this->tema_pembangunan         = $rap->tema_pembangunan;
        $this->program_prioritas        = $rap->program_prioritas;
        $this->target_keluaran_strategis= $rap->target_keluaran_strategis;
        $this->data_rka                 = $rap->data_rka;
        $this->data_kak                 = $rap->data_kak;
        $this->data_lainya              = $rap->data_lainya;
    }

    #[Layout('components.layouts.admin', ['pageTitle' => 'Detail Rencana Anggaran Program'])]
    public function render()
    {
        return view('livewire.user.LW_rap.rap-detail');
    }
}
