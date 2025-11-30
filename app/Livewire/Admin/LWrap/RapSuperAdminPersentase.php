<?php

namespace App\Livewire\Admin\LWrap;

use App\Models\Pagu as PaguOpd;
use App\Models\PaguInduk as ModelPaguInduk;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;

class RapSuperAdminPersentase extends AdminSuperAdminAuth
{
    use WithPagination;
    public $search = '';

  #[Layout('components.layouts.admin',['pageTitle' => 'Data Persentase RAP'])]
    public function render()
    {
  
        // $tahun = 2029;
        $getTahunAktif = ModelPaguInduk::where('status', 'Aktif')->first();
        $tahunAktif = $getTahunAktif->tahun_pagu ?? null;

        // Ambil semua data terlebih dahulu (tanpa paginate)
        $collection = PaguOpd::with([
            'opd',
            'opd.rap' => function ($q) use ($tahunAktif) {
                $q->whereYear('jadwal_awal', $tahunAktif);
            }
        ])
        ->where('tahun_pagu', $tahunAktif)
        ->get()
        ->map(function ($item) {

            $paguBG  = $item->pagu_BG ?? 0;
            $paguSG  = $item->pagu_SG ?? 0;
            $paguDTI = $item->pagu_DTI ?? 0;

            $inputBG  = $item->opd->rap->where('sumber_dana', 'Otsus 1%')->sum('pagu_tahun_berjalan');
            $inputSG  = $item->opd->rap->where('sumber_dana', 'Otsus 1,25%')->sum('pagu_tahun_berjalan');
            $inputDTI = $item->opd->rap->where('sumber_dana', 'DTI')->sum('pagu_tahun_berjalan');

            // Persen per kolom
            $item->persen_BG  = $paguBG > 0  ? round(($inputBG  / $paguBG)  * 100, 2) : '-';
            $item->persen_SG  = $paguSG > 0  ? round(($inputSG  / $paguSG)  * 100, 2) : '-';
            $item->persen_DTI = $paguDTI > 0 ? round(($inputDTI / $paguDTI) * 100, 2) : '-';

            // Total persen
            $totalPagu  = ($paguBG > 0 ? $paguBG : 0) + ($paguSG > 0 ? $paguSG : 0) + ($paguDTI > 0 ? $paguDTI : 0);
            $totalInput = ($paguBG > 0 ? $inputBG : 0) + ($paguSG > 0 ? $inputSG : 0) + ($paguDTI > 0 ? $inputDTI : 0);

            $item->persen_total = $totalPagu > 0 ? round(($totalInput / $totalPagu) * 100, 2) : 0;

            return $item;
        })
        ->sortByDesc('persen_total'); // 🔥 URUTKAN DARI TERTINGGI
        
        // ==== MANUAL PAGINATE ====
        // $perPage = 50;
        // $page = request()->get('page', 1);
        // $data = new \Illuminate\Pagination\LengthAwarePaginator(
        //     $collection->forPage($page, $perPage),
        //     $collection->count(),
        //     $perPage,
        //     $page,
        //     ['path' => request()->url(), 'query' => request()->query()]
        // );
        $data = $collection;

        return view('livewire.admin.LW_rap.rap-super-admin-persentase',compact('data','tahunAktif'));
    }
}
