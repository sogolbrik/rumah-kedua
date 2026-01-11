<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Pembayaran - {{ $transaksi->kode }}</title>
    <style>
        /* Base Background & Text */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #5f6c7b;
            /* Paragraph Color */
            line-height: 1.6;
            margin: 0;
            padding: 24px;
            background-color: #fffffe;
            /* Background Color */
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #90b4ce;
            /* Secondary Color for stroke */
            border-radius: 12px;
            background: #fffffe;
            position: relative;
        }

        /* Header */
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #094067;
            /* Stroke Color */
            padding-bottom: 20px;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #094067;
            /* Headline Color */
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .invoice-number {
            font-size: 13px;
            color: #5f6c7b;
            /* Paragraph Color */
            margin-top: 6px;
            font-family: monospace;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        /* Status: Paid (Highlight) */
        .status-paid {
            background-color: #3da9fc;
            /* Highlight/Button Color */
            color: #fffffe;
            /* Button Text Color */
        }

        /* Status: Pending/Expired/Failed (Tertiary) */
        .status-pending,
        .status-failed,
        .status-cancelled,
        .status-expired {
            background-color: #ef4565;
            /* Tertiary Color */
            color: #fffffe;
        }

        .status-default {
            background-color: #90b4ce;
            /* Secondary Color */
            color: #fffffe;
        }

        /* Section */
        .section {
            background-color: #fffffe;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #90b4ce;
            /* Secondary Color */
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #094067;
            /* Headline Color */
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #90b4ce;
            padding-bottom: 5px;
        }

        .section-content {
            font-size: 13px;
            color: #5f6c7b;
            /* Paragraph Color */
        }

        .section-content .label {
            font-weight: bold;
            color: #094067;
            /* Headline for sub-labels */
        }

        .section-content .value {
            color: #5f6c7b;
        }

        /* Grid Layout */
        .grid {
            width: 100%;
            margin-bottom: 10px;
        }

        .grid td {
            width: 50%;
            vertical-align: top;
            padding-right: 10px;
        }

        /* Payment Summary Table */
        .payment-summary {
            width: 100%;
        }

        .payment-summary .row {
            clear: both;
            padding: 5px 0;
        }

        .payment-summary .label {
            float: left;
            color: #5f6c7b;
        }

        .payment-summary .value {
            float: right;
            font-weight: bold;
            color: #094067;
        }

        .total-row {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #3da9fc;
            /* Highlight color for emphasis */
        }

        .total-value {
            font-size: 18px;
            color: #3da9fc;
            /* Highlight Color for Total */
            font-weight: 800;
        }

        /* Midtrans ID Note */
        .midtrans-note {
            background-color: #f2f7fb;
            /* Light Secondary mix */
            border-left: 4px solid #094067;
            /* Stroke */
            padding: 12px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .midtrans-note .label {
            font-weight: bold;
            color: #094067;
            font-size: 10px;
            text-transform: uppercase;
        }

        .midtrans-note .value {
            font-family: monospace;
            color: #5f6c7b;
            font-size: 12px;
        }

        /* Footer */
        .invoice-footer {
            text-align: center;
            font-size: 10px;
            color: #90b4ce;
            /* Secondary color */
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #90b4ce;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1 class="invoice-title">Invoice Pembayaran</h1>
            <p class="invoice-number">Ref: {{ $transaksi->kode }}</p>
        </div>

        <center>
            @php
                $statusMap = [
                    'paid' => ['class' => 'status-paid', 'label' => 'LUNAS - TERIMA KASIH'],
                    'pending' => ['class' => 'status-pending', 'label' => 'MENUNGGU PEMBAYARAN'],
                    'failed' => ['class' => 'status-failed', 'label' => 'PEMBAYARAN GAGAL'],
                    'cancelled' => ['class' => 'status-cancelled', 'label' => 'DIBATALKAN'],
                    'expired' => ['class' => 'status-expired', 'label' => 'KADALUARSA'],
                ];

                $status = $statusMap[$transaksi->status_pembayaran ?? ''] ?? [
                    'class' => 'status-default',
                    'label' => strtoupper($transaksi->status_pembayaran ?: 'PROSES'),
                ];
            @endphp
            <div class="status-badge {{ $status['class'] }}">{{ $status['label'] }}</div>
        </center>

        <table class="grid" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <div class="section">
                        <div class="section-title">Informasi Penghuni</div>
                        <div class="section-content">
                            <p class="label" style="font-size: 15px; margin-bottom: 5px;">{{ $transaksi->user->name ?? '—' }}</p>
                            <p><span class="label">ID:</span> {{ $transaksi->user->email ?? '—' }}</p>
                            <p><span class="label">Telp:</span> {{ $transaksi->user->telepon ?? '—' }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="section">
                        <div class="section-title">Detail Unit Kamar</div>
                        <div class="section-content">
                            <p><span class="label">Kode Unit:</span> <span class="value">{{ $transaksi->kamar->kode_kamar }}</span></p>
                            <p><span class="label">Tipe:</span> <span class="value">{{ $transaksi->kamar->tipe }}</span></p>
                            <p><span class="label">Masa Sewa:</span> <span class="value">{{ $transaksi->durasi }} Bulan</span></p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="section">
            <div class="section-title">Rincian Transaksi</div>
            <div class="payment-summary">
                <div class="row">
                    <span class="label">Tanggal Tagihan</span>
                    <span class="value">{{ $transaksi->created_at->translatedFormat('d F Y') }}</span>
                </div>
                <div style="clear: both;"></div>
                <div class="row">
                    <span class="label">Tanggal Pembayaran</span>
                    <span class="value">{{ $transaksi->tanggal_pembayaran ? \Carbon\Carbon::parse($transaksi->tanggal_pembayaran)->translatedFormat('d F Y') : '—' }}</span>
                </div>
                <div style="clear: both;"></div>
                <div class="row">
                    <span class="label">Metode</span>
                    <span class="value">
                        @if ($transaksi->metode_pembayaran === 'midtrans')
                            Online ({{ $transaksi->midtrans_payment_type ?? 'Midtrans' }})
                        @else
                            Tunai (Cash)
                        @endif
                    </span>
                </div>
                <div style="clear: both;"></div>

                <div class="total-row">
                    <span class="label" style="font-weight: bold; color: #094067; font-size: 14px;">TOTAL PEMBAYARAN</span>
                    <span class="value total-value">Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>

        @if ($transaksi->midtrans_transaction_id)
            <div class="midtrans-note">
                <div class="label">Midtrans Transaction ID</div>
                <div class="value">{{ $transaksi->midtrans_transaction_id }}</div>
            </div>
        @endif

        <div class="invoice-footer">
            <p><strong>RumahKedua Digital Invoice</strong></p>
            <p>Dihasilkan secara otomatis pada {{ now()->translatedFormat('d F Y, H:i') }}</p>
            <p>Simpan invoice ini sebagai bukti transaksi yang sah.</p>
        </div>
    </div>
</body>

</html>
