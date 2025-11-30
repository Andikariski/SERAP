<?php

namespace App\Livewire\User\LWrap;

use App\Models\Kontrol as ModelKontrol;
use App\Models\Pagu as ModelPaguOPD;
use App\Models\PaguInduk as ModelPaguInduk;
use App\Models\Rap as ModelsRAP;
use App\Models\SubKegiatan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HistoryRapExport;
use App\Exports\RapExport;

class RapOpdRiwayat extends Component
{
    public $statusRAP;
    public $statusAkses;
    public $search = '';

    public $filterSumberDana = '';
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
        // Jika filter kosong, isi dengan teks default
        $opd = Auth::user()->opd_id;
        $sumber = $this->filterSumberDana ?: 'Semua Sumber Dana';
        $tahun  = $this->filterTahun ?: 'Semua Tahun';

        $filename = "Riwayat RAP {$namaOpd} {$sumber}, {$tahun}.xlsx";

        return Excel::download(new RapExport($data), $filename);
    }



    #[Layout('components.layouts.admin',['pageTitle' => 'Data Riwayat RAP '])]
    public function render()
    {
    $opd = Auth::user()->opd_id;
    //  Ambil daftar RAP
    $raps = ModelsRAP::where('fkid_opd', $opd)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('kode_klasifikasi', 'like', "%{$this->search}%")
                    ->orWhere('sub_kegiatan', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterTahun, function ($query) {
                $query->whereYear('jadwal_awal', $this->filterTahun);
            })
            ->when($this->filterSumberDana, function ($query) {
                $query->where('sumber_dana', $this->filterSumberDana);
            })
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

    // dd($tahuns);

    return view('livewire.user.LW_rap.rap-opd-Riwayat', 
            compact(
                'raps', 
                'getPaguOPD', 
                'getTahunAktif',
                'tahuns',
                'pagus'
            ));
    }

}
