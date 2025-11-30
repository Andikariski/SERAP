<div>
     @php
        $breadcrumbs = [
            ['name' => 'Alokasi Pagu OPD', 'url' => route('superadmin.opd')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
<div>
    <div class="card text-white shadow-sm border-0" style="background: linear-gradient(135deg, #219EBC 0%,  #4f46e5 100%);">
        <div class="row">
    {{-- 🟩 Dana Otsus BG --}}
    <div class="col-3">
        <div class="card-body">
            <h5 class="card-title">Dana Otsus BG</h5>
            @if ($paguInduk)
                <h3 class="fw-bold">{{ number_format($paguInduk->pagu_BG, 0, ',', '.') }}</h3>
                <p class="mb-0">
                    Tahun Anggaran :
                    <span class="badge bg-success">{{ $paguInduk->tahun_pagu }}</span>
                </p>
            @else
                <span class="badge bg-danger">Belum Input Pagu Induk</span>
                <p class="mb-0">
                    Tahun Anggaran Aktif :
                    <span class="badge bg-danger">-</span>
                </p>
            @endif
        </div>
    </div>

    {{-- 🟩 Dana Otsus SG --}}
    <div class="col-3">
        <div class="card-body">
            <h5 class="card-title">Dana Otsus SG</h5>
            @if ($paguInduk)
                <h3 class="fw-bold">{{ number_format($paguInduk->pagu_SG, 0, ',', '.') }}</h3>
                <p class="mb-0">
                    Tahun Anggaran :
                    <span class="badge bg-success">{{ $paguInduk->tahun_pagu }}</span>
                </p>
            @else
                <span class="badge bg-danger">Belum Input Pagu Induk</span>
                <p class="mb-0">
                    Tahun Anggaran :
                    <span class="badge bg-danger">-</span>
                </p>
            @endif
        </div>
    </div>

    {{-- 🟩 Dana Otsus DTI --}}
    <div class="col-3">
        <div class="card-body">
            <h5 class="card-title">Dana Otsus DTI</h5>
            @if ($paguInduk)
                <h3 class="fw-bold">{{ number_format($paguInduk->pagu_DTI, 0, ',', '.') }}</h3>
                <p class="mb-0">
                    Tahun Anggaran :
                    <span class="badge bg-success">{{ $paguInduk->tahun_pagu }}</span>
                </p>
            @else
                <span class="badge bg-warning">Belum Input Pagu Induk</span>
                <p class="mb-0">
                    Tahun Anggaran :
                    <span class="badge bg-warning">-</span>
                </p>
            @endif
        </div>
    </div>

    {{-- 🟩 Dana SiLPA --}}
    <div class="col-3">
        <div class="card-body">
            <h5 class="card-title">Dana SiLPA</h5>
            <span class="badge bg-warning">-</span>
            <p class="mb-0">
                Tahun Anggaran :
                <span class="badge bg-secondary">
                    {{ $paguInduk ? $paguInduk->tahun_pagu : date('Y') }}
                </span>
            </p>
        </div>
    </div>
</div>

    </div>
    <div class="mt-5">
       <div class="row align-items-center mb-3 mt-4">
            <div class="col-md-4">
                <input type="text" placeholder="Search..." wire:model.live="search" class="form-control rounded-1">
            </div>
            {{-- <div class="col-md-2">
                <select class="form-control" wire:model.live="filterTahun">
                        <option   option value="">--Pilih Tahun--</option>
                    @foreach ($tahuns as $tahun)
                        <option value="{{ $tahun }}">Tahun {{ $tahun }}</option>
                    @endforeach
            </select>
            </div> --}}
            <div class="col-md-8 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" wire:click="openTambahModal">
                    <i class="bi bi-plus-lg"></i> Input Pagu OPD
                </button>
            </div>
        </div>

        <div class="rounded-1 overflow-hidden border p-0">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-secondary">
                    <tr>
                        <th class="px-4 py-2 text-dark">NO</th>
                        <th class="px-4 py-2 text-dark">NAMA OPD</th>
                        <th class="px-4 py-2 text-dark">PAGU BG</th>
                        <th class="px-4 py-2 text-dark">PAGU SG</th>
                        <th class="px-4 py-2 text-dark">PAGU DTI</th>
                        <th class="px-4 py-2 text-dark">TAHUN</th>
                        <th class="px-4 py-2 text-dark">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($paguOpds as $pagu)
                    <tr>
                        <td class="px-4 py-1 text-dark">{{ $loop->iteration }}</td> <!-- Nomor urut -->
                        <td class="px-4 py-1 text-dark">{{ Str::limit(strip_tags($pagu->opd->nama_opd), 30) }}</td>
                        <td class="px-4 py-1 text-dark">{{ number_format($pagu->pagu_BG) }}</td>
                        <td class="px-4 py-1 text-dark">{{ number_format($pagu->pagu_SG) }}</td>
                        <td class="px-4 py-1 text-dark">{{ number_format($pagu->pagu_DTI) }}</td>
                        <td class="px-4 py-1 text-dark">{{ $pagu->tahun_pagu }}</td>

                         <td class="px-4 py-1 d-flex gap-2">
                                <!-- Tombol Edit -->
                                <button wire:click="openEditModal({{ $pagu->id }})"
                                    class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1">
                                    <i class="bi bi-pencil"></i>
                                    {{-- <span>Edit</span> --}}
                                </button>
                                <!-- Tombol Edit -->
                                <button wire:click="openDetailModal({{ $pagu->id }})"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                    <i class="bi bi-eye"></i>
                                    {{-- <span>Detail</span> --}}
                                </button>

                                <!-- Tombol Hapus -->
                                <button wire:click="$dispatch('confirm-delete-data-paguOPD', {{ $pagu }})"
                                    class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                    <i class="bi bi-trash3"></i>
                                    {{-- <span>Hapus</span> --}}
                                </button>
                            </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-5 text-center">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-emoji-tear text-warning" style="font-size: 60px"></i>
                                <span class="fs-5 text-dark">Pagu Belum diInput!</span>
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
        {{ $paguOpds->links('vendor.livewire.bootstrap-pagination') }}
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
            <div class="card text-white shadow-sm border-0" style="background: linear-gradient(135deg, #df5200 0%,  #df5200 100%); height: 90px;">
            <div class="row">
                <div class="col-4">
                    <div class="card-body">
                        <h6 class="card-title">Sisa Pagu BG</h6>                      
                        <h6 class="fw-bold">{{ number_format($this->sisaBG, 0, ',' , '.') }}</h6>
                    </div>
                </div>
                <div class="col-4">
                   <div class="card-body">
                        <h6 class="card-title">Sisa Pagu SG</h6>                      
                        <h6 class="fw-bold">{{ number_format($this->sisaSG, 0, ',' , '.') }}</h6>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card-body">
                        <h6 class="card-title">Sisa Pagu DTI</h6>                      
                        <h6 class="fw-bold">{{ number_format($this->sisaDTI, 0, ',' , '.') }}</h6>
                    </div>
                </div>
                {{-- <div class="col-3">
                    <div class="card-body">
                        <h5 class="card-title">Dana SiLPA</h5>
                        <span class="badge bg-danger">-</span>
                        <h3 class="fw-bold">XXX.000.000.000</h3>
                        <p class="mb-0">Tahun Anggaran 2025</p>
                    </div>
                </div> --}}
            </div>
        </div>
            {{-- <hr> --}}
            <form wire:submit.prevent="simpan">
                <div class="mb-2 mt-2">
                    <label class="form-label"><strong>Instansi OPD</strong></label> 
                        @if ($modalTitle == 'Edit Data Pagu OPD')
                            <input type="text" class="form-control" value="{{ $namaOpd }}" disabled>
                        @else
                        <select id="opd" class="form-control select2 @error('idOpd') is-invalid @enderror"" wire:model="idOpd">
                                <option value="">-- Pilih Instansi --</option>
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                                    @endforeach
                        </select>
                        @error('idOpd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
                <div class="mb-2">
                    <label for="paguBG" class="form-label">
                        <strong>Tahun Pagu Berjalan</strong>
                    </label>
                    <input type="number" class="form-control @error('tahunPagu') is-invalid @enderror" id="pagu_bg"
                        wire:model="tahunAktif" placeholder="Masukkan Tahun Pagu" maxlength="255" disabled>
                    @error('tahunPagu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="paguBG" class="form-label">
                        <strong>Pagu Block Grand (BG 1%)</strong>
                    </label>
                    <input type="number" class="form-control @error('paguBG') is-invalid @enderror" id="pagu_bg"
                        wire:model="paguBG" placeholder="Masukkan Pagu BG..." maxlength="255">
                    @error('paguBG')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="paguSG" class="form-label">
                        <strong>Pagu Spesifik Grand (1,25%)</strong>
                    </label>
                    <input type="number" class="form-control @error('paguSG') is-invalid @enderror" id="pagu_sg"
                        wire:model="paguSG" placeholder="Masukkan Pagu SG..." maxlength="255">
                    @error('paguSG')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="paguDTI" class="form-label">
                        <strong>Pagu Dana Tambahan Infrastruktur (DTI)</strong>
                    </label>
                    <input type="number" class="form-control @error('paguDTI') is-invalid @enderror" id="pagu_dti"
                        wire:model="paguDTI" placeholder="Masukkan Pagu DTI..." maxlength="255">
                    @error('paguDTI')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                    {{-- <input type="hidden" class="form-control id="alamat_opd" wire:model="tahunPagu" maxlength="255" value="{{ date('Y') }}"> --}}

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
            <hr>
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="mb-3">
                        <small>Nama OPD</small>
                        <p class="fs-6 fw-bold">{{ $namaOpd }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Pagu Block Grand (1%)</small>
                        <p class="fs-6 fw-bold">Rp {{ number_format($paguBG, 0, ',' , '.') }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Pagu Spesifik Grand (1,25%)</small>
                        <p class="fs-6 fw-bold">Rp {{ number_format($paguSG, 0, ',' , '.') }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Pagu DTI</small>
                        <p class="fs-6 fw-bold">Rp {{ number_format($paguDTI, 0, ',' , '.') }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Total Pagu <span class="badge bg-success">{{ $kodeOpd }}</span></small>
                        <p class="fs-6 fw-bold">Rp {{ number_format($paguDTI+$paguSG+$paguBG, 0, ',' , '.') }}</p>
                    </div>
                    <div class="mb-3">
                        <small>Tahun Pagu</small>
                        <p class="fs-6 fw-bold">{{ $tahunPagu }}</p>
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
{{-- 
<script>
    $('#opd').select2({
        width: '50%'
    });         
</script> --}}


