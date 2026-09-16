<?php

namespace App\Livewire\Admin\LWkontrol;

use App\Models\Kontrol as ModelKontrol;
use App\Models\RapStatusOption;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;
use Livewire\Attributes\On;

class Kontrol extends AdminSuperAdminAuth
{
    public string $statusRAP = '';
    public string $statusAkses = '';
    public string $newStatusNama = '';

    public function mount(): void
    {
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            abort(404);
        }

        $this->loadStatus();
    }

    public function loadStatus(): void
    {
        $aksesKontrol = ModelKontrol::firstOrCreate(
            ['tipe' => 'RAP_Akses'],
            ['status' => 'Tutup']
        );
        $this->statusAkses = $aksesKontrol->status;

        $rapKontrol = ModelKontrol::firstOrCreate(
            ['tipe' => 'RAP_Status'],
            ['status' => '']
        );
        $this->statusRAP = $rapKontrol->status;
    }

    public function getRapOptionsProperty()
    {
        return RapStatusOption::orderBy('urutan')->get();
    }

    public function toggleStatusAksesRAP(): void
    {
        $kontrol = ModelKontrol::where('tipe', 'RAP_Akses')->firstOrFail();
        $kontrol->status = $kontrol->status === 'Buka' ? 'Tutup' : 'Buka';
        $kontrol->save();
        $this->statusAkses = $kontrol->status;

        $this->dispatch('succes-change', message: "Status Akses RAP : {$this->statusAkses}");
    }

    public function toggleStatusRAP(string $status): void
    {
        if ($this->statusRAP === $status) return;

        $kontrol = ModelKontrol::where('tipe', 'RAP_Status')->firstOrFail();
        $kontrol->status = $status;
        $kontrol->save();
        $this->statusRAP = $status;

        $this->dispatch('succes-change', message: "Status RAP berhasil diubah menjadi {$status}");
    }

    public function tambahStatus(): void
    {
        $this->validate([
            'newStatusNama' => 'required|string|max:100|unique:tbl_rap_status_options,nama',
        ], [
            'newStatusNama.required' => 'Nama status tidak boleh kosong',
            'newStatusNama.unique'   => 'Status ini sudah ada',
            'newStatusNama.max'      => 'Nama status maksimal 100 karakter',
        ]);

        $urutan = RapStatusOption::max('urutan') + 1;
        RapStatusOption::create([
            'nama'   => $this->newStatusNama,
            'urutan' => $urutan,
        ]);

        $this->newStatusNama = '';
        $this->dispatch('succes-change', message: 'Status RAP berhasil ditambahkan');
    }

    #[On('delete-data-RAPStatus')]
    public function hapusStatus(int $id): void
    {
        $option = RapStatusOption::findOrFail($id);

        if ($this->statusRAP === $option->nama) {
            $this->dispatch('error-change', message: 'Tidak bisa menghapus status yang sedang aktif');
            return;
        }

        $option->delete();
        $this->dispatch('succes-change', message: "Status {$option->nama} berhasil dihapus");
    }

    #[Layout('components.layouts.admin', ['pageTitle' => 'Kontrol Akses & Status RAP'])]
    public function render()
    {
        return view('livewire.admin.LW_kontrol.kontrol');
    }
}