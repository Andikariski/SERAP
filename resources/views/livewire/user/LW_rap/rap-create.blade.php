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
                        <select wire:ignore id="selectSubKegiatan" class="form-control" data-url="{{ url('api/get-sub-kegiatan') }}">
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
                        <label class="form-label"><strong>Pagu Melanjutkan Kegiatan</strong></label> 
                        <input type="text" class="form-control format-rupiah"  wire:model="pagu_silpa_melanjutkan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Pagu Efisiensi Tahun Lalu</strong></label> 
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
                    <label class="mt-2" style="color: red;"><span >*</span> <i>Menandakan kolom wajib untuk id isi</i></label>
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
                    <div class="mb-3">
                        <label class="form-label"><strong>Titik Lokus</strong></span></label> 
                        <input type="text" class="form-control @error('titik_lokasi') is-invalid @enderror"  wire:model="titik_lokasi">
                         @error('titik_lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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
            <div class="row d-flex justify-content-end mt-3">
                <div class="col-auto"> 
                    <button type="button" class="btn btn-danger me-1" > 
                        <span wire:loading.remove wire:target="reset" wire:click="resetFormAction">
                            <i class="bi bi-arrow-repeat"></i> Reset
                        </span>
                        <span wire:loading wire:target="reset">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            Mereset...
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary"  wire:click="simpan" wire:loading.attr="disabled">
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
    </form>
    </div>   
     <div class="mt-4">
    </div>
</div>
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


