<div>
     @php
        $breadcrumbs = [
            ['name' => 'Kontrol Perubahan Akses dan Status', 'url' => route('superadmin.pagu.induk')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
<div>
 <div class="row g-4 mb-4 mt-3">
    <!-- Card 1: Otsus SG -->

    <div class="col-12 col-md-4 col-lg-5">
        <div class="card shadow-sm border-0 h-100">   
            <!-- 🟦 Card Header -->
            <div class="card-header bg-primary text-white fw-semibold">
                <i class="bi bi-shield-lock me-1"></i> Kontrol Akses RAP
            </div>
            <!-- 🟩 Card Body -->
            <div class="card-body">
                {{-- Notifikasi Status --}}
               <div class="d-flex align-items-center">
                    @if ($statusAkses === 'Buka')
                        <i class="bi bi-unlock-fill me-3" style="font-size: 70px; color:#008829;"></i>
                        <div>
                            <h3 class="" style="color: #008b33"><strong>Terbuka</strong></h3>
                            <h6 class="">Akses Perubahan RAP Sedang Terbuka</h6>
                        </div>
                    @elseif ($statusAkses === 'Tutup')
                        <i class="bi bi-lock-fill me-3" style="font-size: 70px; color:#ff5500;"></i>
                        <div>
                            <h3 class="" style="color: #ff5500"><strong>Terkunci</strong></h3>
                            <h6 class="" >Akses Perubahan RAP Sedang Terkunci</h6>
                        </div>
                    @endif
                </div>
                <hr>
                {{-- Tombol Aksi --}}
                <div class="d-flex flex-wrap gap-2">
                    @if ($statusAkses === 'Buka')
                        <button wire:click="toggleStatusAksesRAP" wire:loading.attr="disabled"
                            class="btn btn-warning d-flex align-items-center">
                            <i class="bi bi-lock-fill me-2" style="color:#ffffff"></i>
                            <span wire:loading.remove wire:target="toggleStatusAksesRAP" style="color:#ffffff">Kunci Akses</span>
                            <span wire:loading wire:target="toggleStatusAksesRAP" style="color:#ffffff">Memproses...</span>
                        </button>
                    @else
                        <button wire:click="toggleStatusAksesRAP" wire:loading.attr="disabled"
                            class="btn btn-success d-flex align-items-center">
                            <i class="bi bi-unlock-fill me-2"></i>
                            <span wire:loading.remove wire:target="toggleStatusAksesRAP" style="color:#ffffff">Buka Akses</span>
                            <span wire:loading wire:target="toggleStatusAksesRAP" style="color:#ffffff">Memproses...</span>
                        </button>
                    @endif
                </div>
            </div>    
        </div>
  </div>

<div class="col-12 col-md-8 col-lg-7">
    <div class="card shadow-sm border-0 h-100">   
        <!-- 🟦 Card Header -->
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-shield-lock me-1"></i> Kontrol Status RAP
        </div>

        <!-- 🟩 Card Body -->
        <div class="card-body">
            {{-- 🔹 Info Status Saat Ini --}}
            <div class="d-flex align-items-center">
                <i class="bi bi-file-earmark-text me-3" style="font-size: 70px; color:#008080;"></i>
                <div>
                    <h3 style="color: #008080">
                        <strong>{{ $statusRAP }}</strong>
                    </h3>
                    <h6>
                        Status RAP Aktif sekarang adalah 
                        <strong style="color: #ff5500">{{ $statusRAP }}</strong>
                    </h6>
                </div>
            </div>
            <hr>
            {{-- 🔹 Tombol Pilihan Status --}}
            <div class="d-flex flex-wrap gap-2">
                @foreach (['RAP Awal','RAP Penyesuaian', 'RAP Perubahan II', 'RAP Perubahan III'] as $status)
                    <button 
                        wire:click="toggleStatusRAP('{{ $status }}')" 
                        wire:loading.attr="disabled"
                        class="btn d-flex align-items-center 
                            {{ $statusRAP === $status 
                                ? 'btn-success text-white' 
                                : 'btn-outline-warning' }}">
                        {{-- Spinner Loading --}}
                        <span wire:loading wire:target="toggleStatusRAP('{{ $status }}')" class="spinner-border spinner-border-sm me-2"></span>
                        {{-- <span>{{ $status }}</span> --}}
                        <span wire:loading.remove wire:target="toggleStatusRAP">{{ $status }}</span>
                        <span wire:loading wire:target="toggleStatusRAP">Mengaktifkan...</span>
                    </button>
                @endforeach
            </div>
        </div>    
    </div>
</div>
</div>
</div>
</div>


