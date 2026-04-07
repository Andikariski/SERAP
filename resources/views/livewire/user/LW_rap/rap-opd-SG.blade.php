<div>
     @php
        $breadcrumbs = [
            ['name' => 'Data RAP', 'url' => route('opd.rap.rapSG')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
        $color =
            $persentaseInput == 100 ? 'bg-success' :
            ($persentaseInput < 50 ? 'bg-danger' : 'bg-warning');
        
        $colorIcon =
            $persentaseInput == 100 ? '#4caf50' :
            ($persentaseInput < 50 ? '#dc0000' : '#ff9100');
        
         $is_disabled = ($persentaseInput >= 100) || (!$getPaguOPD || $getPaguOPD->pagu_SG == 0);
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />

    {{-- @if($getPaguOPD->pagu_SG == 0)
        <div class="alert alert-warning d-flex align-items-center" role="alert">
            <div>
                 <h4 class="alert-heading">
                    <i class="bi bi-exclamation-diamond" style="font-size: 30px"></i>
                    Perhatian..!!
                </h4>
                Pagu Dana Otsus Spesifik Grand (SG) Anda sebesar <strong>0</strong>. Silakan hubungi administrator, jika membutuhkan informasi lebih lanjut.
            </div>
        </div>
    @elseif($getPaguOPD->pagu_SG !=0) --}}
    <div class="card text-white shadow-sm border-0" style="background: linear-gradient(135deg, #219EBC 0%,  #4f46e5 100%);">
        <div class="row">
            <div class="col-3">
                <div class="card-body">
                    <h5 class="card-title">Dana Otsus SG</h5>
                        @if($getPaguOPD && $tahunAktif)
                            <h3 class="fw-bold">
                                {{ number_format($getPaguOPD->pagu_SG, 0, ',', '.') }}
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
                        <h5 class="mb-0 fw-semibold text-truncate" title="Dana Otsus Block Grand">Dana Otsus Spesifik Grand</h5>
                        <small class="text-dark">
                            Pagu Terinput 
                            <strong style="color:#1a9c00">{{number_format($totalPaguTerinput, 0, ',', '.') }}</strong>,
                            Sisa Pagu SG
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
                    <a href="{{ route('opd.rap.create',['type' => 'rap-opd-sg']) }}" 
                    class="btn btn-primary" wire:navigate>
                        <i class="bi bi-journal-plus"></i> Input RAP
                    </a>
                {{-- Jika persentase sudah 100 → tombol disabled --}}
                @else
                    <a class="btn btn-outline-primary disabled-link">
                        <i class="bi bi-lock-fill"></i> Input RAP
                    </a>
                @endif
            @endif
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

                                 <a href="{{ route('opd.rap.update',['id' => $rap->id, 'type' => 'rap-opd-sg']) }}" 
                                    class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1" wire:navigate>
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button wire:click="openDetailModal({{ $rap->id }})"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button wire:click="$dispatch('confirm-delete-data-RAPSG', {{ $rap }})"
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
                                 <i class="bi bi-database-x text-warning" style="font-size: 60px"></i>
                                <span class="fs-5 text-dark">RAP Masih Kosong!</span>
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
{{-- @endif --}}
</div>


