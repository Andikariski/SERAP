<div>
     @php
        $breadcrumbs = [
            ['name' => 'Detail Pagu Induk Tahun Anggaran ' . $getTahunAktif->tahun_pagu, 'url' => route('superadmin.opd')],
            // ['name' => 'Artikel', 'url' => route('superadmin.opd')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
<div>

{{-- <div class="card text-white shadow-sm border-0" style="background: linear-gradient(135deg, #219EBC 0%,  #4f46e5 100%);">
    <div class="mt-4"></div>
</div> --}}

{{-- <div class="px-3 py-4" style="background-color: #f0f4f8; min-height: 100vh;"> --}}
 
    {{-- Page Header --}}
    {{-- <div class="mb-4">
        <h5 class="fw-bold text-dark mb-1">Perubahan Pertama</h5>
        <small class="text-muted">
            Dana Otsus Papua <span class="mx-1">•</span> Perencanaan <span class="mx-1">•</span> RAP Perubahan Pertama
        </small>
    </div> --}}
 
    {{-- Cards Grid --}}
    <div class="row g-4 mt-2">
 
        {{-- Card 1: Otsus 1% --}}
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 otsus-card">
                <div class="card-body d-flex flex-column gap-1 p-4">
 
                    <div class="d-flex align-items-start gap-3">
                        <div class="otsus-icon icon-green flex-shrink-0">
                           <i class="bi bi-grid"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 text-dark">Otsus 1%</h6>
                            <small class="text-muted">Dana Otonomi Khusus yang Bersifat Umum</small>
                        </div>
                        <span class="badge badge-green">Aktif</span>
                    </div>
 
                    <div>
                        <small class="text-muted d-block mt-1">Total Alokasi</small>
                        <p class="otsus-amount mb-1">Rp {{ number_format($paguInduk->pagu_BG, 0, ',', '.') }}</p>
                        <div class="progress otsus-progress">
                            <div class="progress-bar bg-c-green" style="width: 90%"></div>
                        </div>
                    </div>
 
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Dokumen: 24</small>
                        <small class="text-muted">SKPD: {{ $skpdOtsusBG }}</small>
                    </div>
 
                    <div class="d-flex gap-1 flex-wrap mt-auto">
                        <button class="btn btn-sm btn-outline-c-green">Form A</button>
                        <button class="btn btn-sm btn-ghost-green">Lihat Otsus 1%</button>
                    </div>
 
                </div>
            </div>
        </div>
 
        {{-- Card 2: Otsus 1,25% --}}
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 otsus-card">
                <div class="card-body d-flex flex-column gap-1 p-4">
 
                    <div class="d-flex align-items-start gap-3">
                        <div class="otsus-icon icon-purple flex-shrink-0">
                          <i class="bi bi-grid"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 text-dark">Otsus 1,25%</h6>
                            <small class="text-muted">Dana Otonomi Khusus yang telah Ditentukan Penggunaannya</small>
                        </div>
                        <span class="badge badge-purple">Aktif</span>
                    </div>
 
                    <div>
                        <small class="text-muted d-block mt-1">Total Alokasi</small>
                        <p class="otsus-amount mb-1">Rp {{ number_format($paguInduk->pagu_SG, 0, ',', '.') }}</p>
                        <div class="progress otsus-progress">
                            <div class="progress-bar bg-c-purple" style="width: 50%"></div>
                        </div>
                    </div>
 
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Dokumen: 24</small>
                        <small class="text-muted">SKPD: {{ $skpdOtsusSG }}</small>
                    </div>
 
                    <div class="d-flex gap-2 flex-wrap mt-auto">
                        <button class="btn btn-sm btn-outline-c-purple">Form A</button>
                        <button class="btn btn-sm btn-ghost-purple">Lihat Otsus 1,25%</button>
                    </div>
 
                </div>
            </div>
        </div>

        {{-- Card 3: Otsus DTI --}}
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 otsus-card">
                <div class="card-body d-flex flex-column gap-1 p-4">
 
                    <div class="d-flex align-items-start gap-3">
                        <div class="otsus-icon icon-yellow flex-shrink-0">
                           <i class="bi bi-buildings"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 text-dark">DTI</h6>
                            <small class="text-muted">Dana Otonomi Khusus Tambahan Infrastruktur</small>
                        </div>
                        <span class="badge badge-yellow">Aktif</span>
                    </div>
 
                    <div>
                        <small class="text-muted d-block mt-1">Total Alokasi</small>
                        <p class="otsus-amount mb-1">Rp {{ number_format($paguInduk->pagu_DTI, 0, ',', '.') }}</p>
                        <div class="progress otsus-progress">
                            <div class="progress-bar bg-c-yellow" style="width: 50%"></div>
                        </div>
                    </div>
 
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Dokumen: 24</small>
                        <small class="text-muted">SKPD: {{ $skpdOtsusDTI }}</small>
                    </div>
 
                    <div class="d-flex gap-2 flex-wrap mt-auto">
                        <button class="btn btn-sm btn-outline-c-yellow">Form A</button>
                        <button class="btn btn-sm btn-ghost-yellow">Lihat Otsus 1,25%</button>
                    </div>
 
                </div>
            </div>
        </div>

        {{-- Card 4: SiLPA Melanjutkan --}}
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 otsus-card">
                <div class="card-body d-flex flex-column gap-1 p-4">
 
                    <div class="d-flex align-items-start gap-3">
                        <div class="otsus-icon icon-teal flex-shrink-0">
                            <i class="bi bi-repeat"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 text-dark">SiLPA Melanjutkan</h6>
                            <small class="text-muted">Sisa Lebih Penggunaan Anggaran Melanjutkan</small>
                        </div>
                        <span class="badge badge-teal">Aktif</span>
                    </div>
 
                    <div>
                        <small class="text-muted d-block mt-1">Total Alokasi</small>
                        <p class="otsus-amount mb-1">Rp {{ number_format($paguInduk->pagu_SiLPA_Melanjutkan, 0, ',', '.') }}</p>
                        <div class="progress otsus-progress">
                            <div class="progress-bar bg-c-teal" style="width: 50%"></div>
                        </div>
                    </div>
 
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Dokumen: 24</small>
                        <small class="text-muted">SKPD: {{ $skpdOtsusSiLPAmelanjutkan }}</small>
                    </div>
 
                    <div class="d-flex gap-2 flex-wrap mt-auto">
                        <button class="btn btn-sm btn-outline-c-teal">Form A</button>
                        <button class="btn btn-sm btn-ghost-teal">Lihat Otsus 1,25%</button>
                    </div>
 
                </div>
            </div>
        </div>

        {{-- Card 5: SiLPA Efisiensi --}}
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 otsus-card">
                <div class="card-body d-flex flex-column gap-1 p-4">
 
                    <div class="d-flex align-items-start gap-3">
                        <div class="otsus-icon icon-blue flex-shrink-0">
                           <i class="bi bi-repeat"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 text-dark">SiLPA Efisiensi</h6>
                            <small class="text-muted">Sisa Lebih Penggunaan Anggaran Efisiensi</small>
                        </div>
                        <span class="badge badge-blue">Aktif</span>
                    </div>
 
                    <div>
                        <small class="text-muted d-block mt-1">Total Alokasi</small>
                        <p class="otsus-amount mb-1">Rp {{ number_format($paguInduk->pagu_SiLPA_Efisiensi, 0, ',', '.') }}</p>
                        <div class="progress otsus-progress">
                            <div class="progress-bar bg-c-blue" style="width: 50%"></div>
                        </div>
                    </div>
 
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Dokumen: 24</small>
                        <small class="text-muted">SKPD: {{ $skpdOtsusSiLPAefisiensi }}</small>
                    </div>
 
                    <div class="d-flex gap-2 flex-wrap mt-auto">
                        <button class="btn btn-sm btn-outline-c-blue">Form A</button>
                        <button class="btn btn-sm btn-ghost-blue">Lihat Otsus 1,25%</button>
                    </div>
 
                </div>
            </div>
        </div>


        {{-- Card 6: Dana Lainya --}}
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 otsus-card">
                <div class="card-body d-flex flex-column gap-1 p-4">
 
                    <div class="d-flex align-items-start gap-3">
                        <div class="otsus-icon icon-red flex-shrink-0">
                           <i class="bi bi-repeat"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 text-dark">Dana Lainya</h6>
                            <small class="text-muted">Dana Lainnya yang bersifat darurat untuk kebutuhan tertentu</small>
                        </div>
                        <span class="badge badge-red">Aktif</span>
                    </div>
 
                    <div>
                        <small class="text-muted d-block mt-1">Total Alokasi</small>
                        <p class="otsus-amount mb-1">Rp {{ number_format($paguInduk->pagu_SiLPA_Efisiensi, 0, ',', '.') }}</p>
                        <div class="progress otsus-progress">
                            <div class="progress-bar bg-c-red" style="width: 50%"></div>
                        </div>
                    </div>
 
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Dokumen: 24</small>
                        <small class="text-muted">SKPD: -</small>
                    </div>
 
                    <div class="d-flex gap-2 flex-wrap mt-auto">
                        <button class="btn btn-sm btn-outline-c-red">Form A</button>
                        <button class="btn btn-sm btn-ghost-red">Lihat Otsus 1,25%</button>
                    </div>
 
                </div>
            </div>
        </div>
</div>
{{-- </div> --}}

        