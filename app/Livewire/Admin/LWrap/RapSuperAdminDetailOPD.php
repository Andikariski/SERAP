<?php

namespace App\Livewire\Admin\LWrap;

use App\Models\Opd;
use App\Models\PaguInduk as ModelPaguInduk;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Pagu as ModelPaguOPD;
use App\Models\Rap as ModelsRAP;
use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;

class RapSuperAdminDetailOPD extends AdminSuperAdminAuth
{
    use WithPagination;
    public $id;
    public $searchBG = '';
    public $searchSG = '';
    public $searchDTI = '';

    #[Layout('components.layouts.admin',['pageTitle' => 'Detail Input RAP OPD'])]
    public function render()
    {
        //Ganti dengan Get id by button arrow click
        $opd = $this->id;

        $detailOpd = Opd::where('id',$opd)->first();

        // Ambil tahun pagu aktif (bisa null)
        $getTahunAktif = ModelPaguInduk::where('status', 'Aktif')->first();
        $tahunAktif = $getTahunAktif->tahun_pagu ?? null;   // Null-safe

        // $rapsBG = ModelsRAP::where('fkid_opd', $opd)
        //     ->where('sumber_dana', 'Otsus 1%')
        //     ->where('sub_kegiatan', 'like', "%{$this->searchBG}%")
        //     ->whereYear('jadwal_awal', $tahunAktif)
        //     Hanya jalankan whereYear jika $tahunAktif BUKAN null
        //     ->paginate(10);


        $rapsBG = ModelsRAP::where('fkid_opd', $opd)
            ->where('sumber_dana', 'Otsus 1%')
            ->where('sub_kegiatan', 'like', "%{$this->searchBG}%")
            // Hanya jalankan whereYear jika $tahunAktif BUKAN null
            ->when($tahunAktif, function ($query) use ($tahunAktif) {
                return $query->whereYear('jadwal_awal', $tahunAktif);
            })
            ->paginate(10);

        $rapsSG = ModelsRAP::where('fkid_opd', $opd)
            ->where('sumber_dana', 'Otsus 1,25%')
            ->where('sub_kegiatan', 'like', "%{$this->searchSG}%")
            // Hanya jalankan whereYear jika $tahunAktif BUKAN null
            ->when($tahunAktif, function ($query) use ($tahunAktif) {
                return $query->whereYear('jadwal_awal', $tahunAktif);
            })
            ->paginate(10);

        $rapsDTI = ModelsRAP::where('fkid_opd', $opd)
            ->where('sumber_dana', 'DTI')
            ->where('sub_kegiatan', 'like', "%{$this->searchDTI}%")
            // Hanya jalankan whereYear jika $tahunAktif BUKAN null
            ->when($tahunAktif, function ($query) use ($tahunAktif) {
                return $query->whereYear('jadwal_awal', $tahunAktif);
            })
            ->paginate(10);


        return view('livewire.admin.LW_rap.rap-super-admin-detail-opd', 
                compact(
                    'detailOpd',
                    'rapsBG',
                    'rapsSG',
                    'rapsDTI'
                ));
    }
}
