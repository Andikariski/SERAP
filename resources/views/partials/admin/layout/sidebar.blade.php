<div class="sidebar bg-white border border-end-light" :class="{ 'collapsed': sidebarCollapsed, 'show': showSidebar }">
    <div class=" d-flex flex-column align-items-center w-100 rounded-lg h-100 px-2 ">
        <div class="brand-wrapper px-2" style="">
            <div class="d-flex">
                <a href="{{ route('dashboard') }}">
                    <div class="oveflow-hidden d-flex align-items-center justify-content-center"
                        style="height: 60px; width: auto" :class="{ 'me-2': !sidebarCollapsed }">
                        <div class="d-flex align-items-center justify-content-center my-3">
                            <img src="{{ asset('assets/img/LogoOtsus.png') }}" alt="Logo SIMDOTIPPS" class="img-fluid logo-simdoti" style="max-width: 70px;">
                        </div>
                    </div>
                </a>
                    <div class="d-flex align-items-center justify-content-center my-1 mb-3">
                        <img src="{{ asset('assets/img/Serap.png') }}" alt="Logo SIMDOTIPPS" class="img-fluid logo-simdoti" style="max-width: 130px;"  x-show="!sidebarCollapsed">
                    </div>
            </div>
            <button class="btn btn-outline-dark" x-show="showSidebar" type="button" @click="showSidebar = false">
                <i class="bi bi-x fw-2"></i>
            </button>
        </div>

        <ul class="sidebar-nav">
            <li class="nav-item">
                <a wire:navigate href="{{ route('dashboard') }}"
                    class="sidebar-nav-link rounded-1 d-flex align-items-center gap-1 {{ request()->routeIs('dashboard') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <i
                        class="bi bi-speedometer2 {{ request()->routeIs('dashboard') ? 'text-light' : 'text-dark' }}"></i>
                    <span class="fs-6" x-show="!sidebarCollapsed">Dashboard</span>
                </a>
            </li>

            @if (Auth()->user()->is_admin == 0)
                {{-- <li class="nav-item">
                <a wire:navigate href="{{ route('rap.rapBG') }}"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center gap-1 {{ request()->routeIs('rap.*') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <i
                        class="bi bi-wallet {{ request()->routeIs('rap.*') ? 'text-light' : 'text-dark' }}"></i>
                    <span x-show="!sidebarCollapsed">RAP Opd</span>
                </a> --}}
            {{-- </li> --}}

             <li class="nav-item" x-data="{ open: {{ (
                request()->get('type') === 'rap-opd-bg' || 
                request()->get('type') === 'rap-opd-sg' || 
                request()->get('type') === 'rap-opd-dti' ||
                request()->get('type') === 'rap-opd-riwayat'||
                request()->get('type') === 'rap-opd-update-bg'||
                request()->get('type') === 'rap-opd-update-sg'||
                request()->get('type') === 'rap-opd-update-dti'
                ) ? 'true' : 'false' }} }">
                <!-- Parent link (dropdown trigger) -->
                <a href="#" @click.prevent="open = !open"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center justify-content-between gap-1 {{ request()->routeIs('opd.rap.*') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <div class="d-flex align-items-center gap-1">
                        <i
                            class="bi bi-cash-stack {{ request()->routeIs('opd.rap.*') ? 'text-light' : 'text-dark' }}"></i>
                        <span x-show="!sidebarCollapsed">Data RAP</span>
                    </div>
                    <i class="bi" :class="open ? 'bi-chevron-up' : 'bi-chevron-down'"
                        x-show="!sidebarCollapsed"></i>
                </a>

                <!-- Dropdown menu -->
                <ul class="list-unstyled ps-4 mt-1" x-show="open && !sidebarCollapsed" x-transition
                    style="display: none;">
                    <li>
                        <a wire:navigate href="{{ route('opd.rap.rapBG', ['type' => 'rap-opd-bg']) }}"
                            class="d-block py-1 text-decoration-none {{ request()->get('type') === 'rap-opd-bg' || request()->get('type') === 'rap-opd-update-bg' ? 'fw-bold text-primary' : 'text-dark' }}">
                            RAP Block Grand
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('opd.rap.rapSG', ['type' => 'rap-opd-sg']) }}"
                            class="d-block py-1 text-decoration-none {{ request()->get('type') === 'rap-opd-sg' || request()->get('type') === 'rap-opd-update-sg' ? 'fw-bold text-primary' : 'text-dark' }}">
                            RAP Spesifik Grand
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('opd.rap.rapDTI', ['type' => 'rap-opd-dti']) }}"
                            class="d-block py-1 text-decoration-none {{ request()->get('type') === 'rap-opd-dti' || request()->get('type') === 'rap-opd-update-dti' ? 'fw-bold text-primary' : 'text-dark' }}">
                            RAP DTI
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('opd.rap.rapRiwayat', ['type' => 'rap-opd-riwayat']) }}"
                            class="d-block py-1 text-decoration-none {{ request()->get('type') === 'rap-opd-riwayat' ? 'fw-bold text-primary' : 'text-dark' }}">
                            Riwayat RAP
                        </a>
                    </li>
                </ul>
            </li>
            @endif
          
            @if (Auth()->user()->is_admin == 1)
            {{-- <li class="nav-item">
                <a wire:navigate href="{{ route('subKegiatan') }}"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center gap-1 {{ request()->routeIs('subKegiatan') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <i
                        class="bi bi-journal-text {{ request()->routeIs('subKegiatan') ? 'text-light' : 'text-dark' }}"></i>
                    <span x-show="!sidebarCollapsed">Sub Kegiatan</span>
                </a>
            </li>
            <li class="nav-item">
                <a wire:navigate href="{{ route('aktivitasUtama') }}"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center gap-1 {{ request()->routeIs('aktivitasUtama') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <i
                        class="bi bi-journal-text {{ request()->routeIs('aktivitasUtama') ? 'text-light' : 'text-dark' }}"></i>
                    <span x-show="!sidebarCollapsed">Aktivitas Utama</span>
                </a>
            </li> --}}
            <li class="sidebar-nav-item">
                <a wire:navigate href="{{ route('superadmin.operator') }}"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center gap-1 {{ request()->routeIs('superadmin.operator') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <i
                        class="bi bi-pc-display-horizontal {{ request()->routeIs('superadmin.operator') ? 'text-light' : 'text-dark' }}"></i>
                    <span x-show="!sidebarCollapsed">Operator</span>
                </a>
            </li>
            <li class="nav-item">
                <a wire:navigate href="{{ route('superadmin.opd') }}"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center gap-1 {{ request()->routeIs('superadmin.opd') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <i
                        class="bi bi-diagram-2 {{ request()->routeIs('superadmin.opd') ? 'text-light' : 'text-dark' }}"></i>
                    <span x-show="!sidebarCollapsed">Data OPD</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a wire:navigate href="{{ route('superadmin.rap') }}"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center gap-1 {{ request()->routeIs('superadmin.rap') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <i
                        class="bi bi-wallet {{ request()->routeIs('superadmin.rap') ? 'text-light' : 'text-dark' }}"></i>
                    <span x-show="!sidebarCollapsed">RAP Induk</span>
                </a>
            </li>
            <li class="nav-item">
                <a wire:navigate href="{{ route('superadmin.persentase.rap') }}"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center gap-1 {{ request()->routeIs('superadmin.persentase.rap') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <i
                        class="bi bi-wallet {{ request()->routeIs('superadmin.persentase.rap') ? 'text-light' : 'text-dark' }}"></i>
                    <span x-show="!sidebarCollapsed">RAP Persentase</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a wire:navigate href="{{ route('superadmin.kontrol') }}"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center gap-1 {{ request()->routeIs('superadmin.kontrol') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <i
                        class="bi bi-gear {{ request()->routeIs('superadmin.kontrol') ? 'text-light' : 'text-dark' }}"></i>
                    <span x-show="!sidebarCollapsed">Menu Kontrol</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a wire:navigate href="{{ route('opd') }}"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center gap-1 {{ request()->routeIs('opd') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <i
                        class="bi bi-cash-coin {{ request()->routeIs('opd') ? 'text-light' : 'text-dark' }}"></i>
                    <span x-show="!sidebarCollapsed">Data Pagu</span>
                </a>
            </li> --}}
            
    
            <li class="nav-item" x-data="{ open: {{ (request()->get('type') === 'pagu-opd' || request()->get('type') === 'pagu-induk') ? 'true' : 'false' }} }">
                <!-- Parent link (dropdown trigger) -->
                <a href="#" @click.prevent="open = !open"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center justify-content-between gap-1 {{ request()->routeIs('superadmin.pagu.*') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <div class="d-flex align-items-center gap-1">
                        <i
                            class="bi bi-cash-stack {{ request()->routeIs('superadmin.pagu.*') ? 'text-light' : 'text-dark' }}"></i>
                        <span x-show="!sidebarCollapsed">Data Pagu</span>
                    </div>
                    <i class="bi" :class="open ? 'bi-chevron-up' : 'bi-chevron-down'"
                        x-show="!sidebarCollapsed"></i>
                </a>

                <!-- Dropdown menu -->
                <ul class="list-unstyled ps-4" x-show="open && !sidebarCollapsed" x-transition
                    style="display: none;">
                    <li>
                        <a wire:navigate href="{{ route('superadmin.pagu.opd', ['type' => 'pagu-opd']) }}"
                            class="d-block py-1 text-decoration-none {{ request()->get('type') === 'pagu-opd' ? 'fw-bold text-primary' : 'text-dark' }}">
                            Pagu OPD
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('superadmin.pagu.induk', ['type' => 'pagu-induk']) }}"
                            class="d-block py-1 text-decoration-none {{ request()->get('type') === 'pagu-induk' ? 'fw-bold text-primary' : 'text-dark' }}">
                            Pagu Induk Definitif
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item" x-data="{ open: {{ (request()->get('type') === 'sub-kegiatan' || request()->get('type') === 'aktivitas-utama') ? 'true' : 'false' }} }">
                <!-- Parent link (dropdown trigger) -->
                <a href="#" @click.prevent="open = !open"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center justify-content-between gap-1 {{ request()->routeIs('superadmin.masterdata.*') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <div class="d-flex align-items-center gap-1">
                        <i
                            class="bi bi-database-gear {{ request()->routeIs('superadmin.masterdata.*') ? 'text-light' : 'text-dark' }}"></i>
                        <span x-show="!sidebarCollapsed">Master Data</span>
                    </div>
                    <i class="bi" :class="open ? 'bi-chevron-up' : 'bi-chevron-down'"
                        x-show="!sidebarCollapsed"></i>
                </a>

                <!-- Dropdown menu -->
                <ul class="list-unstyled ps-4" x-show="open && !sidebarCollapsed" x-transition
                    style="display: none;">
                    <li>
                        <a wire:navigate href="{{ route('superadmin.masterdata.subKegiatan', ['type' => 'sub-kegiatan']) }}"
                            class="d-block py-1 text-decoration-none {{ request()->get('type') === 'sub-kegiatan' ? 'fw-bold text-primary' : 'text-dark' }}">
                            Sub Kegiatan
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('superadmin.masterdata.aktivitasUtama', ['type' => 'aktivitas-utama']) }}"
                            class="d-block py-1 text-decoration-none {{ request()->get('type') === 'aktivitas-utama' ? 'fw-bold text-primary' : 'text-dark' }}">
                            Aktivitas Utama
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item" x-data="{ open: {{ (request()->get('type') === 'rap-induk' || request()->get('type') === 'rap-persentase') ? 'true' : 'false' }} }">
                <!-- Parent link (dropdown trigger) -->
                <a href="#" @click.prevent="open = !open"
                    class="sidebar-nav-link text-dark rounded-1 d-flex align-items-center justify-content-between gap-1 {{ request()->routeIs('superadmin.rap.*') ? 'bg-primary text-light' : 'bg-white text-dark' }}"
                    :class="{ 'justify-content-center': sidebarCollapsed }">
                    <div class="d-flex align-items-center gap-1">
                        <i
                            class="bi bi-folder-symlink {{ request()->routeIs('superadmin.rap.*') ? 'text-light' : 'text-dark' }}"></i>
                        <span x-show="!sidebarCollapsed">Rekap RAP</span>
                    </div>
                    <i class="bi" :class="open ? 'bi-chevron-up' : 'bi-chevron-down'"
                        x-show="!sidebarCollapsed"></i>
                </a>

                <!-- Dropdown menu -->
                <ul class="list-unstyled ps-4" x-show="open && !sidebarCollapsed" x-transition
                    style="display: none;">
                    <li>
                        <a wire:navigate href="{{ route('superadmin.rap.rapinduk', ['type' => 'rap-induk']) }}"
                            class="d-block py-1 text-decoration-none {{ request()->get('type') === 'rap-induk' ? 'fw-bold text-primary' : 'text-dark' }}">
                            RAP Induk
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('superadmin.rap.persentase', ['type' => 'rap-persentase']) }}"
                            class="d-block py-1 text-decoration-none {{ request()->get('type') === 'rap-persentase' ? 'fw-bold text-primary' : 'text-dark' }}">
                            Persentase RAP
                        </a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </div>
</div>
