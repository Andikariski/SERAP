<div>
     @php
        $breadcrumbs = [
            ['name' => 'Data Riwayat RAP', 'url' => route('opd.rap.rapBG')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
<div>
   
    <div class="row align-items-center mb-3 mt-4">
            <div class="col-md-4">
                <input type="text" placeholder="Search..." wire:model.live="search" class="form-control rounded-1">
            </div>
            <div class="col-md-2">
                <select class="form-control" wire:model.live="filterTahun">
                        <option  value="">--Tahun RAP--</option>
                    @foreach ($tahuns as $tahun)
                        <option value="{{ $tahun }}">RAP Tahun {{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" wire:model.live="filterSumberDana">
                    <option value="">--Sumber Dana--</option>
                    @foreach ($pagus as $pagu)
                        <option value="{{ $pagu }}">Dana {{ $pagu }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <button class="btn btn-success disabled-link" wire:click="exportExcel">
                    <i class="bi bi-file-earmark-excel" ></i> Cetak Excel RAP
                </button>
                {{-- <a class="btn btn-danger disabled-link">
                    <i class="bi bi-filetype-pdf"></i> Cetak PDF RAP
                </a> --}}
                {{-- <a href="{{ route('rap.export') }}" class="btn btn-success">Export Excel</a> --}}
            </div>
        </div>
        <div class="rounded-1 overflow-hidden border p-0 table-responsive" >
            <table class="table table-striped align-middle mb-0">
                <thead class="table-secondary">
                    <tr>
                      <th class="px-4 py-2 text-dark">No</th>
                        <th class="px-4 py-2 text-dark">KODE KLASIFIKASI</th>
                        <th class="px-4 py-2 text-dark">SUB KEGIATAN</th>
                        <th class="px-4 py-2 text-dark">PAGU</th>
                        <th class="px-4 py-2 text-dark">SUMBER DANA</th>
                        <th class="px-4 py-2 text-dark">TAHUN</th>
                        <th class="px-4 py-2 text-dark">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($raps as $rap)
                    <tr>
                        <td class="px-4 py-1 text-dark">{{ $loop->iteration }}</td>
                        <td class="px-4 py-1 text-dark">{{ $rap->kode_klasifikasi }}</td>
                        <td class="px-4 py-1 text-dark">{{ Str::limit(strip_tags($rap->sub_kegiatan), 30)  }}</td>
                        <td class="px-4 py-1 text-dark">{{ number_format($rap->pagu_tahun_berjalan) }}</td>
                        <td class="px-4 py-1 text-dark">{{ $rap->sumber_dana }}</td>
                        <td class="px-4 py-1 text-dark">{{ date('Y', strtotime($rap->jadwal_awal)) }}</td>
                        <td class="px-4 py-1 d-flex gap-2">
                            <button wire:click="openDetailModal({{ $rap->id }})"
                                class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-5 text-center">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-emoji-tear text-warning" style="font-size: 60px"></i>
                                <span class="fs-5 text-dark">Belum ada RAP!</span>
                            </div>
                        </td>
                    </tr>   
                @endforelse
            </tbody>
            </table>
            {{-- <select id="kegiatan" class="form-control select2" wire:model="idOpd">
                <option value="">-- Pilih Sub Kegiatan --</option>
                   @foreach ($pilihSub as $kegiatan)
                       <option value="{{ $kegiatan->id }}">{{ $kegiatan->sub_kegiatan }}</option>
                   @endforeach
            </select> --}}
        </div>    
     <div class="mt-4">
        {{ $raps->links('vendor.livewire.bootstrap-pagination') }}
    </div>
</div>

{{-- @if ($this->showModal)
        <x-modal :title="$modalTitle" :closeble="true" @click.self="$wire.closeModal()"
            @keydown.escape.window="$wire.closeModal()">
            <x-slot name="closeButton">
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeModal">
                </button>
            </x-slot>
            <hr>
            <form wire:submit.prevent="simpan">
                <div class="mb-3">
                    <label class="form-label"><strong>Instansi OPD</strong></label> 
                        @if ($modalTitle == 'Edit Data Pagu OPD')
                            <input type="text" wire:model="idOpd" class="form-control" disabled>
                        @else
                        <select id="opd" class="form-control select2" wire:model="idOpd">
                                <option value="">-- Pilih Instansi --</option>
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                                    @endforeach
                        </select>
                        @error('opd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
                <div class="mb-3">
                    <label for="paguBG" class="form-label">
                        <strong>Pagu Block Grand (BG 1%)</strong>
                    </label>
                    <input type="number" class="form-control @error('paguBG') is-invalid @enderror" id="pagu_bg"
                        wire:model="paguBG" placeholder="Masukkan Pagu BG..." maxlength="255">
                    @error('paguBG')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="paguSG" class="form-label">
                        <strong>Pagu Spesifik Grand (1,25%)</strong>
                    </label>
                    <input type="number" class="form-control @error('paguSG') is-invalid @enderror" id="pagu_sg"
                        wire:model="paguSG" placeholder="Masukkan Pagu SG..." maxlength="255">
                    @error('paguSG')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="paguDTI" class="form-label">
                        <strong>Pagu Dana Tambahan Infrastruktur (DTI)</strong>
                    </label>
                    <input type="number" class="form-control @error('paguDTI') is-invalid @enderror" id="pagu_dti"
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
                        <span wire:loading wire:target="closeModal">tunggu...</span>
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
    @endif --}}

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
                        <span wire:loading wire:target="closeModal">tunggu...</span>
                    </button>
                </div>
            </x-slot>
        </x-modal>
    @endif --}}
</div>