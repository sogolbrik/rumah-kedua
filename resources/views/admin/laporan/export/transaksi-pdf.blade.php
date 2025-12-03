<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
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
        <h1>Laporan Transaksi</h1>
        <div class="period">Periode: {{ $tanggalMulai }} – {{ $tanggalSelesai }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Penyewa</th>
                <th>Kamar</th>
                <th class="text-right">Total Bayar</th>
                <th>Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
                <tr>
                    <td>{{ $item->kode ?? '—' }}</td>
                    <td>{{ $item->created_at?->translatedFormat('d F Y H:i') ?? '—' }}</td>
                    <td>{{ $item->user->name ?? '—' }}</td>
                    <td>{{ $item->kamar->kode_kamar ?? '—' }}</td>
                    <td class="text-right">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        @if ($item->midtrans_payment_type == 'bank_transfer')
                            Bank Transfer
                        @elseif($item->midtrans_payment_type == 'qris')
                            QRIS
                        @elseif($item->midtrans_payment_type == 'credit_card')
                            Credit Card
                        @else
                            Cash
                        @endif
                    </td>
                    <td>
                        @php
                            $statusMap = [
                                'pending' => 'Menunggu Pembayaran',
                                'paid' => 'Lunas',
                                'failed' => 'Gagal',
                                'cancelled' => 'Dibatalkan',
                                'expired' => 'Kadaluarsa',
                                'challenge' => 'Dalam Tantangan',
                            ];
                            $status = strtolower($item->status_pembayaran ?? '');
                            echo $statusMap[$status] ?? 'Tidak Diketahui';
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
