@include('partials.admin.layout.head')
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
{{-- @livewireScripts --}}


<body x-cloak x-data="{ sidebarCollapsed: $persist(false), showSidebar: false }" style="background-color:#f2f3f7">
        <!-- Sidebar -->
        @include('partials.admin.layout.sidebar')

        <!-- Main Content Area -->
       <div class="main-content" :class="{ 'expanded': sidebarCollapsed }">
            <!-- Header -->
            @include('partials.admin.layout.header')

            <!-- Main -->
            <main class="px-4 py-3 bg-white rounded-1 border m-2">
                {{ $slot }}
            </main>
        </div>
    {{-- Scripts --}}
     
    <!-- Jquery <head> -->
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    <!-- JS sebelum </body> -->
    <script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {{-- <script src="{{ asset('assets/js/admin.js') }}"></script> --}}
    @stack('scripts') {{-- Tambahkan stack untuk JS khusus --}}
    @livewireScripts
</body>
</html>
