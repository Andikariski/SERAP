<?php
namespace App\Livewire\Admin\LWpagu;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PaguInduk as ModelPaguInduk;
use App\Models\Pagu as ModelsPaguOPD;
use Livewire\Attributes\On;


class PaguDetail extends Component
{
     #[Layout('components.layouts.admin',['pageTitle' => 'Detail Pagu'])]
    public function render()
    {
     // Ambil data tahun aktif dari tabel Pagu Induk
       $getTahunAktif = ModelPaguInduk::where('status', 'Aktif')->first();
       $paguInduk = ModelPaguInduk::where('tahun_pagu', $getTahunAktif->tahun_pagu)->first();

       $skpdOtsusSG = ModelsPaguOPD::where('tahun_pagu', $getTahunAktif->tahun_pagu)
                      ->where('pagu_SG', '>', 0)
                      ->count();
       $skpdOtsusBG = ModelsPaguOPD::where('tahun_pagu', $getTahunAktif->tahun_pagu)
                      ->where('pagu_BG', '>', 0)
                      ->count();
       $skpdOtsusDTI = ModelsPaguOPD::where('tahun_pagu', $getTahunAktif->tahun_pagu)
                      ->where('pagu_DTI', '>', 0)
                      ->count();
       $skpdOtsusSiLPAmelanjutkan = ModelsPaguOPD::where('tahun_pagu', $getTahunAktif->tahun_pagu)
                      ->where('pagu_DTI', '>', 0)
                      ->count();
       $skpdOtsusSiLPAefisiensi = ModelsPaguOPD::where('tahun_pagu', $getTahunAktif->tahun_pagu)
                      ->where('pagu_DTI', '>', 0)
                      ->count();

       return view('livewire.admin.LW_pagu.pagu-detail',
                  compact('getTahunAktif', 
                          'paguInduk', 
                          'skpdOtsusSG', 
                          'skpdOtsusBG', 
                          'skpdOtsusDTI',
                          'skpdOtsusSiLPAmelanjutkan',
                          'skpdOtsusSiLPAefisiensi'));
    }
}
