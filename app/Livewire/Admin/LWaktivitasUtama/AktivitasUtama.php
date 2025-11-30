<?php

namespace App\Livewire\Admin\LWaktivitasUtama;

use App\Models\AktivitasUtama as ModelsAktivitasUtama;
use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;


class AktivitasUtama extends AdminSuperAdminAuth
{

    // Modal state
    public $showModal = false;
    public $showDetailModal = false;

    public $showImportModal = false;
    public $file;
    public $modalTitle = '';
    public $search = '';
    public $isEdit = false;

    // Fungsi buka modal
    public function openImportModal()
    {
        // dd("Tombol Berfungsi");
        $this->reset('file');
        $this->showImportModal = true;

    }

    public function openTambahModal()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->modalTitle = 'Aktivitas Utama';
        $this->showModal = true;
    }
  
    #[Layout('components.layouts.admin',['pageTitle' => 'Sub Kegiatan'])]
    public function render()
    {

        $aktivitasUtamas = ModelsAktivitasUtama::query()
                    ->where('aktivitas_utama', 'like', "%{$this->search}%")
                    ->paginate(10);

        return view('livewire.admin.LW_aktivitasUtama.aktivitas-utama', compact('aktivitasUtamas'));
    }
}
