<div>
     @php
        $previous = url()->previous();
            if ($previous === url()->current()) {
                $previous = route('opd.rap.rapBG'); // default fallback
            }
        $breadcrumbs = [
            ['name' => 'Data RAP', 'url' => url()->previous()],
            ['name' => 'Input RAP', 'url' => route('opd.rap.create')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
<div>

    <div class="mt-5">
        {{-- <div class="rounded-1 overflow-hidden border p-0 table-responsive" > --}}
            <form wire:submit.prevent="simpan">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>Sub Kegiatan</strong></label> 
                        <select wire:ignore id="selectSubKegiatan" class="form-control select2" data-url="{{ url('api/get-sub-kegiatan') }}">
                            <option value="">-- Cari Sub Kegiatan --</option>
                            {{-- @foreach ($subKegiatans as $kegiatan)
                                <option value="{{ $kegiatan->id }}">{{ $kegiatan->sub_kegiatan }}</option>
                            @endforeach --}}
                        </select>
                        <input type="hidden" class="form-control" readonly wire:model="sub_kegiatan">
                        <input type="hidden" class="form-control" readonly wire:model="aktivitas_utama">
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label class="form-label"><strong>Kewenangan</strong></label> 
                                <input type="text" class="form-control" readonly wire:model="kewenangan" disabled>
                            </div>
                            <div class="col">
                                <label class="form-label"><strong>Kode Klasifikasi</strong></label> 
                                <input type="text" class="form-control" readonly wire:model="kode_klasifikasi" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Klasifikasi Belanja</strong></label> 
                        <input type="text" class="form-control" readonly wire:model="klasifikasi_belanja" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Jenis Kegiatan</strong><span style="color: red;">*</span></label> 
                            <select class="form-control select2 @error('jenis_kegiatan') is-invalid @enderror" wire:model="jenis_kegiatan">
                                <option value="">-- Pilih Jenis Kegiatan --</option>
                                <option value="fiskik">Kegiatan Fisik</option>
                                <option value="nonfiskik">Kegiatan Non-Fisik</option>
                            </select>
                            @error('jenis_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Volume Tahun Berjalan</strong><span style="color: red;">*</span></label> 
                        <input type="number" class="form-control @error('volume_tahun_berjalan') is-invalid @enderror" wire:model="volume_tahun_berjalan">
                        @error('volume_tahun_berjalan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Volume SiLPA Melanjutkan Kegiatan</strong></label> 
                        <input type="number" class="form-control"  wire:model="volume_silpa_melanjutkan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Volume SiLPA Efisiensi Tahun Lalu</strong></label> 
                        <input type="number" class="form-control"  wire:model="volume_silpa_efisiensi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Satuan</strong></label> 
                        <input type="text" class="form-control" disabled wire:model="satuan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Indikator</strong></label> 
                        <input type="text" class="form-control" disabled wire:model="indikator">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Output Kinerja</strong></label> 
                        <input type="text" class="form-control" disabled wire:model="kinerja">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Pagu Tahun Berjalan</strong><span style="color: red;">*</span></label> 
                         <span class="badge bg-success">Sisa Pagu : {{number_format($showSisaPagu, 0, ',', '.')  }}</span>
                        <input type="text" class="form-control format-rupiah @error('pagu_tahun_berjalan') is-invalid @enderror"  wire:model="pagu_tahun_berjalan">
                         @error('pagu_tahun_berjalan')
                             <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Pagu SiLPA Melanjutkan</strong></label> 
                        <input type="text" class="form-control format-rupiah"  wire:model="pagu_silpa_melanjutkan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Pagu SiLPA Efisiensi</strong></label> 
                        <input type="text" class="form-control format-rupiah"  wire:model="pagu_silpa_efisiensi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Sumber Dana</strong></label>
                        <input type="text" class="form-control" wire:model="sumber_dana" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Sinergi Dana Lain</strong><span style="color: red;">*</span></label> 
                            <select id="subKegiatan" class="form-control select2 @error('sinergi_dana_lain') is-invalid @enderror" wire:model="sinergi_dana_lain">
                                <option value="">-- Pilih Sinergi Dana Lain --</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                                <option value="Otsus 1%">Otsus 1% (BG)</option>
                                <option value="Otsus 1,25%">Otsus 1,25% (SG)</option>
                                <option value="Dti">Dana Tambahan Infrastruktur (DTI)</option>
                            </select>
                            @error('sinergi_dana_lain')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>PPSB</strong><span style="color: red;">*</span></label> 
                            <select id="subKegiatan" class="form-control select2 @error('ppsb') is-invalid @enderror" wire:model="ppsb">
                                <option value="">-- Pilih PPSB --</option>                                 
                                <option value="ya">Ya</option>
                                <option value="tidak">Tidak</option>
                            </select>
                            @error('ppsb')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    {{-- <label class="mt-2" style="color: red;"><span >*</span> <i>Menandakan kolom wajib untuk id isi</i></label> --}}
                   
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>Aktivitas Utama</strong></label> 
                            <select wire:ignore id="selectActivitasUtama" class="form-control select2" data-url="{{ url('api/get-aktivitas-utama') }}">
                                <option value="">-- Cari Aktivitas Utama --</option>
                                    {{-- @foreach ($aktivitas as $aktv)
                                        <option value="{{ $aktv->id }}">{{ $aktv->aktivitas_utama }}</option>
                                    @endforeach --}}
                            </select>
                            {{-- @error('subKegaitan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror --}}
                    </div>
                     <div class="mb-3">
                        <label class="form-label"><strong>Tema Pembangunan</strong></label> 
                        <input type="text" class="form-control" disabled wire:model="tema_pembangunan">
                    </div>
                     <div class="mb-3">
                        <label class="form-label"><strong>Program Prioritas</strong></label> 
                        <input type="text" class="form-control" disabled wire:model="program_prioritas">
                    </div>
                     <div class="mb-3">
                        <label class="form-label"><strong>Target Keluaran Strategis</strong></label> 
                        <input type="text" class="form-control" disabled wire:model="target_keluaran_strategis">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Lokus</strong><span style="color: red;">*</span></label> 
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror"  wire:model="lokasi">
                         @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ==================================================================
                         FIELD "Titik Lokus" — VERSI BARU DENGAN PETA LEAFLET
                         (menggantikan field lama yang cuma input text manual)
                         ================================================================== --}}
                    <div class="mb-3">
                        <label class="form-label"><strong>Titik Lokus</strong><span style="color: red;">*</span></label>
                        <div class="tl-field-row">
                            <input type="text" id="titikLokasiInput"
                                   class="tl-input @error('titik_lokasi') is-invalid @enderror"
                                   placeholder="Klik tombol di samping untuk pilih di peta"
                                   wire:model="titik_lokasi" readonly>
                            <div wire:ignore>
                                <button type="button" class="tl-btn-map" id="openMapBtn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 21s-7-6.5-7-11a7 7 0 1 1 14 0c0 4.5-7 11-7 11z"/>
                                        <circle cx="12" cy="10" r="2.5"/>
                                    </svg>
                                    Pilih di Peta
                                </button>
                            </div>
                        </div>
                        @error('titik_lokasi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        {{-- <div class="tl-hint">
                            Klik tombol pilih peta untuk membuka peta interaktif.
                        </div> --}}
                    </div>
                    {{-- ================================================================== --}}

                    <div class="mb-3">
                        <label class="form-label"><strong>Sasaran Penerima</strong><span style="color: red;">*</span></label> 
                            <select id="subKegiatan" class="form-control select2 @error('sasaran') is-invalid @enderror" wire:model="sasaran">
                                <option value="">-- Pilih Sasaran Penerima --</option>                                 
                                <option value="Oap">Orang Asli Papua (OAP)</option>
                                <option value="Umum">Masyarakat Umum</option>
                            </select>
                            @error('sasaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Penerima Manfaat</strong><span style="color: red;">*</span></label> 
                            <select id="subKegiatan" class="form-control select2 @error('penerima_manfaat') is-invalid @enderror" wire:model="penerima_manfaat">
                                <option value="">-- Pilih Penerima Manfaat --</option>                                 
                                <option value="Sub Kegaitan Pendukung">Sub Kegiatan Pendukung</option>
                                <option value="Terikat Langsung Ke Penerima Manfaat">Terikat Langsung Ke Penerima Manfaat</option>
                            </select>
                            @error('penerima_manfaat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Multiyears</strong><span style="color: red;">*</span></label> 
                            <select id="subKegiatan" class="form-control select2 @error('multiyears') is-invalid @enderror" wire:model="multiyears">
                                <option value="">-- Pilih Multiyears --</option>                                 
                                <option value="ya">Ya</option>
                                <option value="tidak">Tidak</option>
                            </select>
                            @error('multiyears')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label class="form-label"><strong>Jadwal Mulai</strong><span style="color: red;">*</span></label> 
                                <input type="date" class="form-control @error('jadwal_awal') is-invalid @enderror" wire:model="jadwal_awal">
                                @error('jadwal_awal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label class="form-label"><strong>Jadwal Selesai</strong><span style="color: red;">*</span></label> 
                                <input type="date" class="form-control @error('jadwal_akhir') is-invalid @enderror" wire:model="jadwal_akhir">
                                @error('jadwal_akhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Data Dukung RKA</strong><span style="color: red;">*</span></label> 
                        <input type="text" class="form-control @error('data_rka') is-invalid @enderror"  wire:model="data_rka">
                         @error('data_rka')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Data Dukung KAK</strong><span style="color: red;">*</span></label> 
                        <input type="text" class="form-control @error('data_kak') is-invalid @enderror"  wire:model="data_kak">
                         @error('data_kak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Data Dukung Lainya</strong><span style="color: red;">*</span></label> 
                        <input type="text" class="form-control @error('data_lainya') is-invalid @enderror"  wire:model="data_lainya">
                         @error('data_lainya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Deskripsi Keterangan</strong></label> 
                        <textarea class="form-control" style="min-height: 217px; resize: none;" wire:model="keterangan"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-9"> 
                    <div class="card border-info mt-4">
                        <div class="card-body">
                        <h6 class="card-title">
                            <i class="bi bi-info-circle text-info"></i> Informasi
                                </h6>
                                    <ul class="mb-0 small">
                                        <li>Tanda bintang (*) menunjukkan kolom yang wajib diisi.</li>
                                        <li>Pastikan untuk memilih sub kegiatan yang sesuai dengan rencana kegiatan yang akan diusulkan.</li>
                                        <li>Perhatikan batasan pagu tahun berjalan yang ditampilkan untuk menghindari pengajuan melebihi batas yang tersedia.</li>
                                    </ul>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row justify-content-end">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-danger mt-4 me-1" wire:click="resetFormAction" wire:loading.attr="disabled"> 
                                <span wire:loading.remove wire:target="resetFormAction">
                                    <i class="bi bi-arrow-repeat"></i> Reset
                                </span>
                                <span wire:loading wire:target="resetFormAction">
                                    <span class="spinner-border spinner-border-sm me-1"></span>
                                    Mereset...
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary mt-4"  wire:click="simpan" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="simpan">
                                    <i class="bi bi-save2"></i> Simpan
                                </span>
                                <span wire:loading wire:target="simpan">
                                    <span class="spinner-border spinner-border-sm"></span>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>   
    </div>

    {{-- ======================================================================
         MODAL PETA LEAFLET UNTUK "Titik Lokus"
         Diletakkan di sini (masih di DALAM div root komponen, tapi di luar
         <form>) agar Livewire tetap punya SATU root element, dan modal ini
         tidak ikut ter-submit sebagai bagian dari form.
         ====================================================================== --}}
<div wire:ignore>
    <div class="modal-overlay" id="mapModalOverlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Pilih Titik Lokus di Peta</h3>
                <button type="button" class="modal-close" id="closeMapBtn">&times;</button>
            </div>

            <div class="modal-search">
                <input type="text" id="searchLocation" placeholder="Cari nama lokasi/alamat lalu tekan Enter (contoh: Merauke, Papua)">
            </div>
            <div class="marker-hint">Klik pada peta untuk menandai titik lokasi, atau geser marker untuk menyesuaikan.</div>

            <div id="mapPickerContainer"></div>

            <div class="modal-footer">
                <div class="coord-preview" id="coordPreview">Belum ada titik dipilih</div>
                <div class="footer-buttons">
                    <button type="button" class="btn-secondary" id="cancelMapBtn">Batal</button>
                    <button type="button" class="btn-primary" id="confirmMapBtn" disabled>Gunakan Titik Ini</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS & JS (kalau sudah ada di layout utama/master blade, hapus 2 baris ini agar tidak dobel) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    /* ---------- Styling field Titik Lokus ---------- */

    .tl-field-row {
        display: flex;
        gap: 10px;
        align-items: stretch;
    }
    .tl-input {
        flex: 1;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
        color: #111827;
        min-width: 0;
        line-height: 1.5;
    }
    .tl-input::placeholder { color: #9ca3af; }
    .tl-input:focus {
        outline: none;
        border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
    }
    .tl-input.is-invalid { border-color: #dc2626; }

.tl-btn-map {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 38px;
        padding: 0 1rem;
        font-size: 13px;
        line-height: normal;
        border: 1px solid #219EBC;
        background: #219EBC;
        color: #fff;
        border-radius: 0.375rem;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
    }
    .tl-btn-map:hover { background: #0aa242; }
    .tl-btn-map svg { width: 16px; height: 16px; flex-shrink: 0; }

    .tl-hint {
        font-size: 12.5px;
        color: #6b7280;
        margin-top: 8px;
        line-height: 1.5;
    }
    .tl-hint code {
        background: #f3f4f6;
        padding: 1px 6px;
        border-radius: 5px;
        font-size: 12px;
        color: #374151;
    }

    @media (max-width: 480px) {
        .tl-field-row { flex-direction: column; }
        .tl-btn-map { justify-content: center; }
    }

    /* ---------- Styling modal peta ---------- */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        padding: 20px;
    }
    .modal-overlay.open { display: flex; }

    .modal-box {
        background: #fff;
        border-radius: 8px;
        width: 100%;
        max-width: 1000px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }
    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
    }
    .modal-header h3 { margin: 0; font-size: 16px; }
    .modal-close {
        background: none;
        border: none;
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
        color: #6b7280;
    }
    .modal-close:hover { color: #111827; }
    .modal-search { padding: 12px 20px 0; }
    .modal-search input {
        width: 100%;
        padding: 9px 12px;
        font-size: 13px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
    }
    .marker-hint {
        font-size: 12px;
        color: #6b7280;
        padding: 8px 20px 0;
    }
    #mapPickerContainer {
    height: 420px;
    width: 100%;
    margin-top: 12px;
        }
        .leaflet-control-layers {
            border-radius: 8px !important;
            border: 1px solid #d1d5db !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15) !important;
            font-size: 13px;
        }
        .leaflet-control-layers-list label {
            margin-bottom: 4px;
            cursor: pointer;
        }
    .modal-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
    }
    .coord-preview { font-size: 13px; color: #374151; }
    .coord-preview b { color: #111827; }
    .footer-buttons { display: flex; gap: 8px; }
   .btn-secondary {
        padding: 9px 16px;
        background: #dc2626;
        color: #fff !important;
        border: 1px solid #dc2626;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        }
    .btn-secondary:hover { background: #b91c1c; border-color: #b91c1c; color: #fff !important; }
    .btn-primary {
        padding: 9px 18px;
        background: #16a34a;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-primary:disabled { background: #9ca3af; cursor: not-allowed; }
    .btn-primary:not(:disabled):hover { background: #15803d; }
</style>

<script>
    /* ---------- Format rupiah (SUDAH ADA SEBELUMNYA, tidak diubah) ---------- */
    function initFormatRupiah() {
        const rupiahInputs = document.querySelectorAll('.format-rupiah');

        rupiahInputs.forEach(function (input) {
            input.addEventListener('input', function (e) {
                let value = e.target.value;
                value = value.replace(/\D/g, '');
                value = new Intl.NumberFormat('id-ID').format(value);
                e.target.value = value;
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initFormatRupiah();
    });

    document.addEventListener('livewire:navigated', function () {
        initFormatRupiah();
    });

    document.addEventListener('livewire:load', function () {
        Livewire.hook('morph.updated', () => {
            initFormatRupiah();
        });
    });

    /* ---------- Peta Leaflet untuk Titik Lokus (BARU) ---------- */
    (function () {
        if (window.__titikLokasiPickerInit) return;
        window.__titikLokasiPickerInit = true;

        const DEFAULT_LAT = -2.5489; // pusat default peta, ganti sesuai kebutuhan
        const DEFAULT_LNG = 118.0149;
        const DEFAULT_ZOOM = 5;

        let map = null;
        let marker = null;
        let selectedLatLng = null;
        let mapInitialized = false;

        function formatCoord(lat, lng) {
            // Format identik hasil copy koordinat dari Google Maps
            return `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        }

        function setMarker(lat, lng) {
            selectedLatLng = { lat, lng };

            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                marker.on('dragend', function (e) {
                    const pos = e.target.getLatLng();
                    selectedLatLng = { lat: pos.lat, lng: pos.lng };
                    document.getElementById('coordPreview').innerHTML =
                        `Koordinat: <b>${formatCoord(pos.lat, pos.lng)}</b>`;
                    document.getElementById('confirmMapBtn').disabled = false;
                });
            }

            document.getElementById('coordPreview').innerHTML =
                `Koordinat: <b>${formatCoord(lat, lng)}</b>`;
            document.getElementById('confirmMapBtn').disabled = false;
        }

        function initMap() {
            if (mapInitialized) return;

            map = L.map('mapPickerContainer').setView([DEFAULT_LAT, DEFAULT_LNG], DEFAULT_ZOOM);

            // Layer 1: Peta jalan (OpenStreetMap)
            const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            });

            // Layer 2: Peta satelit (Esri World Imagery, gratis tanpa API key)
            const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics'
            });

            // Default tampilkan peta jalan
            streetLayer.addTo(map);

            // Kontrol switch peta jalan / satelit (pojok kanan atas)
            L.control.layers(
                { 'Peta Jalan': streetLayer, 'Satelit': satelliteLayer },
                null,
                { position: 'topright', collapsed: false }
            ).addTo(map);

            map.on('click', function (e) {
                setMarker(e.latlng.lat, e.latlng.lng);
            });

            mapInitialized = true;
        }

        function openModal() {
            document.getElementById('mapModalOverlay').classList.add('open');
            initMap();
            setTimeout(() => map.invalidateSize(), 50);

            const input = document.getElementById('titikLokasiInput');
            const existing = input ? input.value.trim() : '';
            if (existing) {
                const parts = existing.split(',').map(s => parseFloat(s.trim()));
                if (parts.length === 2 && !isNaN(parts[0]) && !isNaN(parts[1])) {
                    map.setView([parts[0], parts[1]], 14);
                    setMarker(parts[0], parts[1]);
                }
            }
        }

        function closeModal() {
            document.getElementById('mapModalOverlay').classList.remove('open');
        }

        async function searchLocation(query) {
            if (!query) return;
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`);
                const data = await res.json();
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);
                    map.setView([lat, lng], 14);
                    setMarker(lat, lng);
                } else {
                    alert('Lokasi tidak ditemukan, coba kata kunci lain.');
                }
            } catch (err) {
                console.error(err);
                alert('Gagal mencari lokasi. Periksa koneksi internet Anda.');
            }
        }

        function attachHandlers() {
            const openBtn = document.getElementById('openMapBtn');
            const closeBtn = document.getElementById('closeMapBtn');
            const cancelBtn = document.getElementById('cancelMapBtn');
            const confirmBtn = document.getElementById('confirmMapBtn');
            const overlay = document.getElementById('mapModalOverlay');
            const searchInput = document.getElementById('searchLocation');

            if (!openBtn || openBtn.__bound) return;
            openBtn.__bound = true;

            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) closeModal();
            });

            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchLocation(searchInput.value.trim());
                }
            });

            confirmBtn.addEventListener('click', function () {
                if (!selectedLatLng) return;

                const input = document.getElementById('titikLokasiInput');
                input.value = formatCoord(selectedLatLng.lat, selectedLatLng.lng);

                // WAJIB: trigger event 'input' manual supaya Livewire (wire:model biasa)
                // ikut menangkap perubahan value ini.
                input.dispatchEvent(new Event('input', { bubbles: true }));

                closeModal();
            });
        }

        document.addEventListener('DOMContentLoaded', attachHandlers);

        document.addEventListener('livewire:load', function () {
            Livewire.hook('morph.updated', attachHandlers);
        });

        document.addEventListener('livewire:navigated', attachHandlers);

        if (document.readyState !== 'loading') {
            attachHandlers();
        }
    })();
</script>
</div>