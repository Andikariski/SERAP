<?php

namespace App\Livewire\Admin\LWrap;

use App\Models\Kontrol as ModelKontrol;
use App\Models\SubKegiatan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\Pagu as ModelPaguOPD;
use App\Models\PaguInduk as ModelPaguInduk;
use App\Models\Rap as ModelsRAP;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RapExport;

use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;


class RapSuperAdmin extends AdminSuperAdminAuth
{
    public $status;
    public $statusRAP;
    public $statusAkses;
    public $search = '';

    public $filterSumberDana = '';
    public $filterOpd = '';
    public $filterTahun = '';


public function getFilteredData()
{
    return ModelsRAP::query()
        ->when($this->filterTahun, fn($q) =>
            $q->whereYear('jadwal_awal', $this->filterTahun)
        )
        ->when($this->filterSumberDana, fn($q) =>
            $q->where('sumber_dana', $this->filterSumberDana)
        )
        ->where('tbl_rap.fkid_opd', $this->filterOpd) // ✅ filter OPD login
        ->leftJoin('tbl_opd', 'tbl_opd.id', '=', 'tbl_rap.fkid_opd') // JOIN relasi OPD
        ->select(
            'tbl_rap.kewenangan',
            'tbl_rap.kode_klasifikasi',
            'tbl_rap.sub_kegiatan',
            'tbl_rap.kinerja',
            'tbl_rap.indikator',
            'tbl_rap.klasifikasi_belanja',
            'tbl_rap.aktivitas_utama',
            'tbl_rap.jenis_kegiatan',
            'tbl_rap.tema_pembangunan',
            'tbl_rap.program_prioritas',
            'tbl_rap.target_keluaran_strategis',
            'tbl_rap.volume_tahun_berjalan',
            'tbl_rap.volume_silpa_melanjutkan',
            'tbl_rap.volume_silpa_efisiensi',
            'tbl_rap.volume_total',
            'tbl_rap.satuan_volume',
            'tbl_rap.pagu_tahun_berjalan',
            'tbl_rap.pagu_silpa_melanjutkan',
            'tbl_rap.pagu_silpa_efisiensi',
            'tbl_rap.pagu_total',
            'tbl_rap.sumber_dana',
            'tbl_rap.lokasi',
            'tbl_rap.titik_lokasi',
            'tbl_rap.sasaran',
            'tbl_rap.ppsb',
            'tbl_rap.penerima_manfaat',
            'tbl_rap.sinergi_dana_lain',
            'tbl_rap.multiyears',
            'tbl_rap.jadwal_awal',
            'tbl_rap.jadwal_akhir',
            'tbl_rap.validasi',
            'tbl_rap.data_rka',
            'tbl_rap.data_kak',
            'tbl_rap.data_lainya',
            'tbl_opd.kode_opd as opd',   // → AMBIL NAMA OPD
            'tbl_rap.keterangan'
        )
        ->get();
    }

    public function exportExcel()
    {
        $namaOpd = Auth::user()->opd->kode_opd;
        $this->dispatch('export-start');
        $data = $this->getFilteredData();
         // ✅ cek jika data kosong
        if ($data->isEmpty()) {
            $this->dispatch('export-failed',message: 'Data Tidak tersedia untuk di export');
            return;
        }
        // Jika filter kosong, isi dengan teks default
        $opd = ModelsRAP::where('fkid_opd', $this->filterOpd)->first();
        $NamaOpd = $opd ? $opd->opd->kode_opd : 'Semua OPD';
   
        $sumber = $this->filterSumberDana ?: 'Semua Sumber Dana';
        $tahun  = $this->filterTahun ?: 'Semua Tahun';

        $filename = "Riwayat RAP {$sumber} {$NamaOpd}, Tahun {$tahun}.xlsx";

        return Excel::download(new RapExport($data), $filename);
    }


     #[Layout('components.layouts.admin',['pageTitle' => 'Data Rencana Anggaran Program'])]
    public function render()
    {
    $opd = Auth::user()->opd_id;
    //  Ambil daftar RAP
    $user = Auth::user();


    $raps = ModelsRAP::query()
        ->when(!$user->is_admin, fn($q) => 
            $q->where('fkid_opd', $user->opd_id)
        )
        ->when($this->search, fn($q) =>
            $q->where(fn($q2) =>
                $q2->where('kode_klasifikasi', 'like', "%{$this->search}%")
                ->orWhere('sub_kegiatan', 'like', "%{$this->search}%")
            )
        )
        ->when($this->filterTahun, function ($query) {
                $query->whereYear('jadwal_awal', $this->filterTahun);
            })
        ->when($this->filterOpd, fn($q) =>
            $q->where('fkid_opd', $this->filterOpd)
        )
        ->when($this->filterSumberDana, fn($q) =>
            $q->where('sumber_dana', $this->filterSumberDana)
        )
        ->latest()
        ->paginate(10);

    // Ambil tahun pagu aktif (bisa null)
    $getTahunAktif = ModelPaguInduk::where('status', 'Aktif')->first();

    // Cek apakah data aktif ada
    $getPaguOPD = null;
    if ($getTahunAktif) {
        $getPaguOPD = ModelPaguOPD::where('tahun_pagu', $getTahunAktif->tahun_pagu)
                                ->where('fkid_opd', $opd)
                                ->first();
    }

    
    $tahuns = ModelsRAP::selectRaw('YEAR(jadwal_awal) as tahun')
    ->distinct()
    ->orderBy('tahun', 'desc')
    ->pluck('tahun');

    $pagus = ModelsRAP::selectRaw('sumber_dana as pagus')
    ->distinct()
    ->orderBy('pagus', 'desc')
    ->pluck('pagus');

    $opds = ModelsRAP::select('fkid_opd')
    ->with('opd')
    ->distinct()
    ->get();

    // dd($raps);

    // dd($tahuns);

    return view('livewire.admin.LW_rap.rap-super-admin', 
            compact(
                'raps', 
                'getPaguOPD', 
                'getTahunAktif',
                'tahuns',
                'pagus',
                'opds'
            ));
    }
}
