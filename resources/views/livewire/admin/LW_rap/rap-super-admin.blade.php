<div>
     @php
        $breadcrumbs = [
            ['name' => 'Data RAP Induk Tahun ' . ($getTahunAktif->tahun_pagu ?? '-'), 'url' => route('superadmin.pagu.induk')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
<div>
   
    <div class="mt-5">
       <div class="row align-items-center mb-3 mt-4">
            <div class="col-md-3">
                <input type="text" placeholder="Search..." wire:model.live="search" class="form-control rounded-1">
            </div>
            <div class="col-md-2">
                <select class="form-control" wire:model.live="filterOpd">
                        <option   option value="">--Semua OPD--</option>
                    @foreach ($opds as $opd)
                        <option value="{{ $opd->fkid_opd }}">{{ $opd->opd->kode_opd ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" wire:model.live="filterTahun">
                        <option   option value="">--Semua Tahun--</option>
                    @foreach ($tahuns as $tahun)
                        <option value="{{ $tahun }}">Tahun {{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" wire:model.live="filterSumberDana">
                        <option   option value="">--Semua Sumber Dana--</option>
                    @foreach ($pagus as $pagu)
                        <option value="{{ $pagu }}">Dana {{ $pagu }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex justify-content-end">
                <button type="button" class="btn btn-success" wire:click="exportExcel">
                    <i class="bi bi-file-earmark-excel"></i> Export Data
                </button>
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
                        <th class="px-4 py-2 text-dark">OPD</th>
                        <th class="px-4 py-2 text-dark">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                 @forelse ($raps as $rap)
                    <tr>
                        <td class="px-4 py-1 text-dark">{{ $loop->iteration }}</td>
                        <td class="px-4 py-1 text-dark">{{ $rap->kode_klasifikasi }}</td>
                        <td class="px-4 py-1 text-dark">{{ Str::limit(strip_tags($rap->sub_kegiatan), 40) }}</td>
                        <td class="px-4 py-1 text-dark">{{ number_format($rap->pagu_tahun_berjalan) }}</td>
                        <td class="px-4 py-1 text-dark">{{ $rap->sumber_dana }}</td>
                        <td class="px-4 py-1 text-dark">{{ $rap->opd->kode_opd ?? 'N/A' }}</td>
                        <td class="px-4 py-1 d-flex gap-2">

                                {{-- <button wire:click="openEditModal({{ $pagu->id }})"
                                    class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1">
                                    <i class="bi bi-pencil"></i>
                                </button> --}}

                                <button wire:click="openDetailModal({{ $rap->id }})"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                    <i class="bi bi-eye"></i>
                                </button>
{{-- 
                                <button wire:click="$dispatch('confirm-delete-data-paguOPD', {{ $pagu }})"
                                    class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                    <i class="bi bi-trash3"></i>
                                </button> --}}
                            </td> 
                    </tr>
                 @empty 
                    <tr>
                        <td colspan="7" class="px-4 py-5 text-center">
                            <div class="d-inline-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-database-x text-warning" style="font-size: 60px"></i>
                                <span class="fs-5 text-dark">RAP Belum diInput/RAP Tidak Ditemukan!</span>
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
    </div>   
    <div class="card border-info mt-4">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-info-circle text-info"></i> Informasi
                </h6>
                <ul class="mb-0 small">
                    <li>Sebelum melakukan Export Data RAP, pastikan beberapa hal berikut.</li>
                    <li>Jika tidak memilih OPD terlebih dahulu, maka data tidak akan dapat dieksport.</li>
                    <li>Pilih OPD yang akan di Export terlebih dahulu.</li>
                    <li>Pilih Tahun Anggaran yang akan di Export.</li>
                    <li>Pilih Sumber Dana yang akan di Export.</li>
                </ul>
            </div>
        </div>
     <div class="mt-4">
        {{-- {{ $pagus->links('vendor.livewire.bootstrap-pagination') }} --}}
    </div>
</div>
</div>
<script>
    $('#kegiatan').select2({
        width: '50%'
    })
</script>


