<!DOCTYPE html>
<html>

<head>
    <title>Kwitansi Pembayaran - {{ $payment->payment_code }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 30px;
            background: #f8f9fa;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border: 2px solid #059669;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #059669;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #059669;
        }

        .receipt-no {
            text-align: right;
        }

        .receipt-no .label {
            font-size: 11px;
            color: #666;
        }

        .receipt-no .number {
            font-size: 16px;
            font-weight: bold;
            color: #059669;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
        }

        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            width: 180px;
            color: #666;
            flex-shrink: 0;
        }

        .info-value {
            flex: 1;
            font-weight: 500;
            color: #333;
        }

        .amount-section {
            background: #f8f9fa;
            border: 2px solid #059669;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }

        .amount-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }

        .amount-value {
            font-size: 32px;
            font-weight: bold;
            color: #059669;
        }

        .terbilang {
            margin-top: 8px;
            font-size: 13px;
            font-style: italic;
            color: #666;
        }

        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
            gap: 40px;
        }

        .signature-box {
            flex: 1;
            text-align: center;
            min-width: 0;
        }

        .signature-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 60px;
            display: block;
        }

        .signature-name {
            border-top: 1px solid #333;
            padding-top: 8px;
            font-weight: 500;
            margin-top: 0;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
        }

        .footer-note {
            font-size: 11px;
            color: #666;
            font-style: italic;
            margin-bottom: 8px;
        }

        .footer-info {
            font-size: 10px;
            color: #999;
        }

        @media print {
            body {
                padding: 0;
                background: white;
            }

            .container {
                border: 1px solid #059669;
                padding: 20px;
            }

            .amount-section {
                break-inside: avoid;
            }

            .signatures {
                margin-top: 40px;
            }

            .signature-label {
                margin-bottom: 50px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">SIPZIS</div>
            <div class="receipt-no">
                <div class="label">No. Kwitansi</div>
                <div class="number">{{ $payment->receipt_number }}</div>
            </div>
        </div>

        <div class="title">KWITANSI PEMBAYARAN</div>

        <div class="info-row">
            <div class="info-label">Diterima dari</div>
            <div class="info-value">{{ $payment->muzakki->name }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Untuk pembayaran</div>
            <div class="info-value">
                {{-- Debug information --}}
                {{-- Payment Code: {{ $payment->payment_code }} --}}
                {{-- Program Type ID: {{ $payment->program_type_id }} --}}
                {{-- Program Category: {{ var_export($payment->program_category, true) }} --}}
                {{-- Program Type Name: {{ $payment->programType ? $payment->programType->name : 'NULL' }} --}}

                {{ $payment->programType ? $payment->programType->name : ($payment->program_category ? ucfirst(str_replace('-', ' ', $payment->program_category)) : 'Donasi Umum') }}
                @if($payment->notes)
                <span style="font-size: 12px; color: #666;"> ({{ $payment->notes }})</span>
                @endif
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">Metode pembayaran</div>
            <div class="info-value">{{ ucfirst($payment->payment_method) }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Tanggal</div>
            <div class="info-value">{{ $payment->payment_date->format('d F Y') }}</div>
        </div>

        <div class="amount-section">
            <div class="amount-label">JUMLAH PEMBAYARAN</div>
            <div class="amount-value">Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</div>
            <div class="terbilang">{{ ucwords(\Illuminate\Support\Str::lower(\App\Helpers\Terbilang::convert($payment->paid_amount))) }} Rupiah</div>
        </div>

        <table style="width: 100%; margin-top: 50px; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <div style="font-size: 12px; color: #666; margin-bottom: 60px;">Muzakki</div>
                    <div style="border-top: 1px solid #333; padding-top: 8px; font-weight: 500; display: inline-block; min-width: 150px;">{{ $payment->muzakki->name }}</div>
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <div style="font-size: 12px; color: #666; margin-bottom: 60px;">Penerima</div>
                    <div style="border-top: 1px solid #333; padding-top: 8px; font-weight: 500; display: inline-block; min-width: 150px;">Amil Zakat</div>
                </td>
            </tr>
        </table>

        <div class="footer">
            <div class="footer-note">"Barangsiapa diberi hikmah, sungguh ia telah dianugerahi kebaikan yang banyak." (QS. Al-Baqarah: 269)</div>
            <div class="footer-info">Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB | Terima kasih atas kepercayaan Anda</div>
        </div>
    </div>
</body>

</html>