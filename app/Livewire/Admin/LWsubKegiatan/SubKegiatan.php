<?php

namespace App\Livewire\Admin\LWsubKegiatan;

use App\Imports\SubKegiatanImport;
use App\Models\Opd as ModelsOpd;
use App\Models\SubKegiatan as ModelsSubKegiatan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;

class SubKegiatan extends AdminSuperAdminAuth
{
    use WithPagination, WithFileUploads;
    public $filterTahun = '';
    public $search = '';
    public $isEdit = false;
    public $existingFotoProfile = null;
    public $subKegiatanId = null;


    // Variabel Model Wire Dari Inputan
    // public $fkidOpd;
    public $kodeKlasifikasi;
    public $kewenanganValue;
    public $klasifikasiBelanja;
    public $subKegiatan;
    public $subKegiatanValue;
    public $kinerja;
    public $indikator;
    public $satuan;
    

    // Modal state
    public $showModal = false;
    public $showDetailModal = false;

    public $showImportModal = false;
    public $file;
    public $modalTitle = '';

    protected function rules()
    {
        $rules = [
            // 'idOpd'             => 'required',
            'kodeKlasifikasi'   => 'required',
            'kewenanganValue'   => 'required',
            'subKegiatanValue'  => 'required',
            'klasifikasiBelanja'=> 'required',
            'kinerja'           => 'required',
            'indikator'         => 'required',
            'satuan'            => 'required',
        ];
        return $rules;
    }

    public function search(Request $request){
        $search = $request->input('q', '');
            $results = ModelsSubKegiatan::query()
                ->when($search, fn($q) => $q->where('sub_kegiatan', 'like', "%{$search}%"))
                ->limit(30) // batasi biar ringan
                ->get(['id', 'sub_kegiatan']);
        return response()->json($results);
    }

    
     // Fungsi buka modal
    public function openImportModal()
    {
        // dd("Tombol Berfungsi");
        $this->reset('file');
        $this->showImportModal = true;

    }

    public function openEditModal($subKegiatanId)
    {
        $subKegiatans = ModelsSubKegiatan::find($subKegiatanId);

        if ($subKegiatans) {
            $this->subKegiatanId = $subKegiatans->id;
            $this->kewenanganValue = $subKegiatans->kewenangan;
            $this->kodeKlasifikasi = $subKegiatans->kode_klasifikasi;
            $this->subKegiatanValue = $subKegiatans->sub_kegiatan;
            $this->klasifikasiBelanja = $subKegiatans->klasifikasi_belanja;
            $this->kinerja = $subKegiatans->kinerja;
            $this->indikator = $subKegiatans->indikator;
            $this->satuan = $subKegiatans->satuan;
            $this->isEdit = true;
            $this->modalTitle = 'Edit Data Sub Kegiatan';
            $this->showModal = true;
        }
    }

    public function openDetailModal($subKegiatanId)
    {
        $subKegiatans = ModelsSubKegiatan::find($subKegiatanId);

        if ($subKegiatans) {
            $this->subKegiatanId = $subKegiatans->id;
            $this->kodeKlasifikasi = $subKegiatans->kode_klasifikasi;
            $this->subKegiatanValue = $subKegiatans->sub_kegiatan;
            $this->klasifikasiBelanja = $subKegiatans->klasifikasi_belanja;
            $this->kewenanganValue = $subKegiatans->kewenangan;
            $this->kinerja = $subKegiatans->kinerja;
            $this->indikator = $subKegiatans->indikator;
            $this->satuan = $subKegiatans->satuan;
            $this->isEdit = true;
            $this->modalTitle = 'Detail Data Sub Kegiatan';
            $this->showDetailModal = true;
        }
    }

    public function openTambahModal()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->modalTitle = 'Tambah Sub Kegiatan';
        $this->showModal = true;
    }

    #[On('kosongkan-database-SubKegiatan')]
    public function kosongkanTabel(){
        ModelsSubKegiatan::query()->forceDelete();
        $this->dispatch('success-delete-data', message: "Database berhasil di kosongkan");
    }

    public function resetForm()
    {
        $this->kodeKlasifikasi = '';
        $this->subKegiatanValue = '';
        $this->kinerja = '';
        $this->indikator = '';
        $this->klasifikasiBelanja = '';
        $this->kewenanganValue = '';
        $this->satuan = '';
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

    #[On('delete-data-subKegiatan')]
    public function hapus($id)
    {
        try {
            $kegiatan = ModelsSubKegiatan::find($id);
                $kegiatan->delete();
                $this->dispatch('success-delete-data',message:  "Sub kegiatan {$kegiatan->kode_klasifikasi} berhasil dihapus.");
                $this->closeModal();
            
        } catch (\Exception $e) {
            $this->dispatch('failed-delete-data',message: 'Gagal Menghapus Data Pagu');
        }
    }

    public function simpan()
    {
        // 1. Validasi input
        $this->validate();
        
        //Tentukan logika edit / tambah
        if ($this->isEdit) {
            // Update data
            $data = ModelsSubKegiatan::findOrFail($this->subKegiatanId);
            $data->update([
                'kewenangan'            => $this->kewenanganValue,
                'kode_klasifikasi'      => $this->kodeKlasifikasi,
                'sub_kegiatan'          => $this->subKegiatanValue,
                'kinerja'               => $this->kinerja,
                'indikator'             => $this->indikator,
                'satuan'                => $this->satuan,
                'klasifikasi_belanja'   => $this->klasifikasiBelanja,
            ]);

            $this->dispatch('success-add-data', message: "Sub kegiatan berhasil diperbarui.");
        } else {
            // Tambah data baru
            ModelsSubKegiatan::create([
                'kewenangan'            => $this->kewenanganValue,
                'kode_klasifikasi'      => $this->kodeKlasifikasi,
                'sub_kegiatan'          => $this->subKegiatanValue,
                'kinerja'               => $this->kinerja,
                'indikator'             => $this->indikator,
                'satuan'                => $this->satuan,
                'klasifikasi_belanja'   => $this->klasifikasiBelanja,
            ]);
            $this->dispatch('success-add-data', message: "Sub kegiatan berhasil ditambahkan.");
        }

        //Tutup modal dan reset input
        $this->closeModal();
    }

    // Fungsi untuk memproses file upload & import ke database
    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // max 10MB
        ], [
            'file.required' => 'Pilih file Excel terlebih dahulu.',
            'file.mimes' => 'Format file harus .xlsx, .xls, atau .csv.',
        ]);

        try {
            // Proses import file menggunakan Excel
            Excel::import(new SubKegiatanImport, $this->file->getRealPath());
            $this->dispatch('success-add-data', message: "Sub kegiatan berhasil diimport.");

        } catch (\Exception $e) {
            $this->dispatch('error-add-data', message: "Terjadi kesalahan saat import: {$e->getMessage()}");
        }

        $this->reset('file');
        $this->showImportModal = false;
    }


    #[Layout('components.layouts.admin',['pageTitle' => 'Sub Kegiatan'])]
    public function render()
    {
        $pilihSub = ModelsSubKegiatan::all();
        
        $subKegiatans = ModelsSubKegiatan::query()
                    ->where('sub_kegiatan', 'like', "%{$this->search}%")
                    ->orWhere('kode_klasifikasi','like', "%{$this->search}%")
                    // ->latest()
                    ->paginate(10);


        // Ambil semua OPD untuk dropdown
        $opds = ModelsOpd::all();

        return view('livewire.admin.LW_subKegiatan.sub-kegiatan', compact('opds', 'subKegiatans','pilihSub'));
    }
}
