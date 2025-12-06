<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
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
            border-bottom: 2px solid #2980b9;
        }

        .header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #2980b9;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .period {
            font-size: 12px;
            color: #555;
            margin-top: 6px;
            font-weight: 500;
        }

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

        .text-right {
            text-align: right;
        }

        .harga {
            font-weight: 700;
            color: #2c3e50;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-lunas {
            background-color: #2ecc71;
            color: white;
        }

        .status-menunggu {
            background-color: #f39c12;
            color: white;
        }

        .status-gagal,
        .status-dibatalkan,
        .status-kadaluarsa {
            background-color: #e74c3c;
            color: white;
        }

        .status-tantangan {
            background-color: #9b59b6;
            color: white;
        }

        .status-default {
            background-color: #95a5a6;
            color: white;
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
                    <td class="text-right harga">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $paymentMap = [
                                'bank_transfer' => 'Bank Transfer',
                                'qris' => 'QRIS',
                                'credit_card' => 'Kartu Kredit',
                                'gopay' => 'GoPay',
                                'shopeepay' => 'ShopeePay',
                            ];
                            echo $paymentMap[$item->midtrans_payment_type ?? ''] ?? 'Cash';
                        @endphp
                    </td>
                    <td>
                        @php
                            $statusMap = [
                                'pending' => ['label' => 'Menunggu Pembayaran', 'class' => 'menunggu'],
                                'paid' => ['label' => 'Lunas', 'class' => 'lunas'],
                                'failed' => ['label' => 'Gagal', 'class' => 'gagal'],
                                'cancelled' => ['label' => 'Dibatalkan', 'class' => 'dibatalkan'],
                                'expired' => ['label' => 'Kadaluarsa', 'class' => 'kadaluarsa'],
                                'challenge' => ['label' => 'Dalam Tantangan', 'class' => 'tantangan'],
                            ];
                            $statusKey = strtolower($item->status_pembayaran ?? '');
                            $config = $statusMap[$statusKey] ?? ['label' => 'Tidak Diketahui', 'class' => 'default'];
                        @endphp
                        <span class="badge status-{{ $config['class'] }}">{{ $config['label'] }}</span>
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
