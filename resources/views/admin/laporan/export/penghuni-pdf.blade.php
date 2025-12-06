<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penghuni</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid #27ae60;
        }

        .header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #27ae60;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .meta {
            font-size: 11px;
            color: #555;
            margin-top: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        th {
            background-color: #2ecc71;
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

        .text-center {
            text-align: center;
        }

        .status-aktif {
            background-color: #2ecc71;
            color: white;
        }

        .status-menunggak {
            background-color: #e74c3c;
            color: white;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Penghuni</h1>
        <div class="meta">Di-generate: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Penghuni</th>
                <th>Kode Kamar</th>
                <th>No. Telepon</th>
                <th>Email</th>
                <th>Tanggal Masuk</th>
                <th class="text-center">Hari Tunggakan</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penghuni as $item)
                @php
                    $last = $item->transaksi->first();
                    $hariTunggakan = null;
                    $isMenunggak = false;

                    if ($last && $last->tanggal_jatuhtempo) {
                        $jatuhTempo = \Carbon\Carbon::parse($last->tanggal_jatuhtempo);
                        if ($jatuhTempo->lt(\Carbon\Carbon::today())) {
                            $hariTunggakan = $jatuhTempo->diffInDays(\Carbon\Carbon::today());
                            $isMenunggak = true;
                        }
                    }
                @endphp

                <tr>
                    <td>{{ $item->name ?? '—' }}</td>
                    <td>{{ $item->kamar->kode_kamar ?? '—' }}</td>
                    <td>{{ $item->telepon ?? '—' }}</td>
                    <td>{{ $item->email ?? '—' }}</td>
                    <td>
                        @if ($item->tanggal_masuk)
                            {{ \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y') }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($isMenunggak)
                            {{ $hariTunggakan }} hari
                        @else
                            —
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($isMenunggak)
                            <span class="badge status-menunggak">Menunggak</span>
                        @else
                            <span class="badge status-aktif">Aktif</span>
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
