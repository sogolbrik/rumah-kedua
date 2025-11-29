<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penghuni</title>
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
    <h1>Laporan Penghuni</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Kamar</th>
                <th>Tanggal Masuk</th>
                <th>Status</th>
                <th>Durasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->telepon ?? '–' }}</td>
                    <td>{{ $p->kamar?->kode_kamar ?? '–' }}</td>
                    <td>{{ $p->tanggal_masuk ? \Carbon\Carbon::parse($p->tanggal_masuk)->format('d M Y') : '–' }}</td>
                    <td>{{ $p->status_penghuni ?? '–' }}</td>
                    <td>
                        @if ($p->tanggal_masuk)
                            {{ \Carbon\Carbon::parse($p->tanggal_masuk)->diffInMonths(now()) }} bulan
                        @else
                            –
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
