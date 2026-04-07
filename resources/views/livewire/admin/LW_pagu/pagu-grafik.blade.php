<div>
     @php
        $breadcrumbs = [
            ['name' => 'Grafik Perbandingan Pagu', 'url' => route('superadmin.opd')],
            // ['name' => 'Artikel', 'url' => route('admin.posts.index')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
<div>
<div class="card text-white shadow-sm border-0" style="background: linear-gradient(135deg, #219EBC 0%,  #4f46e5 100%);">
   
 
    <div class="mt-4">
        {{-- {{ $paguOpds->links('vendor.livewire.bootstrap-pagination') }} --}}
    </div>
</div>

        