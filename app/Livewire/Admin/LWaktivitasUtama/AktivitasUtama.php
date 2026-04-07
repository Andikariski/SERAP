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

    public $aktivitasUtamaId = '';

    public $aktivitas_utama;
    public $tema_pembangunan;
    public $program_prioritas;
    public $target_keluaran_strategis;

    public $aktivitasUtamaValue;
    public $temaPembangunan;
    public $programPrioritas;
    public $targetKeluaranStrategis;

    protected function rules()
    {
        $rules = [
            'temaPembangunan'           => 'required',
            'aktivitasUtamaValue'       => 'required',
            'programPrioritas'          => 'required',
            'targetKeluaranStrategis'   => 'required',
        ];
        return $rules;
    }


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

      public function openDetailModal($aktivitasUtamaId)
    {
       $aktivitasUtamas = ModelsAktivitasUtama::find($aktivitasUtamaId);
       
        if ($aktivitasUtamas) {
            $this->aktivitasUtamaId = $aktivitasUtamas->id;
            $this->temaPembangunan = $aktivitasUtamas->tema_pembangunan;
            $this->aktivitasUtamaValue = $aktivitasUtamas->aktivitas_utama;
            $this->programPrioritas = $aktivitasUtamas->program_prioritas;
            $this->targetKeluaranStrategis = $aktivitasUtamas->target_keluaran_strategis;
            $this->isEdit = true;
            $this->modalTitle = 'Detail Data Aktivitas Utama';
            $this->showDetailModal = true;
        }
    }

    public function openEditModal($aktivitasUtamaId)
    {
        $aktivitasUtamas = ModelsAktivitasUtama::find($aktivitasUtamaId);
        if ($aktivitasUtamas) {

            $this->aktivitasUtamaId = $aktivitasUtamas->id;
            $this->temaPembangunan = $aktivitasUtamas->tema_pembangunan;
            $this->aktivitasUtamaValue = $aktivitasUtamas->aktivitas_utama;
            $this->programPrioritas = $aktivitasUtamas->program_prioritas;
            $this->targetKeluaranStrategis = $aktivitasUtamas->target_keluaran_strategis;
            $this->isEdit = true;
            $this->modalTitle = 'Edit Data Aktivitas Utama';
            $this->showModal = true;
        }
    }

     public function resetForm()
    {
        $this->aktivitasUtamaValue = '';
        $this->temaPembangunan = '';
        $this->programPrioritas = '';
        $this->targetKeluaranStrategis = '';
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

    #[On('delete-data-aktivitasUtama')]
    public function hapus($id)
    {
        try {
            $aktivitasUtama = ModelsAktivitasUtama::find($id);
                $aktivitasUtama->delete();
                $this->dispatch('success-delete-data',message:  "Aktivitas utama {$aktivitasUtama->aktivitas_utama} berhasil dihapus.");
                $this->closeModal();
            
        } catch (\Exception $e) {
            $this->dispatch('failed-delete-data',message: 'Gagal Menghapus Data Aktivitas Utama');
        }
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

    public function simpan()
    {
        // 1. Validasi input
        $this->validate();
        
        //Tentukan logika edit / tambah
        if ($this->isEdit) {
            // Update data
            $data = ModelsAktivitasUtama::findOrFail($this->aktivitasUtamaId);
            $data->update([
                'tema_pembangunan'      => $this->temaPembangunan,
                'aktivitas_utama'       => $this->aktivitasUtamaValue,
                'program_prioritas'     => $this->programPrioritas,
                'target_keluaran_strategis' => $this->targetKeluaranStrategis,
            ]);

            $this->dispatch('success-add-data', message: "Aktivitas utama berhasil diperbarui.");
        } else {
            // Tambah data baru
            ModelsAktivitasUtama::create([
                'tema_pembangunan'      => $this->temaPembangunan,
                'aktivitas_utama'       => $this->aktivitasUtamaValue,
                'program_prioritas'     => $this->programPrioritas,
                'target_keluaran_strategis' => $this->targetKeluaranStrategis,
            ]);
            $this->dispatch('success-add-data', message: "Aktivitas utama berhasil ditambahkan.");
        }

        //Tutup modal dan reset input
        $this->closeModal();
    }
  
    #[Layout('components.layouts.admin',['pageTitle' => 'Aktivitas Utama'])]
    public function render()
    {

        $aktivitasUtamas = ModelsAktivitasUtama::query()
                    ->where('aktivitas_utama', 'like', "%{$this->search}%")
                    ->paginate(10);

        return view('livewire.admin.LW_aktivitasUtama.aktivitas-utama', compact('aktivitasUtamas'));
    }
}
