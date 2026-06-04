<?php

namespace App\Livewire\Admin\LWpagu;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\PaguInduk as ModelPaguInduk;

class PaguGrafik extends Component
{
    public $categories = [];
    public $series = [];

    public $tahunAwal;
    public $tahunAkhir;

    public $listTahun = [];

    #[Layout('components.layouts.admin', ['pageTitle' => 'Grafik Pagu'])]
    public function render()
    {
        return view('livewire.admin.LW_pagu.pagu-grafik');
    }

    public function mount()
    {
        // kategori chart
        $this->categories = [
            'Otsus BG 1%',
            'Otsus SG 1,25%',
            'Otsus DTI',
            'SiLPA Non Efisiensi',
            'SiLPA Efisiensi'
        ];

        // ambil semua tahun unik
        $this->listTahun = ModelPaguInduk::orderBy('tahun_pagu')
            ->pluck('tahun_pagu')
            ->unique()
            ->values()
            ->toArray();

        // default filter
        $this->tahunAwal = min($this->listTahun);
        $this->tahunAkhir = max($this->listTahun);

        // generate chart pertama
        $this->generateChart();
    }

    public function generateChart()
    {
        $dataPagu = ModelPaguInduk::whereBetween('tahun_pagu', [
                $this->tahunAwal,
                $this->tahunAkhir
            ])
            ->orderBy('tahun_pagu')
            ->get();

        $series = [];

        foreach ($dataPagu as $item) {

            $series[] = [

                'name' => (string) $item->tahun_pagu,

                'data' => [

                    (int) $item->pagu_BG,
                    (int) $item->pagu_SG,
                    (int) $item->pagu_DTI,
                    (int) $item->pagu_SiLPA_Melanjutkan,
                    (int) $item->pagu_SiLPA_Efisiensi,

                ]

            ];
        }

        $this->series = $series;

        // kirim update ke apexchart
        $this->dispatch('updateChart', [
            'series' => $this->series,
            'categories' => $this->categories,
        ]);
    }

    public function updated($property)
    {
        // validasi range tahun
        if ($this->tahunAwal > $this->tahunAkhir) {

            $this->tahunAkhir = $this->tahunAwal;
        }

        $this->generateChart();
    }
}