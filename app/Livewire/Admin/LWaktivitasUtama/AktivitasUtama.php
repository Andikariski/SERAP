<?php

namespace App\Livewire\Admin\LWaktivitasUtama;

use App\Imports\AktivitasUtama as AktivitasUtamaImport;
use App\Models\AktivitasUtama as ModelsAktivitasUtama;
use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;


class AktivitasUtama extends AdminSuperAdminAuth
{
    use WithPagination, WithFileUploads;
    // Modal state
    public $showModal = false;
    public $showDetailModal = false;

    public $showImportModal = false;
    public $file;
    public $modalTitle = '';
    public $search = '';
    public $isEdit = false;

    public $aktivitas_utama;
    public $tema_pembangunan;
    public $program_prioritas;
    public $target_keluaran_strategis;

    // Fungsi buka modal
    public function openImportModal()
    {
        $this->modalTitle = 'Aktivitas Utama';
        $this->reset('file');
        $this->showImportModal = true;

    }

    public function openTambahModal()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->modalTitle = 'Tambah Aktivitas Utama';
        $this->showModal = true;
    }

     public function resetForm()
    {
        $this->aktivitas_utama = '';
        $this->tema_pembangunan = '';
        $this->program_prioritas = '';
        $this->target_keluaran_strategis = '';
        $this->isEdit = false;
        $this->resetErrorBag();
    }

     public function closeModal()
    {
        $this->showModal = false;
        $this->showImportModal = false;
        $this->showDetailModal = false;
        $this->resetForm();
    }

        // 🔹 Fungsi untuk memproses file upload & import ke database
    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // max 10MB
        ], [
            'file.required' => 'Pilih file Excel terlebih dahulu.',
            'file.mimes' => 'Format file harus .xlsx, .xls, atau .csv.',
        ]);

        try {
            // Proses import file menggunakan Maatwebsite Excel
            Excel::import(new AktivitasUtamaImport, $this->file->getRealPath());
            $this->dispatch('success-add-data', message: "Aktivitas utama berhasil diimport.");

        } catch (\Exception $e) {
            $this->dispatch('error-add-data', message: "Terjadi kesalahan saat import: {$e->getMessage()}");
        }

        $this->reset('file');
        $this->showImportModal = false;
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
