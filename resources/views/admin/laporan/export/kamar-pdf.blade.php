<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Kamar - RumahKedua</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #5f6c7b;
            background-color: #fffffe;
            line-height: 1.6;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 30px;
            border-bottom: 3px solid #3da9fc;
            padding-bottom: 20px;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 800;
            color: #094067;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .period {
            font-size: 13px;
            color: #5f6c7b;
            margin-top: 5px;
        }

        .period b {
            color: #3da9fc;
        }

        .report-info {
            text-align: right;
            font-size: 12px;
            color: #90b4ce;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead th {
            background-color: #094067;
            color: #fffffe;
            font-weight: 600;
            text-align: left;
            padding: 15px 12px;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        tbody tr:nth-child(even) {
            background-color: #f8fbfd;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #d8eefe;
            vertical-align: middle;
        }

        .kode-kamar {
            font-weight: 700;
            color: #3da9fc;
        }

        .harga {
            font-weight: 700;
            color: #094067;
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            text-align: center;
            min-width: 90px;
        }

        .status-tersedia {
            background-color: #3da9fc;
            color: #fffffe;
        }

        .status-terisi {
            background-color: #ef4565;
            color: #fffffe;
        }

        .status-default {
            background-color: #5f6c7b;
            color: #fffffe;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #90b4ce;
            text-align: center;
            font-size: 11px;
            color: #90b4ce;
        }

        .footer b {
            color: #094067;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-title">
                <h1>Laporan Kamar</h1>
                <div class="period">
                    Tipe: <b>{{ $tipe ?? 'Semua' }}</b> | Status: <b>{{ $status ?? 'Semua' }}</b>
                </div>
            </div>
            <div class="report-info">
                RumahKedua Asset Management<br>
                Generated: {{ now()->translatedFormat('d M Y') }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Kode Kamar</th>
                    <th>Tipe Kamar</th>
                    <th>Lebar</th>
                    <th>Harga Sewa</th>
                    <th style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kamar as $item)
                    <tr>
                        <td class="kode-kamar">{{ $item->kode_kamar ?? '—' }}</td>
                        <td style="font-weight: 500;">{{ $item->tipe ?? '—' }}</td>
                        <td>{{ $item->lebar ? $item->lebar . ' m' : '—' }}</td>
                        <td class="harga">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td style="text-align: center;">
                            @if ($item->status == 'Tersedia')
                                <span class="status-badge status-tersedia">Tersedia</span>
                            @elseif($item->status == 'Terisi')
                                <span class="status-badge status-terisi">Terisi</span>
                            @else
                                <span class="status-badge status-default">Unknown</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Dokumen ini dihasilkan secara otomatis oleh <b>RumahKedua Admin Panel</b> pada {{ now()->translatedFormat('d F Y, H:i') }}
        </div>
    </div>
</body>

</html>
