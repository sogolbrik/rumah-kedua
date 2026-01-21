<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi - RumahKedua</title>
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
            font-size: 14px;
            color: #5f6c7b;
            margin-top: 5px;
            font-weight: 400;
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
            background-color: #fffffe;
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
            border: none;
        }

        tbody tr {
            transition: background-color 0.2s;
        }

        tbody tr:nth-child(even) {
            background-color: #f8fbfd;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #d8eefe;
            vertical-align: middle;
        }

        .text-right {
            text-align: right;
        }

        .harga {
            font-weight: 700;
            color: #094067;
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
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
            min-width: 80px;
        }

        .status-lunas {
            background-color: #3da9fc;
            color: #fffffe;
        }

        .status-menunggu {
            background-color: #90b4ce;
            color: #fffffe;
        }

        .status-gagal,
        .status-dibatalkan,
        .status-kadaluarsa {
            background-color: #ef4565;
            color: #fffffe;
        }

        .status-tantangan {
            background-color: #094067;
            color: #fffffe;
        }

        .status-default {
            background-color: #5f6c7b;
            color: #fffffe;
        }

        .payment-method {
            font-weight: 600;
            color: #094067;
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
                <h1>Laporan Transaksi</h1>
                <div class="period">Periode: <b>{{ $tanggalMulai }}</b> - <b>{{ $tanggalSelesai }}</b></div>
            </div>
            <div class="report-info">
                RumahKedua Management System<br>
                Data Generated: {{ now()->translatedFormat('d M Y') }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tanggal & Waktu</th>
                    <th>Penyewa</th>
                    <th>Kamar</th>
                    <th class="text-right">Total Bayar</th>
                    <th>Metode</th>
                    <th style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $item)
                    <tr>
                        <td style="font-weight: 700; color: #3da9fc;">{{ $item->kode ?? '—' }}</td>
                        <td>{{ $item->created_at?->translatedFormat('d M Y, H:i') ?? '—' }}</td>
                        <td>{{ $item->user->name ?? '—' }}</td>
                        <td style="font-weight: 600;">{{ $item->kamar->kode_kamar ?? '—' }}</td>
                        <td class="text-right harga">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                        <td class="payment-method">
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
                        <td style="text-align: center;">
                            @php
                                $statusMap = [
                                    'pending' => ['label' => 'Pending', 'class' => 'menunggu'],
                                    'paid' => ['label' => 'Success', 'class' => 'lunas'],
                                    'failed' => ['label' => 'Failed', 'class' => 'gagal'],
                                    'cancelled' => ['label' => 'Canceled', 'class' => 'dibatalkan'],
                                    'expired' => ['label' => 'Expired', 'class' => 'kadaluarsa'],
                                    'challenge' => ['label' => 'Challenge', 'class' => 'tantangan'],
                                ];
                                $statusKey = strtolower($item->status_pembayaran ?? '');
                                $config = $statusMap[$statusKey] ?? ['label' => 'Unknown', 'class' => 'default'];
                            @endphp
                            <span class="badge status-{{ $config['class'] }}">{{ $config['label'] }}</span>
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
