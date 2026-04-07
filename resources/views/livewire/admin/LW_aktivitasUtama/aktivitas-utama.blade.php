<div>
     @php
        $breadcrumbs = [
            ['name' => 'Daftar Aktivitas Utama', 'url' => route('superadmin.masterdata.aktivitasUtama')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
    <div class="mt-5">
       <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
            <!-- Kiri -->
            <input type="text" placeholder="Cari aktivitas utama.." wire:model.live="search" class="form-control w-25 rounded-1">
            <!-- Kanan -->
            <div class="d-flex gap-2">
                {{-- <button type="button" class="btn btn-danger" wire:click="kosongkanTabel">
                    <i class="bi bi-trash"></i> Kosongkan Database
                </button>
                 --}}
                <button type="button" class="btn btn-warning" wire:click="kosongkanTabel" wire:loading.attr="disabled" wire:target="kosongkanTabel">
                    {{-- Saat tidak loading --}}
                    <span wire:loading.remove wire:target="kosongkanTabel" style="color:#fff">
                        <i class="bi bi-trash"></i> Kosongkan Database
                    </span>

                    {{-- Saat loading --}}
                    <span wire:loading wire:target="kosongkanTabel" style="display:none;">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Mengosongkan..
                    </span>
                </button>

                <button type="button" class="btn btn-success" wire:click="openImportModal">
                    <i class="bi bi-upload"></i> Import Data
                </button>
                <button type="button" class="btn btn-primary" wire:click="openTambahModal">
                    <i class="bi bi-plus-lg"></i> Aktivitas Utama
                </button>
            </div>
        </div>

        <div  iv class="rounded-1 overflow-hidden border p-0">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-secondary">
                <tr>
                    <th class="px-4 py-2 text-dark">No</th>
                    <th class="px-4 py-2 text-dark">TEMA PEMBANGUNAN</th>
                    <th class="px-4 py-2 text-dark">AKTIVITAS UTAMA</th>
                    <th class="px-4 py-2 text-dark">PROGRAM PRIORITAS</th>
                    <th class="px-4 py-2 text-dark">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aktivitasUtamas as $aktivitasUtama) 
                     <tr>
                        <td class="px-4 py-1 text-dark">{{ $loop->iteration }}</td> <!-- Nomor urut -->
                        <td class="px-4 py-1 text-dark">{{ $aktivitasUtama->tema_pembangunan }}</td>
                        <td class="px-4 py-1 text-dark">{{ Str::limit(strip_tags($aktivitasUtama->aktivitas_utama),30)}}</td>
                        <td class="px-4 py-1 text-dark">{{ Str::limit(strip_tags($aktivitasUtama->program_prioritas),30) }}</td>
                        {{-- <td class="px-4 py-1 text-dark">{{ Str::limit(strip_tags($subKegiatan->sub_kegiatan),50) }}</td> --}}

                        <td class="px-4 py-1 d-flex gap-2">
                                <!-- Tombol Edit -->
                                <button wire:click="openEditModal({{ $aktivitasUtama->id }})"
                                    class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <!-- Tombol Edit -->
                                <button wire:click="openDetailModal({{ $aktivitasUtama->id }})"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <button wire:click="$dispatch('confirm-delete-data-aktivitasUtama', {{ $aktivitasUtama }})"
                                    class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                    <i class="bi bi-trash3"></i>
                                </button>
                        </td>
                    </tr> 
                 @empty 
                    <tr>
                        <td colspan="5" class="px-4 py-5 text-center">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-database-x text-warning" style="font-size: 60px"></i>
                                <span class="fs-5 text-dark">Aktivitas utama masih kosong/Tidak Ditemukan!</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $aktivitasUtamas->links('vendor.livewire.bootstrap-pagination') }}
    </div>
</div>

@if ($this->showModal)
        <x-modal :title="$modalTitle" :closeble="true" @click.self="$wire.closeModal()"
            @keydown.escape.window="$wire.closeModal()" >

            <x-slot name="closeButton">
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeModal">
                </button>
            </x-slot>
            {{-- <hr> --}}
            <form wire:submit.prevent="simpan">
                <div class="row">
                    <div class="col-12 mt-2">
                    <div class="mb-3">
                        <label for="opd" class="form-label">Tema Pembangunan</label>
                            <select id="opd" class="form-control" wire:model="temaPembangunan">
                                    <option selected>-- Tema Pembangunan --</option>                         
                                    <option value="PAPUA CERDAS">Papua Cerdas</option>
                                    <option value="PAPUA SEHAT">Papua Sehat</option>
                                    <option value="PAPUA PRODUKTIF">Papua Produktif</option>
                                    <option value="KONDISI PERLU">Kondisi Perlu</option>
                            </select>
                            @error('temaPembangunan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label for="aktivitasUtama" class="form-label">
                            Aktivitas Utama
                        </label>
                        <input type="text" class="form-control @error('aktivitasUtamaValue') is-invalid @enderror" id="aktivitasUtama"
                            wire:model="aktivitasUtamaValue" placeholder="Masukkan aktivitas utama..." maxlength="255">
                        @error('aktivitasUtamaValue')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">
                            Program Prioritas
                        </label>
                        <input type="text" class="form-control @error('programPrioritas') is-invalid @enderror" id="programPrioritas"
                            wire:model="programPrioritas" placeholder="Masukkan program prioritas..." maxlength="255">
                        @error('programPrioritas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">
                            Target Keluaran Strategis
                        </label>
                        <input type="text" class="form-control @error('targetKeluaranStrategis') is-invalid @enderror" id="targetKeluaranStrategis"
                            wire:model="targetKeluaranStrategis" placeholder="Masukkan Target Keluaran Strategis..." maxlength="255">
                        @error('targetKeluaranStrategis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                </div>
            </form>
            <x-slot name="footer">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-danger" wire:click="closeModal">
                        <span wire:loading.remove wire:target="closeModal">Batal</span>
                        <span wire:loading wire:target="closeModal">Tunggu...</span>
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="simpan" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="simpan">
                            {{ $isEdit ? 'Perbarui' : 'Simpan' }}
                        </span>
                        <span wire:loading wire:target="simpan">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </x-slot>
        </x-modal>
    @endif

    @if ($this->showDetailModal)
        <x-modal :title="$modalTitle" :closeble="true" @click.self="$wire.closeModal()"
            @keydown.escape.window="$wire.closeModal()">

            <x-slot name="closeButton">
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeModal">
                </button>
            </x-slot>

         <div class="row">
                <div class="col-12 col-md-12">
                    <div class="mb-3">
                        <small>Tema Pembangunan</small>
                        <p class="fs-6 fw-bold">{{ $temaPembangunan }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Aktivitas Utama</small>
                        <p class="fs-6 fw-bold">{{ $aktivitasUtamaValue }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Program Prioritas</small>
                        <p class="fs-6 fw-bold">{{ $programPrioritas }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Target Keluaran Strategis</small>
                        <p class="fs-6 fw-bold">{{ $targetKeluaranStrategis }}</p>
                    </div>
                </div>
            </div>

            <x-slot name="footer">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-danger" wire:click="closeModal">
                        <span wire:loading.remove wire:target="closeModal">Tutup</span>
                        <span wire:loading wire:target="closeModal">Tunggu...</span>
                    </button>
                </div>
            </x-slot>
        </x-modal>
    @endif

    @if ($this->showImportModal)
    <x-modal title="Import Data Aktivitas Utama" :closeble="true" @click.self="$wire.closeImportModal()"
        @keydown.escape.window="$wire.closeImportModal()">

        {{-- Tombol X di pojok kanan --}}
        <x-slot name="closeButton">
            <button type="button" class="btn-close" aria-label="Close" wire:click="closeImportModal"></button>
        </x-slot>
        {{-- Body modal --}}
        <div class="row">
            <div class="col-12">
                <form wire:submit.prevent="import" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">Pilih File Excel</label>
                        <input type="file" id="file" wire:model="file" class="form-control">
                        <small class="text-muted d-block mt-1">Format: .xlsx, .xls, atau .csv (maks 10 MB)</small>
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Preview upload --}}
                    @if ($file)
                        <div class="alert alert-info py-2">
                            <i class="bi bi-file-earmark-spreadsheet me-1"></i>
                            <strong>{{ $file->getClientOriginalName() }}</strong> siap diupload.
                        </div>
                    @endif
                </form>
            </div>
        </div>
        {{-- Footer modal --}}
        <x-slot name="footer">
            <div class="d-flex gap-2 w-100 justify-content-end">
                <button type="button" class="btn btn-danger" wire:click="closeModal">
                    <span wire:loading.remove wire:target="closeModal">Batal</span>
                    <span wire:loading wire:target="closeModal">Menutup...</span>
                </button>

                <button type="submit" class="btn btn-primary" wire:click="import" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="import">
                        <i class="bi bi-upload"></i> Upload
                    </span>
                    <span wire:loading wire:target="import">
                        <span class="spinner-border spinner-border-sm me-2"></span> Mengunggah...
                    </span>
                </button>
            </div>
        </x-slot>
    </x-modal>
@endif
</div>

