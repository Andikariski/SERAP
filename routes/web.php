<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\LWaktivitasUtama\AktivitasUtama;
use App\Livewire\Admin\LWkontrol\Kontrol;
use App\Livewire\Admin\LWsubKegiatan\SubKegiatan;
use App\Livewire\Admin\LWopd\Opd;
use App\Livewire\Admin\LWoperator\Operator;
use App\Livewire\Admin\LWpagu\PaguOPD;
use App\Livewire\Admin\LWpagu\PaguIndukDefinitif;
use App\Livewire\Admin\LWrap\RapSuperAdmin;
use App\Livewire\Admin\LWrap\RapSuperAdminDetailOPD;

use App\Livewire\Admin\SuperAdminAuth;

use App\Livewire\User\LWrap\CreateRap;
use App\Livewire\User\LWrap\UpdateRap;
use App\Livewire\User\LWrap\RapOpdBG;
use App\Livewire\User\LWrap\RapOpdDTI;
use App\Livewire\User\LWrap\RapOpdRiwayat;
use App\Livewire\User\LWrap\RapOpdSG;

use Illuminate\Support\Facades\Route;

use App\Exports\RapExport;
use App\Livewire\Admin\LWrap\RapSuperAdminPersentase;
use Maatwebsite\Excel\Facades\Excel;

use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect('login');
})->name('login');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

    // API get sub kegiatan dan aktivitas utama
    Route::get('api/get-sub-kegiatan', [CreateRap::class,'searchSubKegiatan'])->name('api.sub-kegiatan');
    Route::get('api/get-aktivitas-utama', [CreateRap::class,'searchAktivitasUtama'])->name('api.aktivitas-utama');

    Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');


    // Route Admin Submenu
    Route::get('/opd', Opd::class)->name('superadmin.opd');
    Route::get('/operator', Operator::class)->name('superadmin.operator');
    Route::get('/pagu', PaguOPD::class)->name('superadmin.pagu.opd');
    Route::get('/pagu-induk', PaguIndukDefinitif::class)->name('superadmin.pagu.induk');
    Route::get('/kontrol', Kontrol::class)->name('superadmin.kontrol');
    
    // Route RAP Admin
    Route::get('/rap-super-admin', RapSuperAdmin::class)->name('superadmin.rap.rapinduk');
    Route::get('/rap-persentase', RapSuperAdminPersentase::class)->name('superadmin.rap.persentase');
    Route::get('/rap-detail-opd/{id}', RapSuperAdminDetailOPD::class)->name('superadmin.rap.detailOPD');
    
    // Route Master Data
    Route::get('/sub-kegiatan', SubKegiatan::class)->name('superadmin.masterdata.subKegiatan');
    Route::get('/aktivitas-utama', AktivitasUtama::class)->name('superadmin.masterdata.aktivitasUtama');

    //Route untuk Akses Super Admin / Bukan
    Route::get('/not-acces', SuperAdminAuth::class)->name('not-acces');

    //Route USER
    Route::get('/rap-opd-bg', RapOpdBG::class)->name('opd.rap.rapBG');
    Route::get('/rap-opd-sg', RapOpdSG::class)->name('opd.rap.rapSG');
    Route::get('/rap-opd-dti', RapOpdDTI::class)->name('opd.rap.rapDTI');
    
    Route::get('/rap-opd-riwayat', RapOpdRiwayat::class)->name('opd.rap.rapRiwayat');
    Route::get('/rap-opd/create', CreateRap::class)->name('opd.rap.create');
    Route::get('/rap-opd/update/{id}', UpdateRap::class)->name('opd.rap.update');
    

    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
});

require __DIR__.'/auth.php';
