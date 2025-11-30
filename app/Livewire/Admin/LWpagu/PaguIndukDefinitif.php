<?php

namespace App\Livewire\Admin\LWpagu;

use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;
use App\Models\Pagu as ModelPaguOPD;
use App\Models\PaguInduk as ModelPaguInduk;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;


class PaguIndukDefinitif extends AdminSuperAdminAuth
{
    
    public $filterTahun = '';
    public $isEdit = false;
    public $existingFotoProfile = null;
    public $paguId = null;

      // Variabel Model Wire Dari Inputan
    public $paguBG;
    public $paguSG;
    public $paguDTI;
    public $tahunPagu;
    public $paguInduk;

    public $tahun_pagu;

    // Modal state
    public $showModal = false;
    public $showDetailModal = false;
    public $modalTitle = '';

    public function toggleStatus($id)
    {
        $paguInduk = ModelPaguInduk::findOrFail($id);
        $cekJumlahAktif = ModelPaguInduk::where('status','Aktif')
                                            ->where('id',$id)->count();

        if($cekJumlahAktif === 1){
            $this->dispatch('failed-add-data',message: "Gagal, Tidak bisa menonaktifkan tahun yang aktif.");
        }
        else{
            if ($paguInduk->status === 'Aktif') {
                $paguInduk->update(['status' => 'Nonaktif']);
            } else {
                $paguInduk->update(['status' => 'Aktif']);
            }
            $this->dispatch('success-add-data',message: "Berhasil, Pagu Definitif {$paguInduk->tahun_pagu} telah diaktifkan.");
            // session()->flash('message', 'Status tahun ' . $pagu->tahun_pagu . ' telah diperbarui!');
        }
        
    }
    
    protected function rules()
    {
        $rules = [
            'tahunPagu' => 'required|numeric',
            'paguBG'    => 'required|numeric',
            'paguSG'    => 'required|numeric',
            'paguDTI'   => 'required|numeric',
        ];
        return $rules;
    }

    public function openTambahModal()
    {
        
        $this->resetForm();
        $this->isEdit = false;
        $this->modalTitle = 'Input Pagu Induk Definitif';
        $this->showModal = true;
    }

      public function resetForm()
    {
        $this->tahunPagu = '';
        $this->paguBG = '';
        $this->paguSG = '';
        $this->paguDTI = '';
        $this->isEdit = false;
        $this->resetErrorBag();
    }

     public function closeModal()
    {
        $this->showModal = false;
        $this->showDetailModal = false;
        $this->resetForm();
    }

    public function openEditModal($paguId)
    {
        $paguInduk = ModelPaguInduk::find($paguId);

        if ($paguInduk) {
            $this->paguId = $paguInduk->id;
            $this->paguSG = $paguInduk->pagu_SG;
            $this->paguBG = $paguInduk->pagu_BG;
            $this->paguDTI = $paguInduk->pagu_DTI;
            $this->tahunPagu = $paguInduk->tahun_pagu;
            $this->modalTitle = 'Edit Data Pagu Induk';
            $this->showModal = true;
            $this->isEdit = true; // ← penting!
        }
    }


    #[On('delete-data-paguInduk')]
    public function hapus($id)
    {
        try {
            // 1️⃣ Cari data pagu induk berdasarkan id
            $paguInduk = ModelPaguInduk::findOrFail($id);

            // 2️⃣ Hitung apakah ada data pagu OPD yang pakai tahun ini
            $count = ModelPaguOpd::where('tahun_pagu', $paguInduk->tahun_pagu)->count();

            // 3️⃣ Jika masih ada, batalkan penghapusan dan tampilkan alert
            if ($count > 0) {
                $this->dispatch(
                    'failed-delete-data',
                    message: "Gagal menghapus! Masih ada $count data Pagu OPD untuk tahun {$paguInduk->tahun_pagu}."
                );
                return;
            }

            // 4️⃣ Jika aman, hapus data pagu induk
            $paguInduk->delete();

            // 5️⃣ Kirim notifikasi sukses
            $this->dispatch(
                'success-delete-data',
                message: "Berhasil, Pagu Induk tahun {$paguInduk->tahun_pagu} telah dihapus."
            );

        } catch (\Exception $e) {
            // 7️⃣ Tangkap error umum
            $this->dispatch(
                'failed-delete-data',
                message: 'Terjadi kesalahan saat menghapus data pagu induk.'
            );
        }
    }

    public function simpan()
    {
        $this->validate();
        $cekDataPagu = ModelPaguInduk::where('tahun_pagu',$this->tahunPagu)->first();

            if ($this->isEdit) {
                // Update data
                $pagu = ModelPaguInduk::find($this->paguId);
                $pagu->update([
                    // 'fkid_opd'      => $this->idOpd,
                    'pagu_SG'       => $this->paguSG,
                    'pagu_BG'       => $this->paguBG ,
                    'pagu_DTI'      => $this->paguDTI,
                    // 'tahun_pagu'    =>  $this->tahunPagu = date('Y')
                    'tahun_pagu'    =>  $this->tahunPagu
                ]);
                $this->dispatch('success-add-data',message: "Berhasil, Pagu Definitif {$this->tahunPagu} telah diubah.");
                $this->closeModal();
            } else {
                if(!$cekDataPagu){
                // Tambah data baru
                ModelPaguInduk::create([
                    'pagu_SG'       => $this->paguSG,
                    'pagu_BG'       => $this->paguBG ,
                    'pagu_DTI'      => $this->paguDTI,
                    // 'tahun_pagu'    =>  $this->tahunPagu = date('Y')
                    'tahun_pagu'    =>  $this->tahunPagu 
                    ]);
                    $this->dispatch('success-add-data',message: "Berhasil, Pagu Definitif {$this->tahunPagu} telah ditambahkan.");
                    $this->closeModal();
                }
                else{
                    $this->dispatch('failed-add-data', message: "Gagal, Pagu Tahun {$this->tahunPagu} Sudah ada.");
                }
            }
    }

    #[Layout('components.layouts.admin',['pageTitle' => 'Data Pagu Induk'])]
    public function render()
    {
          $paguInduks = ModelPaguInduk::query()
                    ->where('tahun_pagu', 'like', "%{$this->filterTahun}%")
                    ->latest()
                    ->paginate(5);

          $tahuns = ModelPaguInduk::select('tahun_pagu')
            ->distinct()
            ->orderBy('tahun_pagu', 'desc')
            ->pluck('tahun_pagu');

        return view('livewire.admin.LW_pagu.pagu-induk-definitif',compact('paguInduks','tahuns'));
    }
}
