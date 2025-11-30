<?php

namespace App\Exports;

use App\Models\Rap;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RapExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
  
        protected $data;

        public function __construct($data)
        {
            $this->data = $data;
        }

        public function collection()
        {
            return $this->data;
        }
   

    public function headings(): array
    {
        return [
            'KEWENANGAN',
            'KODE KLASIFIKASI',
            'SUB KEGIATAN',
            'KINERJA',
            'INDIKATOR',
            'KLASIFIKASI BELANJA',
            'AKTIVITAS UTAMA',
            'JENIS KEGIATAN',
            'TEMA PEMBANGUNAN',
            'PROGRAM PRIORITAS',
            'TARGET KELUARAN STRATEGIS',
            'VOLUME TAHUN BERJALAN',
            'VOLUME SILPA MELANJUTKAN',
            'VOLUME SILPA EFISIENSI',
            'VOLUME TOTAL',
            'SATUAN VOLUME',
            'PAGU TAHUN BERJALAN',
            'PAGU SILPA MENALJUTKAN',
            'PAGU SILPA EFISIENSI',
            'PAGU TOTAL',
            'SUMBER DANA',
            'LOKUS',
            'TITIK LOKUS',
            'SASARAN',
            'PPSB',
            'PENERIMA MANFAAT',
            'SINERGI DANA LAIN',
            'MULTIYEARS',
            'JADWAL AWAL',
            'JADWAL AKHIR',
            'VALIDASI',
            'DATA RKA',
            'DATA KAK',
            'DATA LAINYA',
            'OPD',
            'KETERANGAN',
        ];
    }

     public function styles(Worksheet $sheet)
    {
        // warna heading
        $sheet->getStyle('A1:AJ1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F74D4']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true
            ],
        ]);

         // tinggi row heading
        $sheet->getRowDimension(1)->setRowHeight(40);

        $sheet->getColumnDimension('A')->setAutoSize(false);
        $sheet->getColumnDimension('B')->setAutoSize(false);
        $sheet->getColumnDimension('C')->setAutoSize(false);
        $sheet->getColumnDimension('D')->setAutoSize(false);
        $sheet->getColumnDimension('E')->setAutoSize(false);
        $sheet->getColumnDimension('L')->setAutoSize(false);
        $sheet->getColumnDimension('M')->setAutoSize(false);
        $sheet->getColumnDimension('N')->setAutoSize(false);
        $sheet->getColumnDimension('O')->setAutoSize(false);
        $sheet->getColumnDimension('AF')->setAutoSize(false);
        $sheet->getColumnDimension('AG')->setAutoSize(false);
        $sheet->getColumnDimension('AH')->setAutoSize(false);

        // contoh: kolom spesifik set lebar manual
        $sheet->getColumnDimension('A')->setWidth(15); // KEWENANGAN
        $sheet->getColumnDimension('B')->setWidth(20); // KODE KLASIFIKASI
        $sheet->getColumnDimension('C')->setWidth(35); // SUB KEGIATAN
        $sheet->getColumnDimension('D')->setWidth(35); // SUB KEGIATAN
        $sheet->getColumnDimension('E')->setWidth(35); // SUB KEGIATAN
        $sheet->getColumnDimension('L')->setWidth(10); // SUB KEGIATAN
        $sheet->getColumnDimension('M')->setWidth(10); // SUB KEGIATAN
        $sheet->getColumnDimension('N')->setWidth(10); // SUB KEGIATAN
        $sheet->getColumnDimension('O')->setWidth(10); // SUB KEGIATAN
        $sheet->getColumnDimension('AF')->setWidth(25); // SUB KEGIATAN
        $sheet->getColumnDimension('AG')->setWidth(25); // SUB KEGIATAN
        $sheet->getColumnDimension('AH')->setWidth(25); // SUB KEGIATAN

        return [];
    }
}
