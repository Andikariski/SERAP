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

class CreateRap extends Component
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

    public $isEdit = false;
    public $rapId;

    public function mount(Request $request)
    {
        $type = $request->query('type');

        $this->sumber_dana = match ($type) {
            'rap-opd-sg' => 'Otsus 1,25%',
            'rap-opd-bg' => 'Otsus 1%',
            'rap-opd-dti' => 'DTI',
            default => null,
        };

        $this->getSisaPagu();
        $this->showSisaPagu = match ($type) {
            'rap-opd-sg' => $this->sisaPaguSG,
            'rap-opd-bg' => $this->sisaPaguBG,
            'rap-opd-dti'=> $this->sisaPaguDTI,
            default => null,
        };
    }

    public function getSisaPagu()
    {
        $opd = Auth::user()->opd_id;
        $tahunAktif = ModelPaguInduk::where('status', 'Aktif')->first();

        if (!$tahunAktif) {
            $this->sisaPaguBG = 0;
            $this->sisaPaguSG = 0;
            $this->sisaPaguDTI = 0;
            return;
        }

        $paguOPD = ModelPaguOPD::where('tahun_pagu', $tahunAktif->tahun_pagu)
                    ->where('fkid_opd', $opd)
                    ->first();

        if (!$paguOPD) {
            $this->sisaPaguBG = 0;
            $this->sisaPaguSG = 0;
            $this->sisaPaguDTI = 0;
            return;
        }

        // Total terinput
        $totalBG = ModelsRAP::where('fkid_opd', $opd)
                    ->where('sumber_dana', 'Otsus 1%')
                    ->whereYear('jadwal_awal', $tahunAktif->tahun_pagu)
                    ->sum('pagu_tahun_berjalan');

        $totalSG = ModelsRAP::where('fkid_opd', $opd)
                    ->where('sumber_dana', 'Otsus 1,25%')
                    ->whereYear('jadwal_awal', $tahunAktif->tahun_pagu)
                    ->sum('pagu_tahun_berjalan');

        $totalDTI = ModelsRAP::where('fkid_opd', $opd)
                    ->where('sumber_dana', 'DTI')
                    ->whereYear('jadwal_awal', $tahunAktif->tahun_pagu)
                    ->sum('pagu_tahun_berjalan');

        // Hitung sisa pagu sesuai sumber dana
        $this->sisaPaguBG  = $paguOPD->pagu_BG  - $totalBG;
        $this->sisaPaguSG  = $paguOPD->pagu_SG  - $totalSG;
        $this->sisaPaguDTI = $paguOPD->pagu_DTI - $totalDTI;
    }



    protected function rules()
    {
        $rules = [
            // 'idOpd'             => 'required',
            // 'id_sub_kegiatan'       => 'required',
            // 'id_aktivitas_utama'    => 'required',
            'jenis_kegiatan'        => 'required',
            'volume_tahun_berjalan' => 'required|integer',
            'pagu_tahun_berjalan'   => 'required',
            'sumber_dana'           => 'required',
            'lokasi'                => 'required',
            'sasaran'               => 'required',
            'ppsb'                  => 'required',
            'penerima_manfaat'      => 'required',
            'sinergi_dana_lain'     => 'required',
            'multiyears'            => 'required',
            'jadwal_awal'           => 'required',
            'jadwal_akhir'          => 'required',
        ];
        return $rules;
    }
    /**
     * Auto-fill field saat sub kegiatan berubah
     */

    public function resetFormAction(){
            $this->resetForm();
    }

    public function searchSubKegiatan(Request $request){
        $search = $request->input('q', '');
            $results = ModelSubKegiatan::query()
                ->when($search, fn($q) => $q->where('sub_kegiatan', 'like', "%{$search}%"))
                ->limit(30) // batasi biar ringan
                ->get(['id', 'sub_kegiatan']);
        return response()->json($results);
    }

    public function searchAktivitasUtama(Request $request){
        $search = $request->input('q', '');
            $results = ModelsAktivitas::query()
                ->when($search, fn($q) => $q->where('aktivitas_utama', 'like', "%{$search}%"))
                ->limit(30) // batasi biar ringan
                ->get(['id', 'aktivitas_utama']);
        return response()->json($results);
    }

    
    #[On('subKegiatanChanged')]
    public function onSubKegiatanChanged($id)
    {
        // dd($id);
    if (!$id) {
        $this->resetSubKegiatanFields();
        return;
    }
    $sub = ModelSubKegiatan::find($id);
        if ($sub) {
            $this->id_sub_kegiatan      = $id;
            $this->sub_kegiatan         = $sub->sub_kegiatan;
            $this->kewenangan           = $sub->kewenangan;
            $this->kode_klasifikasi     = $sub->kode_klasifikasi;
            $this->klasifikasi_belanja  = $sub->klasifikasi_belanja;
            $this->satuan               = $sub->satuan;
            $this->indikator            = $sub->indikator;
            $this->kinerja              = $sub->kinerja;
        } else {
            // $this->resetSubKegiatanFields();
        }
    }

    #[On('activitasUtamaChanged')]
    public function onActivitasUtamaChanged($id)
    {
        // dd($id);
    if (!$id) {
        $this->resetAktivitasUtamaFields();
        return;
    }
    $aktivitas = ModelsAktivitas::find($id);
        if ($aktivitas) {
            $this->id_aktivitas_utama       = $id;
            $this->aktivitas_utama          = $aktivitas->aktivitas_utama;
            $this->tema_pembangunan         = $aktivitas->tema_pembangunan;
            $this->program_prioritas        = $aktivitas->program_prioritas;
            $this->target_keluaran_strategis= $aktivitas->target_keluaran_strategis;

        } else {
            // $this->resetSubKegiatanFields();
        }
    }

    public function resetForm()
    {
        $this->reset([
            'kewenangan', 'id_sub_kegiatan', 'id_aktivitas_utama', 'jenis_kegiatan',
            'volume_tahun_berjalan', 'volume_silpa_melanjutkan', 'volume_silpa_efisiensi',
            'satuan', 'pagu_tahun_berjalan', 'pagu_silpa_melanjutkan', 'pagu_silpa_efisiensi',
            'lokasi', 'titik_lokasi', 'sasaran', 'ppsb', 'penerima_manfaat',
            'sinergi_dana_lain', 'multiyears', 'jadwal_awal', 'jadwal_akhir', 'keterangan',
            'kode_klasifikasi', 'sub_kegiatan', 'kinerja', 'indikator', 'klasifikasi_belanja',
            'aktivitas_utama', 'tema_pembangunan', 'program_prioritas', 'target_keluaran_strategis',
            'data_rka','data_kak','data_lainya'
        ]);

        // (Opsional) kalau masih pakai select2
        // $this->dispatch('reset-select2');
    }



   public function simpan()
    {
        $getTahunAktif = ModelPaguInduk::where('status', 'Aktif')->first();
        $opd = Auth::user()->opd_id;

        // Tentukan sumber dana
        $sumber_dana = $this->sumber_dana;

        // Ambil pagu jatah OPD berdasarkan sumber dana
        $getPaguOPD = ModelPaguOPD::where('fkid_opd', $opd)->first();

        $paguOPD = match ($this->sumber_dana) {
            'Otsus 1%'    => $getPaguOPD->pagu_BG,
            'Otsus 1,25%' => $getPaguOPD->pagu_SG,
            'DTI'         => $getPaguOPD->pagu_DTI,
        };

        // Hitung total pagu yang telah terpakai (hanya pagu_tahun_berjalan)
        $paguTerpakai = ModelsRap::where('fkid_opd', $opd)
            ->where('sumber_dana', $sumber_dana)
            ->whereYear('jadwal_awal', $getTahunAktif->tahun_pagu)
            ->sum('pagu_tahun_berjalan');

        // Bersihkan format titik menjadi integer
        $paguBerjalan    = (int) str_replace('.', '', $this->pagu_tahun_berjalan);
        $paguMelanjutkan = (int) str_replace('.', '', $this->pagu_silpa_melanjutkan);
        $paguEfisiensi   = (int) str_replace('.', '', $this->pagu_silpa_efisiensi);

        // Total pagu per record (dipakai untuk disimpan)
        $totalPagu = $paguBerjalan + $paguMelanjutkan + $paguEfisiensi;
        $volumeTotal = $this->volume_tahun_berjalan + $this->volume_silpa_melanjutkan + $this->volume_silpa_efisiensi;

        // VALIDASI: cek apakah pagu baru melebihi sisa pagu OPD
        $sisaPagu = $paguOPD - $paguTerpakai;

        if ($paguBerjalan > $sisaPagu) {
            $this->dispatch('failed-add-data', message: "Gagal, Pagu tahun berjalan melebihi sisa pagu ".$this->sumber_dana);
            return;
        }

        // Validasi form Livewire
        $this->validate();

        $kontrol = ModelsKontrol::where('tipe', 'RAP_Akses')->first();
        $cekDataRap = ModelsRap::where('kode_klasifikasi', $this->kode_klasifikasi)->first();

        if ($kontrol->status === 'Buka') {
            if (!$cekDataRap) {
                ModelsRap::create([
                    'kewenangan'                => $this->kewenangan,
                    'fkid_sub_kegiatan'         => $this->id_sub_kegiatan,
                    'fkid_aktivitas_utama'      => $this->id_aktivitas_utama,
                    'fkid_opd'                  => $opd,
                    'jenis_kegiatan'            => $this->jenis_kegiatan,
                    'volume_tahun_berjalan'     => $this->volume_tahun_berjalan,
                    'volume_silpa_melanjutkan'  => $this->volume_silpa_melanjutkan,
                    'volume_silpa_efisiensi'    => $this->volume_silpa_efisiensi,
                    'volume_total'              => $volumeTotal,
                    'satuan_volume'             => $this->satuan,
                    'pagu_tahun_berjalan'       => $paguBerjalan,
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
                    'satuan'                    => $this->satuan,
                    'klasifikasi_belanja'       => $this->klasifikasi_belanja,
                    'aktivitas_utama'           => $this->aktivitas_utama,
                    'tema_pembangunan'          => $this->tema_pembangunan,
                    'program_prioritas'         => $this->program_prioritas,
                    'target_keluaran_strategis' => $this->target_keluaran_strategis,
                ]);
                $this->dispatch('success-add-data', message: "Berhasil, RAP telah diInput");
                $this->resetForm();
            } else {
                $this->dispatch('failed-add-data', message: "Gagal, Sub kegiatan sudah terinput");
            }

        } else {
            $this->dispatch('failed-add-data', message: "Gagal, Status RAP Tutup");
        }
}



    #[Layout('components.layouts.admin', ['pageTitle' => 'Form Input Rencana Anggaran Program'])]
    public function render()
    {
        $subKegiatans = ModelSubKegiatan::all();
        $aktivitas = ModelsAktivitas::all();

        return view('livewire.user.LW_rap.rap-create');
    }
}
