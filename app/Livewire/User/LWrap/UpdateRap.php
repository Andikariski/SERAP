<?php

namespace App\Livewire\User\LWrap;

use App\Models\Pagu as ModelPaguOPD;
use App\Models\AktivitasUtama as ModelsAktivitas;
use App\Models\Kontrol as ModelsKontrol;
use App\Models\PaguInduk as ModelPaguInduk;
use App\Models\Rap as ModelsRap;
use App\Models\SubKegiatan as ModelSubKegiatan;


use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UpdateRap extends Component
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

        // Proses hitung sisa Pagu
        $this->rapId = $id;
        $rap = ModelsRap::findOrFail($id);
        $this->sisa_pagu_form = $this->hitungSisaPagu();
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


    public function hitungSisaPagu()
    {
        $getTahunAktif = ModelPaguInduk::where('status', 'Aktif')->first();
        $opd = Auth::user()->opd_id;

        if (!$getTahunAktif) {
            return 0; // fallback aman
        }

        $sumber_dana = $this->sumber_dana;

        // Ambil pagu jatah OPD
        $getPaguOPD = ModelPaguOPD::where('fkid_opd', $opd)->first();

        $paguOPD = match ($sumber_dana) {
            'Otsus 1%'    => $getPaguOPD->pagu_BG,
            'Otsus 1,25%' => $getPaguOPD->pagu_SG,
            'DTI'         => $getPaguOPD->pagu_DTI,
            default       => 0,
        };

        // Total pagu terpakai
        $paguTerpakai = ModelsRap::where('fkid_opd', $opd)
            ->where('sumber_dana', $sumber_dana)
            ->whereYear('jadwal_awal', $getTahunAktif->tahun_pagu)
            ->sum('pagu_tahun_berjalan');

        // Kurangi record yang sedang di-edit agar tidak double
        $rap = ModelsRap::find($this->rapId);
        if ($rap) {
            $paguTerpakai -= (int) $rap->pagu_tahun_berjalan;
        }

        // Final sisa pagu
        return $paguOPD - $paguTerpakai;
    }


    public function update()
    {

    // ============================
    // 1. Ambil pagu aktif + OPD
    // ============================
    $getTahunAktif = ModelPaguInduk::where('status', 'Aktif')->first();
    $opd = Auth::user()->opd_id;

    // 2. Tentukan sumber dana
    $sumber_dana = $this->sumber_dana;

    // 3. Ambil pagu jatah OPD
    $getPaguOPD = ModelPaguOPD::where('fkid_opd', $opd)->first();

    $paguOPD = match ($this->sumber_dana) {
        'Otsus 1%'    => $getPaguOPD->pagu_BG,
        'Otsus 1,25%' => $getPaguOPD->pagu_SG,
        'DTI'         => $getPaguOPD->pagu_DTI,
    };

    // ============================================
    // 4. Hitung total pagu terpakai termasuk tahun berjalan
    // ============================================
    $paguTerpakai = ModelsRap::where('fkid_opd', $opd)
        ->where('sumber_dana', $sumber_dana)
        ->whereYear('jadwal_awal', $getTahunAktif->tahun_pagu)
        ->sum('pagu_tahun_berjalan');

    // ============================================
    // 5. Ambil pagu TAHUN BERJALAN lama record ini
    // ============================================
    $rap = ModelsRap::findOrFail($this->rapId);
    $paguLama = (int) $rap->pagu_tahun_berjalan;

    // ============================================
    // 6. Kurangi pagu lama agar validasi tidak dobel
    // ============================================
    $paguTerpakai = $paguTerpakai - $paguLama;

    // ============================================
    // 7. Ambil pagu baru dari input
    // ============================================
    $paguBaru = (int) str_replace('.', '', $this->pagu_tahun_berjalan);

    // ============================================
    // 8. Hitung sisa pagu
    // ============================================
    $sisaPagu = $paguOPD - $paguTerpakai;

    // ============================================
    // 9. VALIDASI: apakah pagu baru melebihi sisa?
    // ============================================
    if ($paguBaru > $sisaPagu) {
        $this->dispatch(
            'failed-add-data',
            message: "Gagal, pagu tahun berjalan melebihi sisa pagu " . $this->sumber_dana
        );
        return;
    }

    // ============================================
    // 10. Proses update (AMAN)
    // ============================================
    $paguMelanjutkan = (int) str_replace('.', '', $this->pagu_silpa_melanjutkan);
    $paguEfisiensi   = (int) str_replace('.', '', $this->pagu_silpa_efisiensi);

    $totalPagu = $paguBaru + $paguMelanjutkan + $paguEfisiensi;
    $volumeTotal = $this->volume_tahun_berjalan + $this->volume_silpa_melanjutkan + $this->volume_silpa_efisiensi;

    $rap->update([
        'kewenangan'                => $this->kewenangan,
        'fkid_sub_kegiatan'         => $this->id_sub_kegiatan,
        'fkid_aktivitas_utama'      => $this->id_aktivitas_utama,
        'jenis_kegiatan'            => $this->jenis_kegiatan,

        'volume_tahun_berjalan'     => $this->volume_tahun_berjalan,
        'volume_silpa_melanjutkan'  => $this->volume_silpa_melanjutkan,
        'volume_silpa_efisiensi'    => $this->volume_silpa_efisiensi,
        'volume_total'              => $volumeTotal,

        'satuan_volume'             => $this->satuan,

        'pagu_tahun_berjalan'       => $paguBaru,
        'pagu_silpa_melanjutkan'    => $paguMelanjutkan,
        'pagu_silpa_efisiensi'      => $paguEfisiensi,
        'pagu_total'                => $totalPagu,

        'sumber_dana'               => $this->sumber_dana,
        'lokasi'                    => $this->lokasi,
        'titik_lokasi'              => $this->titik_lokasi,
        'sasaran'                   => $this->sasaran,
        'ppsb'                      => $this->ppsb,
        'penerima_manfaat'          => $this->penerima_manfaat,
        'sinergi_dana_lain'         => $this->sinergi_dana_lain,
        'multiyears'                => $this->multiyears,

        'jadwal_awal'               => $this->jadwal_awal,
        'jadwal_akhir'              => $this->jadwal_akhir,
        'keterangan'                => $this->keterangan,

        'kode_klasifikasi'          => $this->kode_klasifikasi,
        'sub_kegiatan'              => $this->sub_kegiatan,
        'kinerja'                   => $this->kinerja,
        'indikator'                 => $this->indikator,
        'klasifikasi_belanja'       => $this->klasifikasi_belanja,
        'aktivitas_utama'           => $this->aktivitas_utama,
        'tema_pembangunan'          => $this->tema_pembangunan,
        'program_prioritas'         => $this->program_prioritas,
        'target_keluaran_strategis' => $this->target_keluaran_strategis,
    ]);

    $this->dispatch('succes-change-data', message: "Berhasil, RAP berhasil diperbarui!");


    $redirectMap = [
    'rap-opd-bg'  => '/rap-opd-bg',
    'rap-opd-sg'  => '/rap-opd-sg',
    'rap-opd-dti' => '/rap-opd-dti',
    ];

    // Ambil BASE PATH
    $path = $redirectMap[$this->type] ?? '/rap-opd-bg';

    // Buat URL lengkap
    $url = $path . '?type=' . $this->type;

    // Dispatch event untuk redirect
    $this->dispatch(
        'redirect-with-delay',
        url: $url,
        delay: 2000
    );

}

    #[Layout('components.layouts.admin', ['pageTitle' => 'Form Update Rencana Anggaran Program'])]
    public function render()
    {
        return view('livewire.user.LW_rap.rap-update');
    }
}
