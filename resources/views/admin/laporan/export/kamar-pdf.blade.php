<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kamar</title>
    <style>
        /* Font dasar - DOMPDF mendukung font sans-serif umum */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        /* Header laporan */
        .header {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid #2c3e50;
        }

        .header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .period {
            font-size: 12px;
            color: #555;
            margin-top: 6px;
            font-weight: 500;
        }

        /* Tabel modern */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
            text-align: left;
            padding: 10px 12px;
            font-size: 12px;
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: top;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* Status badge */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-terisi {
            background-color: #e74c3c;
            color: white;
        }

        .status-tersedia {
            background-color: #2ecc71;
            color: white;
        }

        .status-default {
            background-color: #95a5a6;
            color: white;
        }

        /* Harga — lebih menonjol */
        .harga {
            font-weight: 700;
            color: #2c3e50;
        }

        /* Footer halaman (opsional) */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }

        /* Garis pemisah */
        hr {
            border: 0;
            border-top: 1px solid #ecf0f1;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Kamar</h1>
        <div class="period">Tipe: {{ $tipe ?? 'Semua' }} | Status: {{ $status ?? 'Semua' }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode Kamar</th>
                <th>Tipe</th>
                <th>Lebar</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kamar as $item)
                <tr>
                    <td>{{ $item->kode_kamar ?? '—' }}</td>
                    <td>{{ $item->tipe ?? '—' }}</td>
                    <td>{{ $item->lebar ? $item->lebar . ' m' : '—' }}</td>
                    <td class="harga">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>
                        @if ($item->status == 'Tersedia')
                            <span class="status-badge status-tersedia">Tersedia</span>
                        @elseif($item->status == 'Terisi')
                            <span class="status-badge status-terisi">Terisi</span>
                        @else
                            <span class="status-badge status-default">Tidak Diketahui</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} | RumahKedua Admin Panel
    </div>
</body>

</html>
