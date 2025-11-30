<div>
     @php
        $breadcrumbs = [
            ['name' => 'Data RAP', 'url' => route('opd.rap.rapDTI')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
        $color =
            $persentaseInput == 100 ? 'bg-success' :
            ($persentaseInput < 50 ? 'bg-danger' : 'bg-warning');
        
        $colorIcon =
            $persentaseInput == 100 ? '#4caf50' :
            ($persentaseInput < 50 ? '#dc0000' : '#ff9100');

        $is_disabled = ($persentaseInput >= 100) || (!$getPaguOPD || $getPaguOPD->pagu_DTI == 0);
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
<div>
 <div class="card text-white shadow-sm border-0" style="background: linear-gradient(135deg, #219EBC 0%,  #4f46e5 100%);">
        <div class="row">
            <div class="col-3">
                <div class="card-body">
                    <h5 class="card-title">Dana DTI</h5>
                        @if($getPaguOPD && $tahunAktif)
                            <h3 class="fw-bold">
                                {{ number_format($getPaguOPD->pagu_DTI, 0, ',', '.') }}
                            </h3>
                            <p class="mb-0">Tahun Anggaran : <span class="badge bg-success">{{ $getPaguOPD->tahun_pagu }}</span></p>
                        @else
                            <span class="badge bg-warning">Belum ada pagu aktif / Pagu belum dibagi</span>
                        @endif
                </div>
            </div>
            <div class="col-3">
                <div class="card-body">
                    <h5 class="card-title">Dana SiLPA</h5>
                        @if($getPaguOPD && $tahunAktif)
                            <h3 class="fw-bold">-</h3>
                            <p class="mb-0">Tahun Anggaran : <span class="badge bg-success">{{ $getPaguOPD->tahun_pagu }}</span></p>
                        @else
                            <span class="badge bg-warning">Belum ada pagu aktif / Pagu belum dibagi</span>
                        @endif
                </div>
            </div>
            <div class="col-3">
                <div class="card-body">
                    <h5 class="card-title">Sub Kegiatan Terdaftar</h5>
                    @if($getPaguOPD && $tahunAktif)
                        @if($totalSubKegiatan)
                            <h3 class="fw-bold">{{ $totalSubKegiatan }}</h3>
                            <p class="mb-0">Tahun Anggaran : <span class="badge bg-success">{{ $getPaguOPD->tahun_pagu }}</span></p>
                        @else
                            <h3 class="fw-bold">-</h3>
                        @endif
                        @else
                        <span class="badge bg-warning">Belum ada pagu aktif / Pagu belum dibagi</span>
                    @endif
                </div>
            </div>
            <div class="col-3">
            <div class="card-body">
                <h5 class="card-title">Akses & Status RAP</h5>
                {{-- Kode Notifikasi Status Akses RAP --}}
                    @if ($statusAkses === 'Buka')
                        <div class="d-flex align-items-center mb-1">
                            <span class="badge bg-success me-1">
                                <i class="bi bi-unlock-fill fs-5 text-white"></i>
                            </span>
                            <h6 class="fw-bold mb-0">Terbuka</h6>
                        </div>
                        {{-- <p class="mb-0 text-muted">Akses RAP Terbuka</p> --}}
                    @elseif($statusAkses === 'Tutup')
                        <div class="d-flex align-items-center mb-1">
                            <span class="badge bg-warning me-1">
                                <i class="bi bi-lock-fill fs-5 text-white"></i>
                            </span>
                            <h6 class="fw-bold mb-0">Terkunci</h6>
                        </div>
                        {{-- <p class="mb-0 text-muted">Akses RAP Tertutup</p> --}}
                    @endif

                    {{-- Kode Notifikasi Status RAP --}}
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success me-1">
                            <i class="bi bi-repeat-1 fs-5 text-white"></i>
                        </span>
                        @if ($statusRAP === 'RAP Awal')
                            <h6 class="fw-bold mb-0">RAP Awal</h6>
                        @elseif($statusRAP === 'RAP Penyesuaian')
                            <h6 class="fw-bold mb-0">RAP Penyesuaian</h6>
                        @elseif($statusRAP === 'RAP Perubahan II')
                            <h6 class="fw-bold mb-0">RAP Perubahan II</h6>
                        @elseif($statusRAP === 'RAP Perubahan III')
                            <h6 class="fw-bold mb-0">RAP Perubahan III</h6>
                        @endif
                    </div>
            </div>
            </div>
        </div>
    </div>
  
    <div class="row">
        <ul class="p-2 m-0">
            <li class="mb-2 d-flex align-items-center">
                <!-- Kolom Proyek: Mengunci lebar menjadi 40% agar semua baris lurus -->
                <div class="d-flex align-items-center me-3" style="width: 40%;">
                    @if($persentaseInput == 100) 
                        <i class="bi bi-check2-circle me-3" style="font-size: 2.6rem; color:#048000"></i>
                    @else
                        <i class="bi bi-exclamation-diamond me-3" style="font-size: 2.6rem; color:{{ $colorIcon }}"></i>
                    @endif
                    <div>
                        <h5 class="mb-0 fw-semibold text-truncate" title="Dana Otsus Block Grand">Dana Tambahan Infrastruktur</h5>
                        <small class="text-dark">
                            Pagu Terinput 
                            <strong style="color:#1a9c00">{{number_format($totalPaguTerinput, 0, ',', '.') }}</strong>,
                            Sisa Pagu DTI 
                            <strong style="color:#ffa200">{{number_format($paguSisa, 0, ',', '.') }}</strong>
                        </small>
                    </div>
                </div>
                <!-- Kolom Progress Bar: Menggunakan flex-grow-1 agar mengambil sisa ruang 60% -->
                <div class="d-flex flex-grow-1 align-items-center">
                    <div class="progress w-100 me-4" style="height:15px;">
                        <div class="progress-bar {{ $color }}" role="progressbar" style="width: {{ $persentaseInput }}%" aria-valuenow="{{ $persentaseInput }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="fw-semibold" style="font-size: 0.9rem;"><h6>{{ $persentaseInput }}%</h6></span>
                </div>
            </li>
        </ul>
    </div>

    <div class="row align-items-center mb-3">
            <div class="col-md-4">
                <input type="text" placeholder="Search..." wire:model.live="search" class="form-control rounded-1">
            </div>
           <div class="col-md-8 d-flex justify-content-end">
            {{-- Jika status akses Tutup --}}
            @if($statusAkses === 'Tutup' || !$getPaguOPD)
                <a class="btn btn-outline-secondary disabled-link">
                    <i class="bi bi-lock-fill"></i> Akses Terkunci
                </a>
            {{-- Jika status akses Buka --}}
            @elseif($statusAkses === 'Buka')
                {{-- Jika persentase masih kurang dari 100 → tombol aktif --}}
                @if(!$is_disabled) 
                    {{-- Tombol AKTIF --}}
                    <a href="{{ route('opd.rap.create',['type' => 'rap-opd-dti']) }}" 
                    class="btn btn-primary" wire:navigate>
                        <i class="bi bi-journal-plus"></i> Input RAP
                    </a>
                @else
                    {{-- Tombol DISABLED --}}
                    <a class="btn btn-outline-primary disabled-link">
                        <i class="bi bi-lock-fill"></i> Input RAP
                    </a>
                @endif
            @endif
            {{-- {{ $getPaguOPD }} --}}
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
                        <th class="px-4 py-2 text-dark">STATUS</th>
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
                        <td class="text-dark">
                             <span class="badge bg-warning m-1">{{ $rap->validasi }}</span>
                        </td>
                        <td class="px-4 py-2 d-flex gap-2">
                               @if($statusAkses === 'Buka')

                                 <a href="{{ route('opd.rap.update',['id' => $rap->id, 'type' => 'rap-opd-dti']) }}" 
                                    class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1" wire:navigate>
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button wire:click="openDetailModal({{ $rap->id }})"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button wire:click="$dispatch('confirm-delete-data-RAPDTI', {{ $rap }})"
                                    class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            @else
                                <span class="badge bg-danger m-1">Akses Terkunci</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-5 text-center">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-emoji-tear text-warning" style="font-size: 60px"></i>
                                <span class="fs-5 text-dark">RAP Belum diInput!</span>
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

