
<div>
     @php
    //  Setting Pagu BG
        $colorBG =
            $persentaseInputBG == 100  ? 'bg-success' :
            ($persentaseInputBG < 50  ? 'bg-danger' : 'bg-warning');
        $colorIconBG =
            $persentaseInputBG == 100  ? '#4caf50' :
            ($persentaseInputBG < 50  ? '#dc0000' : '#ff9100');

    // Setting Pagu SG
        $colorSG =
            $persentaseInputSG == 100  ? 'bg-success' :
            ($persentaseInputSG < 50  ? 'bg-danger' : 'bg-warning');
        $colorIconSG =
            $persentaseInputSG == 100  ? '#4caf50' :
            ($persentaseInputSG < 50  ? '#dc0000' : '#ff9100');

    // Setting Pagu SG
        $colorDTI =
            $persentaseInputDTI == 100  ? 'bg-success' :
            ($persentaseInputDTI < 50  ? 'bg-danger' : 'bg-warning');
        $colorIconDTI =
            $persentaseInputDTI == 100  ? '#4caf50' :
            ($persentaseInputDTI < 50  ? '#dc0000' : '#ff9100');
    @endphp
<div>
<div class="mt-2">
  <div class="row g-4">
    <!-- Card 1: Otsus BG -->
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card shadow-sm border-0 h-100" style="background: linear-gradient(135deg, #219EBC 0%,  #4f46e5 100%);">
        <div class="card-body d-flex align-items-center">
          <i class="bi bi-cash-coin text-light me-3" style="font-size: 60px;"></i>
          <div class="text-start">
            <h6 class="fw-semibold text-light">Dana Otsus BG</h6>
              @if(auth()->user()->is_admin == 1 || $getPaguOPD == null )
                <span class="badge bg-warning">Pagu belum ada</span>
              @else
                <h5 class="fw-bold text-light">
                  {{ number_format($getPaguOPD->pagu_BG,0, ',', '.') }}
                </h5>
              @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2: Otsus SG -->
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card shadow-sm border-0 h-100" style="background: linear-gradient(135deg, #219EBC 0%,  #4f46e5 100%);">
        <div class="card-body d-flex align-items-center">
          <i class="bi bi-cash-coin text-light me-3" style="font-size: 60px;"></i>
          <div class="text-start">
            <h6 class="fw-semibold text-light">Dana Otsus SG</h6>
              @if(auth()->user()->is_admin == 1 || $getPaguOPD == null )
                <span class="badge bg-warning">Pagu Belum ada</span>
              @else
                <h5 class="fw-bold text-light">
                  {{ number_format($getPaguOPD->pagu_SG,0, ',', '.') }}
                </h5>
              @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3: Dana DTI -->
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card shadow-sm border-0 h-100" style="background: linear-gradient(135deg, #219EBC 0%,  #4f46e5 100%);">
        <div class="card-body d-flex align-items-center">
          <i class="bi bi-cash-coin text-light me-3" style="font-size: 60px;"></i>
          <div class="text-start">
            <h6 class="fw-semibold text-light">Dana DTI</h6>
              @if(auth()->user()->is_admin == 1 || $getPaguOPD == null )
                <span class="badge bg-warning">Pagu Belum ada</span>
              @else
                <h5 class="fw-bold text-light">
                  {{ number_format($getPaguOPD->pagu_DTI,0, ',', '.') }}
                </h5>
              @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Card 4: Dana SiLPA -->
    <div class="col-12 col-md-6 col-lg-3">
     <div class="card shadow-sm border-0 h-100" style="background: linear-gradient(135deg, #219EBC 0%,  #4f46e5 100%);">
        <div class="card-body d-flex align-items-center">
         <i class="bi bi-calendar-check-fill text-light me-3" style="font-size: 60px;"></i>
          <div class="text-start">
            <h6 class="fw-semibold text-light">Dana SiLPA</h6>
            <h5 class="fw-bold text-light mb-0">-</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
 

  <div class="card p-4 border shadow-sm rounded-1 mt-4 mb-2">
   <h5 class="mb-3 fw-semibold text-primary">Rekapitulasi Grafik Input RAP Tahun Anggaran 
      {{ $tahunAktif ?? '-' }}
  </h5>
    <hr>
      <ul class="p-0 m-0">
        @if($getPaguOPD && $getPaguOPD->pagu_BG != 0)
        <li class="mb-2 d-flex align-items-center">
          <!-- Kolom Proyek: Mengunci lebar menjadi 40% agar semua baris lurus -->
            <div class="d-flex align-items-center me-3" style="width: 40%;">
                @if($persentaseInputBG == 100) 
                        <i class="bi bi-check2-circle me-3" style="font-size: 2.6rem; color:{{ $colorIconBG }}"></i>
                @else
                        <i class="bi bi-exclamation-diamond me-3" style="font-size: 2.6rem; color:{{ $colorIconBG }}"></i>
                @endif
                  <div>
                    <h5 class="mb-0 fw-semibold text-truncate" title="Dana Otsus Block Grand">Dana Otsus Block Grand</h5>
                      <small class="text-dark">
                        Pagu Terinput 
                        <strong style="color:#1a9c00">{{number_format($totalPaguTerinputBG, 0, ',', '.') }}</strong>,
                          Sisa Pagu BG 
                        <strong style="color:#ffa200">{{number_format($paguSisaBG, 0, ',', '.') }}</strong>
                        </small>
                    </div>
              </div>
                <!-- Kolom Progress Bar: Menggunakan flex-grow-1 agar mengambil sisa ruang 60% -->
              <div class="d-flex flex-grow-1 align-items-center">
                  <div class="progress w-100 me-4" style="height:15px;">
                      <div class="progress-bar {{ $colorBG }}" role="progressbar" style="width: {{ $persentaseInputBG }}%" aria-valuenow="{{ $persentaseInputBG }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                    <span class="fw-semibold" style="font-size: 0.9rem;"><h6>{{ $persentaseInputBG }}%</h6></span>
              </div>
        </li>
        @endif
        @if($getPaguOPD && $getPaguOPD->pagu_SG != 0)
        <li class="mb-2 d-flex align-items-center">
          <!-- Kolom Proyek: Mengunci lebar menjadi 40% agar semua baris lurus -->
            <div class="d-flex align-items-center me-3" style="width: 40%;">
                @if($persentaseInputSG == 100) 
                        <i class="bi bi-check2-circle me-3" style="font-size: 2.6rem; color:{{ $colorIconSG }}"></i>
                @else
                        <i class="bi bi-exclamation-diamond me-3" style="font-size: 2.6rem; color:{{ $colorIconSG }}"></i>
                @endif
                  <div>
                    <h5 class="mb-0 fw-semibold text-truncate" title="Dana Otsus Block Grand">Dana Otsus Spesifik Grand</h5>
                      <small class="text-dark">
                        Pagu Terinput 
                        <strong style="color:#1a9c00">{{number_format($totalPaguTerinputSG, 0, ',', '.') }}</strong>,
                          Sisa Pagu BG 
                        <strong style="color:#ffa200">{{number_format($paguSisaSG, 0, ',', '.') }}</strong>
                        </small>
                    </div>
              </div>
                <!-- Kolom Progress Bar: Menggunakan flex-grow-1 agar mengambil sisa ruang 60% -->
              <div class="d-flex flex-grow-1 align-items-center">
                  <div class="progress w-100 me-4" style="height:15px;">
                      <div class="progress-bar {{ $colorSG }}" role="progressbar" style="width: {{ $persentaseInputSG }}%" aria-valuenow="{{ $persentaseInputSG }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                    <span class="fw-semibold" style="font-size: 0.9rem;"><h6>{{ $persentaseInputSG }}%</h6></span>
              </div>
        </li>
        @endif
        @if($getPaguOPD && $getPaguOPD->pagu_DTI != 0)
        <li class="mb-2 d-flex align-items-center">
          <!-- Kolom Proyek: Mengunci lebar menjadi 40% agar semua baris lurus -->
            <div class="d-flex align-items-center me-3" style="width: 40%;">
                @if($persentaseInputDTI == 100) 
                        <i class="bi bi-check2-circle me-3" style="font-size: 2.6rem; color:{{ $colorIconDTI }}"></i>
                @else
                        <i class="bi bi-exclamation-diamond me-3" style="font-size: 2.6rem; color:{{ $colorIconDTI }}"></i>
                @endif
                  <div>
                    <h5 class="mb-0 fw-semibold text-truncate" title="Dana Otsus Block Grand">Dana Tambahan Infrastruktur</h5>
                      <small class="text-dark">
                        Pagu Terinput 
                        <strong style="color:#1a9c00">{{number_format($totalPaguTerinputDTI, 0, ',', '.') }}</strong>,
                          Sisa Pagu BG 
                        <strong style="color:#ffa200">{{number_format($paguSisaDTI, 0, ',', '.') }}</strong>
                        </small>
                    </div>
              </div>
                <!-- Kolom Progress Bar: Menggunakan flex-grow-1 agar mengambil sisa ruang 60% -->
              <div class="d-flex flex-grow-1 align-items-center">
                  <div class="progress w-100 me-4" style="height:15px;">
                      <div class="progress-bar {{ $colorDTI }}" role="progressbar" style="width: {{ $persentaseInputDTI }}%" aria-valuenow="{{ $persentaseInputDTI }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                    <span class="fw-semibold" style="font-size: 0.9rem;"><h6>{{ $persentaseInputDTI }}%</h6></span>
              </div>
        </li>
        @endif

 
      </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.8.0/countUp.umd.js"></script> --}}

<script>
  
    /**
     * @description Menginisialisasi chart menggunakan data yang diberikan.
     */
    function initializeChart() {
        const danaAnggaran = [100, 150, 180, 100, 90, 120]; // contoh data (Miliar)
        const danaDigunakan = [60, 90, 110, 85, 82, 90];   // contoh data (Miliar)
        // const penyerapanDana = [60, 90, 110, 85, 82, 90]; // contoh data (%)

        // Menghitung nilai maksimum untuk sumbu Y
        const maxDana = Math.ceil(Math.max(...danaAnggaran, ...danaDigunakan) / 10) * 10 + 10;

        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: true },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 1000
                }
            },
            series: [
                {
                    name: 'Dana Dianggarkan (Miliar)',
                    data: danaAnggaran
                },
                {
                    name: 'Dana Digunakan (Miliar)',
                    data: danaDigunakan
                },
                // name: 'Penyerapan (%)',
                // data: penyerapanDana

            ],
            colors: ['#219EBC', '#4CAF50'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '40%',
                    endingShape: 'rounded',
                    borderRadius: 4
                }
            },
            // Hilangkan hanya nilai (angka) di atas bar
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: [
                    'Penanggulangan Bencana',
                    'Beasiswa Pendidikan SMP',
                    'Pengadaan ATK',
                    'Perjalanan Dinas',
                    'Pembelian Bus Sekolah',
                    'Seleksi Sekolah Kedinasan'
                ]
            },
            yaxis: {
                title: {
                    text: 'Dana (Miliar)'
                },
                min: 0,
                max: maxDana,
                labels: {
                    formatter: val => val + ' M'
                }
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: val => val + ' M'
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center'
            },
            grid: {
                borderColor: '#eee',
                row: { colors: ['#f9f9f9', 'transparent'], opacity: 0.5 }
            }
        };

        // Pastikan elemen #chart ada sebelum mencoba merender
        const chartElement = document.querySelector("#chart");
        if (chartElement) {
            // **Penting:** Hapus chart lama sebelum membuat yang baru jika elemen chart sudah ada (untuk mengatasi duplikasi pada navigasi Livewire)
            // Namun, ApexCharts akan me-replace isinya jika dipanggil lagi pada elemen yang sama.
            // Jika Anda menggunakan Livewire, seringkali lebih aman untuk merender ulang.
            
            // Cek apakah instance chart sudah ada pada elemen tersebut
            // dan hancurkan (destroy) jika Livewire mengganti DOM
            // Namun, untuk kasus ini, kita buat instance baru saja.

            var chart = new ApexCharts(chartElement, options);
            chart.render();
            console.log("Chart has been initialized/re-initialized.");
        } else {
            console.error("Elemen dengan id #chart tidak ditemukan.");
        }
    }

          // Panggil fungsi inisialisasi saat halaman dimuat (untuk pemuatan awal)
    document.addEventListener("DOMContentLoaded", function () {
        initializeChart();
        // console.log("Hello DOMContentLoaded");
    });

    // Panggil fungsi inisialisasi saat Livewire selesai melakukan navigasi
    document.addEventListener("livewire:navigated", () => {
        initializeChart();
        // console.log("Hello livewire:navigated");
    });


</script>