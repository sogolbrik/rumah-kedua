<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penghuni</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2 style="margin:0 0 6px 0;">Laporan Penghuni</h2>
    <div style="font-size:11px; color:#555; margin-bottom:8px;">
        Di-generate: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Penghuni</th>
                <th>Kode Kamar</th>
                <th>No. Telepon</th>
                <th>Email</th>
                <th>Tanggal Masuk</th>
                <th>Hari Tunggakan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penghuni as $item)
                @php
                    $last = $item->transaksi->first(); // transaksi terakhir (jika ada)
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
                            Menunggak
                        @else
                            Aktif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
