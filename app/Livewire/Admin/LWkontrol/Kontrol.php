<?php

namespace App\Livewire\Admin\LWkontrol;

use App\Models\Kontrol as ModelKontrol;
use App\Models\SubKegiatan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;

class Kontrol extends AdminSuperAdminAuth
{
     public $statusRAP;
     public $statusAkses;

    public function mount()
    {
        if (!Auth::check() || Auth::user()->is_admin != 1) {
             abort(404);
        }
        $this->loadStatus();
    }

    public function loadStatus()
    {
        $kontrol = ModelKontrol::firstOrCreate(
            ['tipe' => 'RAP_Akses'],
            ['status' => 'Tutup']
        );
        $this->statusAkses = $kontrol->status;

          // Status Tahapan RAP (Awal / Perubahan II / Perubahan III)
        $kontrol = ModelKontrol::firstOrCreate(
            ['tipe' => 'RAP_Status'],
            ['status' => 'RAP Awal']
        );
        $this->statusRAP = $kontrol->status;
    }

    public function toggleStatusAksesRAP()
    {
        $kontrol = ModelKontrol::where('tipe', 'RAP_Akses')->first();
        if ($kontrol) {
            $kontrol->status = $kontrol->status == 'Buka' ? 'Tutup' : 'Buka';
            $kontrol->save();
            $this->statusAkses = $kontrol->status; // langsung update tampilan
        }
        // Refresh otomatis komponen agar tampilan ikut berubah
        $this->dispatch('succes-change',message: "Status RAP Telah di {$this->statusAkses}");
    }

    public function toggleStatusRAP($status)
    {
        $kontrol = ModelKontrol::where('tipe', 'RAP_Status')->first();
        if ($kontrol) {
            $kontrol->status = $status;
            $kontrol->save();
            $this->statusRAP = $status;
        }

        $this->dispatch('succes-change', message: "Status RAP berhasil diubah menjadi {$status}");
    }

    #[Layout('components.layouts.admin',['pageTitle' => 'Kontrol Akses & Status RAP'])]
    public function render()
    {
        return view('livewire.admin.LW_kontrol.kontrol');
    }
}
