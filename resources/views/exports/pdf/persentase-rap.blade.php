<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Persentase RAP {{ $tahunAktif }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
            body { 
                font-family: Arial, sans-serif; 
                font-size: 11px; 
                color: #000;
                padding: 30px 40px;  /* ✅ Ganti margin jadi padding */
            }

        .header { text-align: center; margin-bottom: 15px; }
        .header h2 { font-size: 14px; font-weight: bold; }
        .header p  { font-size: 11px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead tr { background-color: #2d6a9f; color: #fff; }
        th, td { border: 1px solid #ccc; padding: 5px 8px; text-align: center; }
        td.nama { text-align: left; }

        tbody tr:nth-child(even) { background-color: #f2f2f2; }

        .bar-wrap { background: #ddd; border-radius: 4px; height: 10px; width: 100%; }
        .bar-fill  { height: 10px; border-radius: 4px; }
        .bg-danger  { background-color: #dc3545; }
        .bg-warning { background-color: #ffc107; }
        .bg-success { background-color: #28a745; }

        .persen-label { font-size: 10px; margin-top: 2px; }

        .footer { margin-top: 20px; font-size: 10px; text-align: right; color: #555; }
    </style>
</head>
<body>

    <div class="header">
        <h2>REKAPITULASI PERSENTASE INPUT RAP</h2>
        <p>Tahun Anggaran {{ $tahunAktif }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:4%">NO</th>
                <th style="width:30%">NAMA OPD</th>
                <th style="width:18%">PAGU BG</th>
                <th style="width:18%">PAGU SG</th>
                <th style="width:18%">PAGU DTI</th>
                <th style="width:12%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="nama">{{ Str::limit(strip_tags($d->opd->kode_opd), 40) }}</td>

                {{-- PAGU BG --}}
                <td>
                    @if($d->persen_BG !== '-')
                        @php
                            $colorBG = $d->persen_BG == 100 ? 'bg-success' : ($d->persen_BG < 50 ? 'bg-danger' : 'bg-warning');
                        @endphp
                        <div class="bar-wrap">
                            <div class="bar-fill {{ $colorBG }}" style="width: {{ $d->persen_BG }}%;"></div>
                        </div>
                        <div class="persen-label">{{ $d->persen_BG }}%</div>
                    @else
                        <strong style="color:red">--</strong>
                    @endif
                </td>

                {{-- PAGU SG --}}
                <td>
                    @if($d->persen_SG !== '-')
                        @php
                            $colorSG = $d->persen_SG == 100 ? 'bg-success' : ($d->persen_SG < 50 ? 'bg-danger' : 'bg-warning');
                        @endphp
                        <div class="bar-wrap">
                            <div class="bar-fill {{ $colorSG }}" style="width: {{ $d->persen_SG }}%;"></div>
                        </div>
                        <div class="persen-label">{{ $d->persen_SG }}%</div>
                    @else
                        <strong style="color:red">--</strong>
                    @endif
                </td>

                {{-- PAGU DTI --}}
                <td>
                    @if($d->persen_DTI !== '-')
                        @php
                            $colorDTI = $d->persen_DTI == 100 ? 'bg-success' : ($d->persen_DTI < 50 ? 'bg-danger' : 'bg-warning');
                        @endphp
                        <div class="bar-wrap">
                            <div class="bar-fill {{ $colorDTI }}" style="width: {{ $d->persen_DTI }}%;"></div>
                        </div>
                        <div class="persen-label">{{ $d->persen_DTI }}%</div>
                    @else
                        <strong style="color:red">--</strong>
                    @endif
                </td>

                {{-- TOTAL --}}
                <td>
                    <strong>{{ $d->persen_total }}%</strong>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding: 20px;">Data tidak ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
    </div>

</body>
</html>