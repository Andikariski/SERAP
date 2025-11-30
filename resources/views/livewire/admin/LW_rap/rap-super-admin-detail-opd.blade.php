<div>
     @php
        $label = "Detail RAP OPD ";
        $breadcrumbs = [
            ['name' => $label, 'url' => route('superadmin.opd')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
    <div class="mt-5">
       <div class="row align-items-center mb-3 mt-4">
            <div class="col-md-8">
                {{-- <input type="text" placeholder="Search..." wire:model.live="search" class="form-control rounded-1"> --}}
                <h6>{{ $detailOpd->nama_opd }}</h6>
            </div>
            {{-- <div class="col-md-8 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" wire:click="openTambahModal">
                    <i class="bi bi-plus-lg"></i> Input Pagu OPD
                </button>
            </div> --}}
            <div class="col-md-4 d-flex justify-content-end">
                <button class="btn btn-primary disabled-link" wire:click="exportPdfPersentaseRAP">
                    <i class="bi bi-chevron-double-left"></i> Kembali
                </button>
            </div>
        </div>
    </div>   
    <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="bg-tab" data-bs-toggle="tab" data-bs-target="#bg" type="button" role="tab" aria-controls="bg" aria-selected="true"><strong>Otsus Block Grand 1%</strong></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sg-tab" data-bs-toggle="tab" data-bs-target="#sg" type="button" role="tab" aria-controls="sg" aria-selected="false"><strong>Otsus Block Grand 1,25%</strong></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="dti-tab" data-bs-toggle="tab" data-bs-target="#dti" type="button" role="tab" aria-controls="dti" aria-selected="false"><strong>Dana Tambahan Infrastruktur</strong></button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="bg" role="tabpanel" aria-labelledby="bg-tab">
               {{-- <div class="card-border shadow-sm blue mt-2">
                    <div class="card-body py-2 px-2">
                        This is some text within a card body.<br>
                        This is some text within a card body.<br>
                        This is some text within a card body.
                    </div>
                </div> --}}
                 <div class="col-md-4 mt-4">
                        <input type="text" placeholder="Search..." wire:model.live="searchBG" class="form-control rounded-1">
                </div>
                <div class="rounded-1 overflow-hidden border p-0 table-responsive mt-3">
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
                        @forelse ($rapsBG as $rapBG)
                            <tr>
                                <td class="px-4 py-1 text-dark">{{ $loop->iteration }}</td>
                                <td class="px-4 py-1 text-dark">{{ $rapBG->kode_klasifikasi }}</td>
                                <td class="px-4 py-1 text-dark">{{ Str::limit(strip_tags($rapBG->sub_kegiatan), 30)  }}</td>
                                <td class="px-4 py-1 text-dark">{{ number_format($rapBG->pagu_tahun_berjalan) }}</td>
                                <td class="text-dark">
                                    <span class="badge bg-warning m-1">{{ $rapBG->validasi }}</span>
                                </td>
                                <td class="px-4 py-2 d-flex gap-2">
                                        <a href="{{ route('opd.rap.update',['id' => $rapBG->id, 'type' => 'rap-opd-bg']) }}" 
                                            class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1" wire:navigate>
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-5 text-center">
                                    <div class="d-inline-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-emoji-tear text-warning" style="font-size: 60px"></i>
                                        <span class="fs-5 text-dark">RAP Tidak Ditemukan!</span>
                                    </div>
                                </td>
                            </tr>   
                        @endforelse
                    </tbody>
                    </table>
                </div>    
            </div>
            <div class="tab-pane fade" id="sg" role="tabpanel" aria-labelledby="sg-tab">
                    {{-- <div class="card-body py-2 px-2">
                        This is some text within a card body.<br>
                        This is some text within a card body.<br>
                        This is some text within a card body.
                    </div> --}}
                    <div class="col-md-4 mt-4">
                        <input type="text" placeholder="Search..." wire:model.live="searchSG" class="form-control rounded-1">
                    </div>
                    <div class="rounded-1 overflow-hidden border p-0 table-responsive mt-3">
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
                        @forelse ($rapsSG as $rapSG)
                            <tr>
                                <td class="px-4 py-1 text-dark">{{ $loop->iteration }}</td>
                                <td class="px-4 py-1 text-dark">{{ $rapSG->kode_klasifikasi }}</td>
                                <td class="px-4 py-1 text-dark">{{ Str::limit(strip_tags($rapSG->sub_kegiatan), 30)  }}</td>
                                <td class="px-4 py-1 text-dark">{{ number_format($rapSG->pagu_tahun_berjalan) }}</td>
                                <td class="text-dark">
                                    <span class="badge bg-warning m-1">{{ $rapSG->validasi }}</span>
                                </td>
                                <td class="px-4 py-2 d-flex gap-2">
                                        <a href="{{ route('opd.rap.update',['id' => $rapSG->id, 'type' => 'rap-opd-bg']) }}" 
                                            class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1" wire:navigate>
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-5 text-center">
                                    <div class="d-inline-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-emoji-tear text-warning" style="font-size: 60px"></i>
                                        <span class="fs-5 text-dark">RAP Tidak Ditemukan!</span>
                                    </div>
                                </td>
                            </tr>   
                        @endforelse
                    </tbody>
                    </table>
                </div>    
            </div>
            <div class="tab-pane fade" id="dti" role="tabpanel" aria-labelledby="dti-tab">
                    {{-- <div class="card-body py-2 px-2">
                        This is some text within a card body.<br>
                        This is some text within a card body.<br>
                        This is some text within a card body.
                    </div> --}}
                     <div class="col-md-4 mt-4">
                        <input type="text" placeholder="Search..." wire:model.live="searchDTI" class="form-control rounded-1">
                    </div>
                    <div class="rounded-1 overflow-hidden border p-0 table-responsive mt-3">
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
                        @forelse ($rapsDTI as $rapdti)
                            <tr>
                                <td class="px-4 py-1 text-dark">{{ $loop->iteration }}</td>
                                <td class="px-4 py-1 text-dark">{{ $rapdti->kode_klasifikasi }}</td>
                                <td class="px-4 py-1 text-dark">{{ Str::limit(strip_tags($rapdti->sub_kegiatan), 30)  }}</td>
                                <td class="px-4 py-1 text-dark">{{ number_format($rapdti->pagu_tahun_berjalan) }}</td>
                                <td class="text-dark">
                                    <span class="badge bg-warning m-1">{{ $rapdti->validasi }}</span>
                                </td>
                                <td class="px-4 py-2 d-flex gap-2">
                                        <a href="{{ route('opd.rap.update',['id' => $rapdti->id, 'type' => 'rap-opd-bg']) }}" 
                                            class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1" wire:navigate>
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-5 text-center">
                                    <div class="d-inline-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-emoji-tear text-warning" style="font-size: 60px"></i>
                                        <span class="fs-5 text-dark">RAP Tidak Ditemukan</span>
                                    </div>
                                </td>
                            </tr>   
                        @endforelse
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
     <div class="mt-4">
        {{ $rapsBG->links('vendor.livewire.bootstrap-pagination') }}
        {{-- {{ $rapsSG->links('vendor.livewire.bootstrap-pagination') }} --}}
        {{-- {{ $rapsDTI->links('vendor.livewire.bootstrap-pagination') }} --}}
    </div>
</div>



