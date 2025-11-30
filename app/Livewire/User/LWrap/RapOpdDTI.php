<?php

namespace App\Livewire\User\LWrap;

use App\Models\Kontrol as ModelKontrol;
use App\Models\Rap as ModelsRAP;
use App\Models\SubKegiatan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Pagu as ModelPaguOPD;
use App\Models\PaguInduk as ModelPaguInduk;

class RapOpdDTI extends Component
{
    public $statusRAP;
    public $statusAkses;
    public $search = '';

    public function mount()
    {
        $this->loadStatus();
    }

    public function loadStatus()
    {
        $kontrol = ModelKontrol::firstOrCreate(
            ['tipe' => 'RAP_Akses'],
            ['status' => 'Tutup']
        );
        $this->statusAkses = $kontrol->status;

        $kontrol = ModelKontrol::firstOrCreate(
            ['tipe' => 'RAP_Status'],
            ['status' => 'RAP Awal']
        );
        $this->statusRAP = $kontrol->status;
    }

    public function redirectToCreate()
    {
        if ($this->status === 'Tutup') {
            // Kirim notifikasi ke browser
            $this->dispatch('success-add-data',message: "Akses belum dibuka.");
        } else {
            // Redirect ke halaman input RAP
            return redirect()->route('rap.create');
        }
    }

    #[On('delete-data-RAPDTI')]
    public function hapus($id)
    {
    try {
            $rap = ModelsRAP::find($id);
                $rap->delete();
                $this->dispatch('success-delete-data',message:  "Berhasil, Sub Kegiatan berhasil dihapus.");
                // $this->closeModal();
                return;
            
        } catch (\Exception $e) {
            $this->dispatch('failed-delete-data',message: 'Gagal, Sub kegiatan tidak terhapus');
        }
    }

     #[Layout('components.layouts.admin',['pageTitle' => 'Data RAP DTI'])]
     public function render()
    {
        $opd = Auth::user()->opd_id;

        // Ambil tahun pagu aktif (bisa null)
        $getTahunAktif = ModelPaguInduk::where('status', 'Aktif')->first();
        $tahunAktif = $getTahunAktif->tahun_pagu ?? null;   // Null-safe

        $raps = ModelsRAP::where('fkid_opd', $opd)
            ->where('sumber_dana', 'DTI')
            ->when($tahunAktif, function ($query) use ($tahunAktif) {
                $query->whereYear('jadwal_awal', $tahunAktif);
            })
            ->when($this->search, function ($query) {
                $search = $this->search;
                $query->where(function ($q) use ($search) {
                    $q->where('kode_klasifikasi', 'like', "%{$search}%")
                    ->orWhere('sub_kegiatan', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

            // Cek apakah data aktif ada
            $getPaguOPD = null;
            if ($getTahunAktif) {
                $getPaguOPD = ModelPaguOPD::where('tahun_pagu', $getTahunAktif->tahun_pagu)
                                        ->where('fkid_opd', $opd)
                                        ->first();
            }

            $totalPaguTerinput = 0;
            if ($getTahunAktif) {
            $totalPaguTerinput = ModelsRAP::where('fkid_opd', $opd)
                ->where('sumber_dana', 'DTI')
                ->whereYear('jadwal_awal', $getTahunAktif->tahun_pagu)
                ->sum('pagu_tahun_berjalan');
            }

            $paguSisa = 0;
            if ($getTahunAktif && $getPaguOPD) {
            $paguSisa = $getPaguOPD->pagu_DTI - $totalPaguTerinput;
            }

            $persentaseInput = 0;
            if ($getPaguOPD && $getPaguOPD->pagu_DTI > 0) {
                $persentaseInput = number_format(
                    ($totalPaguTerinput / $getPaguOPD->pagu_DTI) * 100,
                    0,
                    '.',
                    ''
                );
            }

            $totalSubKegiatan = 0;
            if ($getTahunAktif) {
            $totalSubKegiatan = ModelsRAP::where('fkid_opd', $opd)
                ->where('sumber_dana', 'DTI')
                ->whereYear('jadwal_awal', $getTahunAktif->tahun_pagu)
                ->count('kode_klasifikasi');
            }

        return view('livewire.user.LW_rap.rap-opd-DTI', 
                    compact(
                        'raps', 
                        'getPaguOPD', 
                        'tahunAktif',
                        'totalPaguTerinput',
                        'paguSisa',
                        'persentaseInput',
                        'totalSubKegiatan'));
        }
}
