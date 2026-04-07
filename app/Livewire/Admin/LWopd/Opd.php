<?php

namespace App\Livewire\Admin\LWopd;

use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Exception;
use Livewire\Attributes\On;
use App\Models\Opd as ModelsOpd;
use Livewire\WithPagination;

class Opd extends AdminSuperAdminAuth
{ use WithPagination;
    public $search = '';

    public $nama_opd;
    public $kode_opd;
    public $alamat_opd;

    public $namaOpd;
    public $kodeOpd; 
    public $alamatOpd;


    public $isEdit = false;
    public $existingFotoProfile = null;
    public $opdId = null;

    // Modal state
    public $showModal = false;
    public $showDetailModal = false;
    public $modalTitle = '';

    protected function rules()
    {
        $rules = [
            'namaOpd'      => 'required|string',
            'kodeOpd'      => 'required|string',
            'alamatOpd'    => 'required|string',
        ];


        return $rules;
    }

    public function openTambahModal()
    {
        // return 10;
        $this->resetForm();
        $this->isEdit = false;
        $this->modalTitle = 'Tambah OPD Baru';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDetailModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->namaOpd = '';
        $this->kodeOpd = '';
        $this->alamatOpd = '';
        $this->opdId = null;
        $this->isEdit = false;
        $this->resetErrorBag();
    }

      public function openEditModal($opdiId)
    {
        $opd = ModelsOpd::find($opdiId);

        if ($opd) {
            $this->opdId = $opd->id;
            $this->namaOpd = $opd->nama_opd;
            $this->kodeOpd = $opd->kode_opd;
            $this->alamatOpd = $opd->alamat_opd;
            $this->isEdit = true;
            $this->modalTitle = 'Edit Data OPD';
            $this->showModal = true;
        }
    }

    public function openDetailModal($opdiId)
    {
        $opd = ModelsOpd::find($opdiId);

        if ($opd) {
            $this->opdId = $opd->id;
            $this->namaOpd = $opd->nama_opd;
            $this->kodeOpd = $opd->kode_opd;
            $this->alamatOpd = $opd->alamat_opd;
            $this->isEdit = true;
            $this->modalTitle = 'Detail Data OPD';
            $this->showDetailModal = true;
        }
    }

    public function simpan()
    {
        $this->validate();

           if ($this->isEdit) {
                // Update data
                $opd = ModelsOpd::find($this->opdId);
                $opd->update([
                    'nama_opd' => $this->namaOpd,
                    'kode_opd' => $this->kodeOpd,
                    'alamat_opd' => $this->alamatOpd,
                ]);

                $this->dispatch('success-add-data',message: 'Berhasil Mengubah Data OPD');
            } else {
                // Tambah data baru
                ModelsOpd::create([
                   'nama_opd' => $this->namaOpd,
                    'kode_opd' => $this->kodeOpd,
                    'alamat_opd' => $this->alamatOpd,
                ]);

                $this->dispatch('success-add-data',message: 'Berhasil Menambah Data OPD');
                
            }

            $this->closeModal();
    }

    #[Layout('components.layouts.admin',['pageTitle' => 'Data OPD'])]
    public function render()
    {
        $opd = ModelsOpd::query()
        // ->with('')
        ->where('nama_opd', 'like', "%{$this->search}%")
        ->orWhere('kode_opd', 'like', "%{$this->search}%")
        ->latest()
        ->paginate(7);
        return view('livewire.admin.LW_opd.opd',['opds'=>$opd]);
    }

    #[On('delete-data-opd')]
    public function hapus($id)
    {
        try {
            $opd = ModelsOpd::find($id);
                $opd->delete();
                $this->dispatch('success-delete-data',message: 'Berhasil Menghapus Data OPD');
                $this->closeModal();
            
        } catch (\Exception $e) {
            $this->dispatch('failed-delete-data',message: 'Gagal Menghapus Data OPD');
        }
    }

}
