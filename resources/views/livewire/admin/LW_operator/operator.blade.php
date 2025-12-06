<div>
     @php
        $breadcrumbs = [
            ['name' => 'Daftar Operator', 'url' => route('superadmin.operator')],
            // ['name' => 'Detail Operator', 'url' => route('operator')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
            <input type="text" placeholder="Cari nama operator..." wire:model.live="search" class="form-control w-25 rounded-1">
        
            <button type="button" class="btn btn-primary w-20" wire:click="openTambahModal">
                <i class="bi bi-plus-lg"></i> Tambah Operator
            </button>

        </div>
        <div class="rounded-1 overflow-hidden border p-0">
        <div  class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-secondary">
                <tr>
                    <th class="px-4 py-2 text-dark">No</th>
                    <th class="px-4 py-2 text-dark">NAMA OPERATOR</th>
                    <th class="px-4 py-2 text-dark">INSTANSI</th>
                    <th class="px-4 py-2 text-dark">KONTAK</th>
                    <th class="px-4 py-2 text-dark">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($operators as $operator)
                    <tr>
                        <td class="px-4 py-1 text-dark">{{ $loop->iteration }}</td> <!-- Nomor urut -->
                        <td class="px-4 py-1 text-dark">{{ $operator->name }}</td>
                        <td class="px-4 py-1 text-dark">{{  Str::limit(strip_tags($operator->opd->nama_opd), 100) }}</td>
                        <td class="px-4 py-1 text-dark">{{ $operator->kontak }}</td>

                         <td class="px-4 py-1 d-flex gap-2">
                                <!-- Tombol Edit -->
                                <button wire:click="openEditModal({{ $operator->id }})"
                                    class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1">
                                    <i class="bi bi-pencil"></i>
                                    {{-- <span>Edit</span> --}}
                                </button>
                                <!-- Tombol Edit -->
                                {{-- <button wire:click="openDetailModal({{ $operator->id }})"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" disabled>
                                    <i class="bi bi-eye"></i>
                                </button> --}}

                                <!-- Tombol Hapus -->
                                <button wire:click="$dispatch('confirm-delete-data-operator', {{ $operator }})"
                                    class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                    <i class="bi bi-trash3"></i>
                                    {{-- <span>Hapus</span> --}}
                                </button>
                            </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-5 text-center">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-database-x text-warning" style="font-size: 60px"></i>
                                <span class="fs-5 text-dark">Operator masih kosong!</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $operators->links('vendor.livewire.bootstrap-pagination') }}
    </div>
</div>

    @if ($this->showModal)
        <x-modal :title="$modalTitle" :closeble="true" @click.self="$wire.closeModal()"
            @keydown.escape.window="$wire.closeModal()">

            <x-slot name="closeButton">
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeModal">
                </button>
            </x-slot>

            <form wire:submit.prevent="simpan">
                <div class="mb-3">
                    <label for="nip" class="form-label">
                        Nama Operator
                    </label>
                    <input type="text" class="form-control @error('namaOperator') is-invalid @enderror" id="nama_opd"
                        wire:model="namaOperator" placeholder="Masukkan nama Operator..." maxlength="255">
                    @error('namaOperator')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nip" class="form-label">
                        Email Operator
                    </label>
                    <input type="text" class="form-control @error('emailOperator') is-invalid @enderror" id="kode_opd"
                        wire:model="emailOperator" placeholder="Masukkan Email Operator..." maxlength="255">
                    @error('emailOperator')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nip" class="form-label">
                        Password
                    </label>
                    <input type="text" class="form-control @error('passwordOperator') is-invalid @enderror" id="kode_opd"
                        wire:model="passwordOperator" placeholder="Masukkan Email Operator..." maxlength="255">
                    @error('passwordOperator')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nip" class="form-label">
                        Kontak Operator
                    </label>
                    <input type="text" class="form-control @error('kontakOperator') is-invalid @enderror" id="alamat_opd"
                        wire:model="kontakOperator" placeholder="Masukkan Alamat OPD..." maxlength="255">
                    @error('kontakOperator')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="opd" class="form-label">Instansi OPD</label>
                        <select id="opd" class="form-control" wire:model="opd">
                            <option value="">-- Pilih Instansi --</option>
                            @foreach ($opds as $opd)
                                <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                            @endforeach
                        </select>
                    @error('opd')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

    {{-- @if ($this->showDetailModal)
        <x-modal :title="$modalTitle" :closeble="true" @click.self="$wire.closeModal()"
            @keydown.escape.window="$wire.closeModal()">

            <x-slot name="closeButton">
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeModal">
                </button>
            </x-slot>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="mb-3">
                        <small>Nama OPD</small>
                        <p class="fs-6 fw-bold">{{ $namaOpd }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Kode OPD</small>
                        <p class="fs-6 fw-bold">{{ $kodeOpd }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Alamat OPD</small>
                        <p class="fs-6 fw-bold">{{ $alamatOpd }}</p>
                    </div>
                </div>
            </div>

            <x-slot name="footer">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-danger" wire:click="closeModal">
                        <span wire:loading.remove wire:target="closeModal">Tutup</span>
                        <span wire:loading wire:target="closeModal">tunggu...</span>
                    </button>
                </div>
            </x-slot>
        </x-modal>
    @endif --}}
</div>

