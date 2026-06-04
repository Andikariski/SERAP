<div>
     @php
        $breadcrumbs = [
            ['name' => 'Grafik Pagu', 'url' => route('superadmin.pagu.grafik')],
            // ['name' => 'Artikel', 'url' => route('superadmin.opd')],
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbs" />
<div>

 
<div class="card border-0">
    <div class="card-body">
        {{-- <h5 class="fw-bold">
            Grafik Perbandingan Pagu Setiap Tahun
        </h5>
        <hr> --}}
        <div class="row">
            <label class="form-label fw-semibold" style="font-size: 20px">
                <i class="bi bi-funnel"></i>
                    Filter Tahun
            </label>
        </div>
          <div class="row mt-1">
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Tahun Awal
                </label>
                <select class="form-select"
                        wire:model.live="tahunAwal">

                    @foreach ($listTahun as $tahun)
                        <option value="{{ $tahun }}">
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Tahun Akhir
                </label>
                <select class="form-select"
                        wire:model.live="tahunAkhir">
                    @foreach ($listTahun as $tahun)
                        <option value="{{ $tahun }}">
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div wire:ignore class="mt-4">
            <div id="chartPerbandingan"></div>
        </div>
    </div>
</div>

@script
<script>

    let chartPerbandingan = null;

    function renderChart() {

        const chartElement = document.querySelector("#chartPerbandingan");

        // pastikan element ada
        if (!chartElement) return;

        // destroy chart lama
        if (chartPerbandingan) {
            chartPerbandingan.destroy();
        }
         // bersihkan DOM lama
        chartElement.innerHTML = '';

        let options = {

        chart: {
        type: 'bar',
        height: 450,

        toolbar: {
            show: true
        },

        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 600,

            animateGradually: {
                enabled: true,
                delay: 150
            },

            dynamicAnimation: {
                enabled: true,
                speed: 500
            }
        }
    },

        states: {
            hover: {
                filter: {
                    type: 'lighten',
                    value: 0.15
                }
            }
        },

            series: @json($series),

            xaxis: {
                categories: @json($categories)
            },

            plotOptions: {
                bar: {
                    horizontal: false,
                    borderRadius: 4,
                    columnWidth: '80%'
                }
            },

            dataLabels: {
                enabled: false
            },

            stroke: {
                show: true,
                width: 5,
                colors: ['transparent']
            },

            yaxis: {
                labels: {
                    formatter: function(value) {
                        return new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            },

            tooltip: {
                y: {
                    formatter: function(value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            }

        };

        chartPerbandingan = new ApexCharts(
            chartElement,
            options
        );

        chartPerbandingan.render();


        
    }

    // render saat navigasi livewire
    document.addEventListener('livewire:navigated', () => {

    setTimeout(() => {
        renderChart();
    }, 200);

    });

    // update realtime dari livewire
    Livewire.on('updateChart', (event) => {

        if (!chartPerbandingan) return;

        chartPerbandingan.updateOptions({
            xaxis: {
                categories: event[0].categories
            }
        });

        chartPerbandingan.updateSeries(event[0].series);

    });

</script>
@endscript