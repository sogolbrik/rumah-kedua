<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 40px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2d3748;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #cbd5e0;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #edf2f7;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }
    </style>
</head>

<body>
    <h1>Laporan Pembayaran</h1>
    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Penghuni</th>
                <th>Kamar</th>
                <th>Tgl Jatuh Tempo</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $t)
                <tr>
                    <td>{{ $t->kode }}</td>
                    <td>{{ $t->user?->name ?? '–' }}</td>
                    <td>{{ $t->kamar?->kode_kamar ?? '–' }}</td>
                    <td>{{ $t->tanggal_jatuhtempo ? $t->tanggal_jatuhtempo->format('d M Y') : '–' }}</td>
                    <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($t->metode_pembayaran) }}</td>
                    <td>{{ ucfirst($t->status_pembayaran) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
