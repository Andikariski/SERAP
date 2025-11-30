<div>
     @php
        $label = "Rekapitulasi Persentase Input RAP Tahun $tahunAktif";
        $breadcrumbs = [
            ['name' => $label, 'url' => route('superadmin.opd')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
    <div class="mt-5">
       <div class="row align-items-center mb-3 mt-4">
            <div class="col-md-4">
                <input type="text" placeholder="Search..." wire:model.live="search" class="form-control rounded-1">
            </div>
            {{-- <div class="col-md-8 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" wire:click="openTambahModal">
                    <i class="bi bi-plus-lg"></i> Input Pagu OPD
                </button>
            </div> --}}
            <div class="col-md-8 d-flex justify-content-end">
                {{-- <button class="btn btn-success disabled-link" wire:click="exportExcelPersentaseRAP">
                    <i class="bi bi-file-earmark-excel" ></i> Cetak Excel
                </button> --}}
                <button class="btn btn-danger disabled-link" wire:click="exportPdfPersentaseRAP">
                    <i class="bi bi-filetype-pdf"></i> Cetak PDF
                </button>
            </div>
        </div>

        <div class="rounded-1 overflow-hidden border p-0">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-secondary">
                    <tr>
                        <th class="px-4 py-2 text-dark">NO</th>
                        <th class="px-4 py-2 text-dark">NAMA OPD</th>
                        {{-- <th class="px-4 py-2 text-dark" style="width: 5%">TAHUN</th> --}}
                        <th class="px-4 py-2 text-dark" style="width: 17%">PAGU BG</th>
                        <th class="px-4 py-2 text-dark" style="width: 17%">PAGU SG</th>
                        <th class="px-4 py-2 text-dark" style="width: 17%">PAGU DTI</th>
                        <th class="px-4 py-2 text-dark">TOTAL</th>
                        <th class="px-4 py-2 text-dark">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($data as $d)
                    <tr>
                        <td class="px-4 py-1 text-dark">{{ $loop->iteration }}</td> <!-- Nomor urut -->
                        <td class="px-4 py-1 text-dark">
                            {{ Str::limit(strip_tags($d->opd->kode_opd), 30) }}
                            {{-- <p>Rencana : </p>
                            <p>Terinput : </p> --}}
                        </td>
                        {{-- <td class="px-4 py-1 text-dark">{{ $d->tahun_pagu }}</td> --}}
                        <td class="px-4 py-1 text-dark">
                            @if($d->persen_BG >= 0)
                                <div class="d-flex align-items-center w-100">
                                    <div class="progress flex-grow-1 me-1" style="height: 13px;">
                                        <div class="progress-bar {{ $d->persen_BG == 100 ? 'bg-success' : ($d->persen_BG < 50 ? 'bg-danger' : 'bg-warning') }}"
                                            role="progressbar" style="width: {{ $d->persen_BG }}%;" aria-valuenow="{{ $d->persen_BG }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <!-- Persentase di luar bar (kanan) -->
                                    <span>{{ $d->persen_BG }}%</span>
                                </div>
                            @else
                                <strong style="color: red">--</strong>
                            @endif
                        </td>
                        <td class="px-4 py-1 text-dark">
                            @if($d->persen_SG >= 0)
                                <div class="d-flex align-items-center w-100">
                                    <div class="progress flex-grow-1 me-1" style="height: 13px;">
                                        <div class="progress-bar {{ $d->persen_SG == 100 ? 'bg-success' : ($d->persen_SG < 50 ? 'bg-danger' : 'bg-warning') }}"
                                            role="progressbar" style="width: {{ $d->persen_SG }}%;" aria-valuenow="{{ $d->persen_SG }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <!-- Persentase di luar bar (kanan) -->
                                    <span>{{ $d->persen_SG }}%</span>
                                </div>
                            @else
                                <strong style="color: red">--</strong>
                            @endif
                        </td>
                        <td class="px-4 py-1 text-dark">
                            @if($d->persen_DTI >= 0)
                                <div class="d-flex align-items-center w-100">
                                    <div class="progress flex-grow-1 me-1" style="height: 13px;">
                                        <div class="progress-bar {{ $d->persen_DTI == 100 ? 'bg-success' : ($d->persen_DTI < 50 ? 'bg-danger' : 'bg-warning') }}"
                                            role="progressbar" style="width: {{ $d->persen_DTI }}%;" aria-valuenow="{{ $d->persen_DTI }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <!-- Persentase di luar bar (kanan) -->
                                    <span>{{ $d->persen_DTI }}%</span>
                                </div>
                            @else
                                <strong style="color: red">--</strong>
                            @endif
                        </td>
                        <td class="px-4 py-1 text-dark"><strong>{{ $d->persen_total }} %</strong></td>
                        <td class="px-4 py-1 d-flex gap-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('superadmin.rap.detailOPD',$d->fkid_opd) }}" 
                                    class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1" wire:navigate>
                                    <i class="bi bi-chevron-double-right"></i>
                            </a>
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
        </div>    
    </div>   
     <div class="mt-4">
        {{-- {{ $data->links('vendor.livewire.bootstrap-pagination') }} --}}
    </div>
</div>



