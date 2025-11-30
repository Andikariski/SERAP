<div>
     @php
        $breadcrumbs = [
            ['name' => 'Pagu Induk', 'url' => route('superadmin.pagu.induk')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
<div>
    <div class="mt-5">
       <div class="row align-items-center mb-3 mt-4">
            <div class="col-md-4">
                <input type="text" placeholder="Search..." wire:model.live="search" class="form-control rounded-1">
            </div>
            <div class="col-md-2">
                <select class="form-control" wire:model.live="filterTahun">
                        <option   option value="">--Pilih Tahun--</option>
                    @foreach ($tahuns as $tahun)
                        <option value="{{ $tahun }}">Tahun {{ $tahun }}</option>
                    @endforeach
            </select>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" wire:click="openTambahModal">
                    <i class="bi bi-plus-lg"></i> Input Pagu Induk
                </button>
            </div>
        </div>

        <div class="rounded-1 overflow-hidden border p-0">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-secondary">
                    <tr>
                        <th class="px-4 py-2 text-dark" style="width: 3%;">AKSES</th>
                        <th class="px-4 py-2 text-dark" style="width: 15%;" >TAHUN PAGU</th>
                        <th class="px-4 py-2 text-dark">PAGU BG</th>
                        <th class="px-4 py-2 text-dark">PAGU SG</th>
                        <th class="px-4 py-2 text-dark">PAGU DTI</th>
                        {{-- <th class="px-4 py-2 text-dark">Total Pagu</th> --}}
                        <th class="px-4 py-2 text-dark">STATUS</th>
                        <th class="px-4 py-2 text-dark" style="width: 3%;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($paguInduks as $paguInduk)
                    <tr>
                        <td class="px-4 py-1 text-dark">
                            @if ($paguInduk->status === 'Aktif')
                                <button wire:click="toggleStatus({{ $paguInduk->id }})" 
                                    class="btn btn-sm btn-outline-success d-flex align-items-center gap-1">
                                    <i class="bi bi-toggle-on"></i>
                                </button>
                            @else
                                <button wire:click="toggleStatus({{ $paguInduk->id }})" 
                                    class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                    <i class="bi bi-toggle-off"></i>
                                </button>
                            @endif
                        </td>
                        <td class="px-4 py-1 text-dark">{{ $paguInduk->tahun_pagu }}</td>
                        <td class="px-4 py-1 text-dark">{{ number_format($paguInduk->pagu_BG) }}</td>
                        <td class="px-4 py-1 text-dark">{{ number_format($paguInduk->pagu_SG) }}</td>
                        <td class="px-4 py-1 text-dark">{{ number_format($paguInduk->pagu_DTI) }}</td>
                        <td class="px-4 py-1 text-dark">
                            <span class="badge {{ $paguInduk->status === 'Aktif' ? 'bg-success' : 'bg-danger' }}">{{ $paguInduk->status }}</span>
                        </td>
                        {{-- <td class="px-4 py-1 text-dark">{{ number_format($paguInduk->pagu_DTI+$paguInduk->pagu_BG+$paguInduk->SG) }}</td> --}}
                        <td class="px-4 py-1 d-flex gap-2">
                                <button wire:click="openEditModal({{ $paguInduk->id }})"
                                    class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                {{-- <button wire:click="openDetailModal({{ $paguInduk->id }})"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                    <i class="bi bi-eye"></i>
                                </button> --}}

                                <button wire:click="$dispatch('confirm-delete-data-paguInduk', {{ $paguInduk }})"
                                    class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td> 
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-5 text-center">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-emoji-tear text-warning" style="font-size: 60px"></i>
                                <span class="fs-5 text-dark">Pagu Induk Definitif Belum diInput!</span>
                            </div>
                        </td>
                    </tr>
                 @endforelse 
            </tbody>
            </table>
            {{-- <select id="opd" class="form-control" wire:model="idOpd">
                <option value="">-- Pilih Instansi --</option>
                @foreach ($opds as $opd)
                    <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                @endforeach
            </select> --}}
        </div>    
    </div>   
     <div class="mt-4">
        {{ $paguInduks->links('vendor.livewire.bootstrap-pagination') }}
    </div>
</div>

@if ($this->showModal)
        <x-modal :title="$modalTitle" :closeble="true" @click.self="$wire.closeModal()"
            @keydown.escape.window="$wire.closeModal()">
            <x-slot name="closeButton">
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeModal">
                </button>
            </x-slot>
            <hr>
            <form wire:submit.prevent="simpan">
                <div class="mb-3">
                    <label for="paguBG" class="form-label">
                        <strong>Tahun Pagu</strong>
                    </label>
                    <input type="number" id="tahunPicker" wire:model="tahunPagu" class="form-control">
                    @error('tahunPagu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="paguBG" class="form-label">
                        <strong>Pagu Block Grand (BG 1%)</strong>
                    </label>
                    <input type="text" class="form-control format-rupiah @error('paguBG') is-invalid @enderror" id="pagu_bg"
                        wire:model="paguBG" placeholder="Masukkan Pagu BG..." maxlength="255">
                    @error('paguBG')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="paguSG" class="form-label">
                        <strong>Pagu Spesifik Grand (1,25%)</strong>
                    </label>
                    <input type="text" class="form-control format-rupiah @error('paguSG') is-invalid @enderror" id="pagu_sg"
                        wire:model="paguSG" placeholder="Masukkan Pagu SG..." maxlength="255">
                    @error('paguSG')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="paguDTI" class="form-label">
                        <strong>Pagu Dana Tambahan Infrastruktur (DTI)</strong>
                    </label>
                    <input type="text" class="form-control format-rupiah @error('paguDTI') is-invalid @enderror" id="pagu_dti"
                        wire:model="paguDTI" placeholder="Masukkan Pagu DTI..." maxlength="255">
                    @error('paguDTI')
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
                        <small>Nama OPD</small>
                        <p class="fs-6 fw-bold">{{ $namaOpd }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Pagu Block Grand (1%)</small>
                        <p class="fs-6 fw-bold">{{ $kodeOpd }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Pagu Spesifik Grand (1,25%)</small>
                        <p class="fs-6 fw-bold">{{ $kodeOpd }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Pagu DTI (1%)</small>
                        <p class="fs-6 fw-bold">{{ $kodeOpd }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Tahun Pagu</small>
                        <p class="fs-6 fw-bold">{{ $alamatOpd }}</p>
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
</div>


<script>
    function initFormatRupiah() {
        const rupiahInputs = document.querySelectorAll('.format-rupiah');

        rupiahInputs.forEach(function (input) {
            input.addEventListener('input', function (e) {
                let value = e.target.value;

                // Hapus semua karakter selain angka
                value = value.replace(/\D/g, '');

                // Format angka pakai titik ribuan
                value = new Intl.NumberFormat('id-ID').format(value);

                e.target.value = value;
            });
        });
    }

    // Panggil sekali ketika halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', function () {
        initFormatRupiah();
    });

    // Panggil ulang setiap Livewire memuat ulang DOM (setelah navigasi)
    document.addEventListener('livewire:navigated', function () {
        initFormatRupiah();
    });

    // Tambahan: kalau kamu tidak pakai wire:navigate tapi pakai komponen yang re-render
    document.addEventListener('livewire:load', function () {
        Livewire.hook('morph.updated', () => {
            initFormatRupiah();
        });
    });
</script>

