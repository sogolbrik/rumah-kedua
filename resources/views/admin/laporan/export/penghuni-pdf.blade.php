<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Penghuni - RumahKedua</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #5f6c7b;
            background-color: #fffffe;
            line-height: 1.6;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
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
            font-size: 26px;
            font-weight: 800;
            color: #094067;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .meta {
            font-size: 12px;
            color: #90b4ce;
            font-weight: 500;
            text-align: right;
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
            font-size: 10px;
            letter-spacing: 0.8px;
        }

        tbody tr:nth-child(even) {
            background-color: #f8fbfd;
        }

        td {
            padding: 12px 12px;
            border-bottom: 1px solid #d8eefe;
            vertical-align: middle;
        }

        .resident-name {
            font-weight: 700;
            color: #094067;
            font-size: 13px;
        }

        .room-code {
            font-weight: 600;
            color: #3da9fc;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            text-align: center;
            min-width: 85px;
        }

        .status-aktif {
            background-color: #3da9fc;
            color: #fffffe;
        }

        .status-menunggak {
            background-color: #ef4565;
            color: #fffffe;
        }

        .tunggakan-count {
            color: #ef4565;
            font-weight: 700;
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
                <h1>Laporan Penghuni</h1>
                <div style="color: #5f6c7b; font-size: 13px; margin-top: 5px;">Data Keanggotaan & Status Pembayaran</div>
            </div>
            <div class="meta">
                RumahKedua Management<br>
                Generated: {{ \Carbon\Carbon::now()->translatedFormat('d M Y, H:i') }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama Penghuni</th>
                    <th>Kamar</th>
                    <th>No. Telepon</th>
                    <th>Email</th>
                    <th>Tgl Masuk</th>
                    <th class="text-center">Tunggakan</th>
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
                        <td class="resident-name">{{ $item->name ?? '—' }}</td>
                        <td class="room-code">{{ $item->kamar->kode_kamar ?? '—' }}</td>
                        <td>{{ $item->telepon ?? '—' }}</td>
                        <td style="font-size: 11px;">{{ $item->email ?? '—' }}</td>
                        <td>
                            @if ($item->tanggal_masuk)
                                {{ \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d M Y') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($isMenunggak)
                                <span class="tunggakan-count">{{ $hariTunggakan }} Hari</span>
                            @else
                                <span style="color: #90b4ce;">—</span>
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
            Dicetak secara otomatis oleh <b>RumahKedua Admin Panel</b> pada {{ now()->translatedFormat('d F Y, H:i') }}
        </div>
    </div>
</body>

</html>
