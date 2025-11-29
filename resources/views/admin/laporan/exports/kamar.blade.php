<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kamar</title>
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
    <h1>Laporan Kamar</h1>
    <table>
        <thead>
            <tr>
                <th>Kode Kamar</th>
                <th>Harga</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Penghuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $k)
                <tr>
                    <td>{{ $k->kode_kamar }}</td>
                    <td>Rp {{ number_format($k->harga, 0, ',', '.') }}</td>
                    <td>{{ $k->tipe }}</td>
                    <td>{{ $k->status }}</td>
                    <td>{{ $k->penghuni?->name ?? '–' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
