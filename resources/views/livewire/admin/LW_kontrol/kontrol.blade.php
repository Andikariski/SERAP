<div>
    @php
        $breadcrumbs = [
            ['name' => 'Kontrol Perubahan Akses dan Status', 'url' => route('superadmin.pagu.induk')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />

    <div class="row g-4 mb-4 mt-3">

        {{-- Card Kontrol Akses RAP --}}
        <div class="col-12 col-md-4 col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-shield-lock me-1"></i> Kontrol Akses RAP
                </div>
                <div class="card-body px-4 py-3">

                    <p class="text-uppercase text-muted mb-2" style="font-size: 12px; letter-spacing: 0.07em; font-weight: 500;">Status Akses</p>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            @if ($statusAkses === 'Buka')
                                <h5 class="mb-1" style="color: #0F6E56; font-weight: 500;">Terbuka</h5>
                                <p class="mb-0 text-muted" style="font-size: 13px;">Akses perubahan RAP aktif</p>
                            @else
                                <h5 class="mb-1" style="color: #A32D2D; font-weight: 500;">Terkunci</h5>
                                <p class="mb-0 text-muted" style="font-size: 13px;">Akses perubahan RAP diblokir</p>
                            @endif
                        </div>
                        <div class="rounded-2 d-flex align-items-center justify-content-center"
                            style="width:42px; height:42px;
                                background: {{ $statusAkses === 'Buka' ? '#E1F5EE' : '#FCEBEB' }};
                                color: {{ $statusAkses === 'Buka' ? '#0F6E56' : '#A32D2D' }};
                                font-size: 20px;">
                            <i class="bi {{ $statusAkses === 'Buka' ? 'bi-unlock-fill' : 'bi-lock-fill' }}"></i>
                        </div>
                    </div>

                    <hr class="my-0 mb-3">

                    <button
                        wire:click="toggleStatusAksesRAP"
                        wire:loading.attr="disabled"
                        class="btn d-inline-flex align-items-center gap-2"
                        style="font-size: 13px; font-weight: 500; padding: 7px 16px;
                            {{ $statusAkses === 'Buka'
                                ? 'background:#FCEBEB; color:#A32D2D; border: 0.5px solid #F09595;'
                                : 'background:#E1F5EE; color:#0F6E56; border: 0.5px solid #5DCAA5;' }}">
                        <span wire:loading.remove wire:target="toggleStatusAksesRAP">
                            <i class="bi {{ $statusAkses === 'Buka' ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                            {{ $statusAkses === 'Buka' ? 'Kunci Akses' : 'Buka Akses' }}
                        </span>
                        <span wire:loading wire:target="toggleStatusAksesRAP">
                            <span class="spinner-border spinner-border-sm"></span>
                            Memproses...
                        </span>
                    </button>

                </div>
            </div>
        </div>

        {{-- Card Kontrol Status RAP --}}
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-shield-lock me-1"></i> Kontrol Status RAP
                </div>
                <div class="card-body px-4 py-3">

                    {{-- Status aktif saat ini --}}
                    <p class="text-uppercase text-muted mb-2" style="font-size: 12px; letter-spacing: 0.07em; font-weight: 500;">Status aktif saat ini</p>
                    <h5 class="mb-3" style="color: #0F6E56; font-weight: 500;">{{ $statusRAP ?: '-' }}</h5>

                    <hr class="my-0 mb-0">

                    {{-- Tabel dari database --}}
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" style="table-layout: fixed;">
                            <thead>
                                <tr style="border-bottom: 0.5px solid #dee2e6;">
                                    <th class="text-muted py-2 px-3" style="font-size: 12px; font-weight: bold; letter-spacing: 0.07em; text-transform: uppercase;">Status RAP</th>
                                    <th class="text-muted py-2 px-3 text-end" style="font-size: 12px; font-weight: bold; letter-spacing: 0.07em; text-transform: uppercase; width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->rapOptions as $option)
                                    <tr wire:key="rap-{{ $option->id }}"
                                        style="{{ $statusRAP === $option->nama ? 'background:#E1F5EE;' : '' }} border-bottom: 0.5px solid #f0f0f0;">

                                        <td class="px-3 py-2" style="font-size: 13px; {{ $statusRAP === $option->nama ? 'color:#085041; font-weight:500;' : '' }}">
                                            {{ $option->nama }}
                                        </td>

                                        <td class="px-3 py-2">
                                            <div class="d-flex align-items-center justify-content-end gap-2">

                                                {{-- Spinner --}}
                                                <span wire:loading wire:target="toggleStatusRAP('{{ $option->nama }}')">
                                                    <span class="spinner-border spinner-border-sm text-secondary" style="width:14px; height:14px;"></span>
                                                </span>

                                                {{-- Toggle + Badge --}}
                                                <span wire:loading.remove wire:target="toggleStatusRAP('{{ $option->nama }}')">
                                                    <div
                                                        wire:click="toggleStatusRAP('{{ $option->nama }}')"
                                                        wire:loading.attr="disabled"
                                                        wire:target="toggleStatusRAP('{{ $option->nama }}')"
                                                        class="d-flex align-items-center gap-2"
                                                        style="cursor:{{ $statusRAP === $option->nama ? 'not-allowed' : 'pointer' }};">

                                                        {{-- Badge --}}
                                                        @if ($statusRAP === $option->nama)
                                                            <span style="font-size:11px; font-weight:500; padding:2px 8px; border-radius:20px; background:#E1F5EE; color:#085041;">Aktif</span>
                                                        @else
                                                            <span style="font-size:11px; padding:2px 8px; border-radius:20px; background:#f0f0f0; color:#888;">Nonaktif</span>
                                                        @endif

                                                        {{-- Toggle --}}
                                                        <div style="width:36px; height:20px; border-radius:20px; position:relative; transition:background 0.2s;
                                                            background:{{ $statusRAP === $option->nama ? '#1D9E75' : '#ccc' }};
                                                            opacity:{{ $statusRAP === $option->nama ? '0.85' : '1' }};">
                                                            <div style="position:absolute; top:2px; width:16px; height:16px; border-radius:50%; background:white; transition:left 0.2s;
                                                                left:{{ $statusRAP === $option->nama ? '18px' : '2px' }};"></div>
                                                        </div>
                                                    </div>
                                                </span>

                                                {{-- Divider --}}
                                                <span style="color:#dee2e6;">|</span>

                                                {{-- Tombol Hapus --}}
                                            @if ($statusRAP !== $option->nama)
                                                <button
                                                    wire:click="$dispatch('confirm-delete-status-rap', {{ $option}})"
                                                    style="background:none; border:none; color:#A32D2D; cursor:pointer; padding:2px 4px;"
                                                    title="Hapus">
                                                    <i class="bi bi-trash3" style="font-size:14px;"></i>
                                                </button>
                                            @else
                                                <span style="color:#ccc; padding:2px 4px;" title="Tidak bisa dihapus saat aktif">
                                                    <i class="bi bi-trash3" style="font-size:14px;"></i>
                                                </span>
                                            @endif

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-0">

                    {{-- Form Tambah Status --}}
                    <div class="px-1 py-3 d-flex align-items-start gap-2">
                        <div class="flex-grow-1">
                            <input
                                type="text"
                                wire:model="newStatusNama"
                                wire:keydown.enter="tambahStatus"
                                placeholder="Nama status baru, contoh: RAP Perubahan IV"
                                class="form-control form-control-sm @error('newStatusNama') is-invalid @enderror"
                                style="font-size: 16px;">
                            @error('newStatusNama')
                                <div class="invalid-feedback" style="font-size: 12px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <button
                            wire:click="tambahStatus"
                            wire:loading.attr="disabled"
                            wire:target="tambahStatus"
                            style="font-size:13px; font-weight:500; padding:6px 14px; background:#E1F5EE; color:#0F6E56; border:0.5px solid #5DCAA5; border-radius:8px; cursor:pointer; white-space:nowrap;">
                            <span wire:loading.remove wire:target="tambahStatus">
                                <i class="bi bi-plus-lg me-1"></i> Tambah
                            </span>
                            <span wire:loading wire:target="tambahStatus">
                                <span class="spinner-border spinner-border-sm"></span>
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>