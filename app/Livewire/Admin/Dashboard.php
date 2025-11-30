<?php

namespace App\Livewire\Admin;

use App\Models\Pagu as ModelsPaguOPD;
use App\Models\PaguInduk as ModelsPaguInduk;
use App\Models\Rap as ModelsRap;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{

    public $data;
    public function mount()
    {
        // $this->data = ['total_anggaran' => 12000000];
        // dd($this->data); // 🔍 tampil sekali di browser waktu halaman dibuka
    }


    #[Layout('components.layouts.admin',['pageTitle' => 'Dashboard'])]
    public function render()
    {
        // Ambil tahun pagu aktif (bisa null)
        $getTahunAktif = ModelsPaguInduk::where('status', 'Aktif')->first();
        $tahunAktif = $getTahunAktif->tahun_pagu ?? null;   // Null-safe

        $userOpdId = Auth::user();
        $paguOPD = 0;

        // dd($tahunAktif);
        
        if ($userOpdId->is_admin == 0 && $userOpdId->opd_id) {
            // Ambil nilai total pagu dari OPD user yang login
            $paguOPD = ModelsPaguOPD::where('fkid_opd', $userOpdId->opd_id)
            ->where('tahun_pagu',date('Y'))->first();
        }

        
        $getPaguOPD = null;
        if ($getTahunAktif) {
            $getPaguOPD = ModelsPaguOPD::where('tahun_pagu', $getTahunAktif->tahun_pagu)
            ->where('fkid_opd', $userOpdId->opd_id)
            ->first();
        }

    
        // Perhitungan Pagu BG
        $totalPaguTerinputBG = 0;
        if ($getTahunAktif) {
        $totalPaguTerinputBG = ModelsRAP::where('fkid_opd', $userOpdId->opd_id)
            ->where('sumber_dana', 'Otsus 1%')
            ->whereYear('jadwal_awal', $getTahunAktif->tahun_pagu)
            ->sum('pagu_tahun_berjalan');
        }

        $paguSisaBG = 0;
        if ($getTahunAktif && $getPaguOPD) {
        $paguSisaBG = $getPaguOPD->pagu_BG - $totalPaguTerinputBG;
        }

        $persentaseInputBG = 0;
        if ($getPaguOPD && $getPaguOPD->pagu_BG > 0) {
            $persentaseInputBG = number_format(
                ($totalPaguTerinputBG / $getPaguOPD->pagu_BG) * 100,
                0,
                '.',
                ''
            );
        }

        // Perhitungan Pagu SG
        $totalPaguTerinputSG = 0;
        if ($getTahunAktif) {
        $totalPaguTerinputSG = ModelsRAP::where('fkid_opd', $userOpdId->opd_id)
            ->where('sumber_dana', 'Otsus 1,25%')
            ->whereYear('jadwal_awal', $getTahunAktif->tahun_pagu)
            ->sum('pagu_tahun_berjalan');
        }

        $paguSisaSG = 0;
        if ($getTahunAktif && $getPaguOPD) {
        $paguSisaSG = $getPaguOPD->pagu_SG - $totalPaguTerinputSG;
        }

        $persentaseInputSG = 0;
        if ($getPaguOPD && $getPaguOPD->pagu_SG > 0) {
            $persentaseInputSG = number_format(
                ($totalPaguTerinputSG / $getPaguOPD->pagu_SG) * 100,
                0,
                '.',
                ''
            );
        }

        // Perhitungan Pagu DTI
        $totalPaguTerinputDTI = 0;
        if ($getTahunAktif) {
        $totalPaguTerinputDTI = ModelsRAP::where('fkid_opd', $userOpdId->opd_id)
            ->where('sumber_dana', 'DTI')
            ->whereYear('jadwal_awal', $getTahunAktif->tahun_pagu)
            ->sum('pagu_tahun_berjalan');
        }

        $paguSisaDTI = 0;
        if ($getTahunAktif && $getPaguOPD) {
        $paguSisaDTI = $getPaguOPD->pagu_DTI - $totalPaguTerinputDTI;
        }

        $persentaseInputDTI = 0;
        if ($getPaguOPD && $getPaguOPD->pagu_DTI > 0) {
            $persentaseInputDTI = number_format(
                ($totalPaguTerinputDTI / $getPaguOPD->pagu_DTI) * 100,
                0,
                '.',
                ''
            );
        }
        return view('livewire.admin.dashboard',
                compact('paguOPD',
                        'getPaguOPD',
                        'tahunAktif',
                        'persentaseInputBG',
                        'totalPaguTerinputBG',
                        'paguSisaBG',
                        'persentaseInputSG',
                        'totalPaguTerinputSG',
                        'paguSisaSG',
                        'persentaseInputDTI',
                        'totalPaguTerinputDTI',
                        'paguSisaDTI'));

        // Masih ada erro di nilai pagu, jika admin login error karena admin tidak punya pagu tambahkan logika nanti
    }
}
