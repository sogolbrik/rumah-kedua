<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kamar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
        }

        .period {
            font-size: 12px;
            color: #555;
            margin-top: 4px;
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
                    <td class="text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>
                        @if ($item->status == 'Tersedia')
                            Tersedia
                        @elseif($item->status == 'Terisi')
                            Terisi
                        @else
                            Tidak Diketahui
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
