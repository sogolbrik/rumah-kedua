<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Pembayaran - {{ $transaksi->kode }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 24px;
            background-color: #fff;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 24px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: linear-gradient(to bottom right, #f0f9ff, #f0fdfa);
        }

        /* Header */
        .invoice-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .invoice-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #dbeafe;
            color: #2563eb;
            border-radius: 50%;
            margin-bottom: 12px;
            font-size: 18px;
        }

        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }

        .invoice-number {
            font-size: 12px;
            color: #475569;
            margin-top: 4px;
            font-family: monospace;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            margin: 12px 0 20px;
        }

        .status-paid {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-failed,
        .status-cancelled {
            background-color: #fee2e2;
            colored: #b91c1c;
            color: #b91c1c;
        }

        .status-expired {
            background-color: #ffedd5;
            color: #c2410c;
        }

        .status-challenge {
            background-color: #ede9fe;
            color: #6d28d9;
        }

        .status-default {
            background-color: #f1f5f9;
            color: #334155;
        }

        /* Section */
        .section {
            background-color: #ffffff;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #475569;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .section-title i {
            width: 16px;
            text-align: center;
            color: #2563eb;
        }

        .section-content {
            font-size: 13px;
            color: #1e293b;
        }

        .section-content .label {
            font-weight: bold;
            color: #334155;
        }

        .section-content .value {
            color: #1e293b;
        }

        /* Two-column grid (for Penghuni & Kamar) */
        .grid {
            display: flex;
            gap: 16px;
            margin-bottom: 18px;
        }

        .grid-item {
            flex: 1;
        }

        /* Payment Summary */
        .payment-summary .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .payment-summary .label {
            color: #64748b;
        }

        .payment-summary .value {
            font-weight: bold;
            color: #1e293b;
        }

        .payment-summary .total-value {
            font-size: 16px;
            color: #0f172a;
            font-weight: bold;
        }

        /* Midtrans ID */
        .midtrans-note {
            background-color: #eff6ff;
            border: 1px dashed #93c5fd;
            padding: 10px;
            border-radius: 6px;
            font-size: 11px;
            margin: 16px 0;
        }

        .midtrans-note .label {
            font-weight: bold;
            color: #1d4ed8;
            margin-bottom: 4px;
        }

        .midtrans-note .value {
            font-family: monospace;
            color: #1e40af;
        }

        /* Footer */
        .invoice-footer {
            text-align: center;
            font-size: 10px;
            color: #64748b;
            margin-top: 30px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <h1 class="invoice-title">Invoice Pembayaran</h1>
            <p class="invoice-number">Nomor: {{ $transaksi->kode }}</p>
        </div>

        <!-- Status Badge -->
        @php
            $statusMap = [
                'paid' => ['class' => 'status-paid', 'label' => 'Lunas'],
                'pending' => ['class' => 'status-pending', 'label' => 'Menunggu Pembayaran'],
                'failed' => ['class' => 'status-failed', 'label' => 'Gagal'],
                'cancelled' => ['class' => 'status-cancelled', 'label' => 'Dibatalkan'],
                'expired' => ['class' => 'status-expired', 'label' => 'Kadaluarsa'],
                'challenge' => ['class' => 'status-challenge', 'label' => 'Dalam Tantangan'],
            ];

            $status = $statusMap[$transaksi->status_pembayaran ?? ''] ?? [
                'class' => 'status-default',
                'label' => ucfirst($transaksi->status_pembayaran ?: 'Tidak Diketahui'),
            ];
        @endphp
        <div class="status-badge {{ $status['class'] }}">{{ $status['label'] }}</div>

        <!-- Penghuni & Kamar -->
        <div class="grid">
            <div class="grid-item">
                <div class="section">
                    <div class="section-title">Penghuni</div>
                    <div class="section-content">
                        <p><span class="value">{{ $transaksi->user->name ?? '—' }}</span></p>
                        <p><span class="label">Email:</span> <span class="value">{{ $transaksi->user->email ?? '—' }}</span></p>
                        <p><span class="label">Telepon:</span> <span class="value">{{ $transaksi->user->telepon ?? '—' }}</span></p>
                    </div>
                </div>
            </div>

            <div class="grid-item">
                <div class="section">
                    <div class="section-title">Detail Kamar</div>
                    <div class="section-content">
                        <p><span class="label">Kode:</span> <span class="value">{{ $transaksi->kamar->kode_kamar }}</span></p>
                        <p><span class="label">Tipe:</span> <span class="value">{{ $transaksi->kamar->tipe }}</span></p>
                        <p><span class="label">Durasi:</span> <span class="value">{{ $transaksi->durasi }} bulan</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tanggal & Pembayaran -->
        <div class="section">
            <div class="payment-summary">
                <div class="row">
                    <span class="label">Tanggal Bayar</span>
                    <span class="value">{{ $transaksi->tanggal_pembayaran ? \Carbon\Carbon::parse($transaksi->tanggal_pembayaran)->translatedFormat('d F Y') : '—' }}</span>
                </div>
                <div class="row">
                    <span class="label">Jatuh Tempo</span>
                    <span class="value">{{ $transaksi->tanggal_jatuhtempo ? \Carbon\Carbon::parse($transaksi->tanggal_jatuhtempo)->translatedFormat('d F Y') : '—' }}</span>
                </div>
                <div class="row">
                    <span class="label">Metode Pembayaran</span>
                    <span class="value">
                        @if ($transaksi->metode_pembayaran === 'midtrans')
                            Midtrans ({{ $transaksi->midtrans_payment_type ?? '—' }})
                        @else
                            Cash
                        @endif
                    </span>
                </div>
                <div class="row" style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #cbd5e1;">
                    <span class="label">Total Bayar</span>
                    <span class="value total-value">Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Midtrans ID (jika ada) -->
        @if ($transaksi->midtrans_transaction_id)
            <div class="midtrans-note">
                <div class="label">ID Transaksi Midtrans</div>
                <div class="value">{{ $transaksi->midtrans_transaction_id }}</div>
            </div>
        @endif

        <!-- Footer -->
        <div class="invoice-footer">
            Invoice ini dibuat secara otomatis oleh sistem RumahKedua • {{ now()->translatedFormat('d F Y H:i') }}
        </div>
    </div>
</body>

</html>
