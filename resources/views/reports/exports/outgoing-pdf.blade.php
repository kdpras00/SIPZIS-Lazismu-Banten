<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
        }
        .summary {
            margin: 20px 0;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .summary-table th, .summary-table td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
        }
        .summary-table th {
            background-color: #f2f2f2;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .data-table th, .data-table td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
        }
        .data-table th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Dihasilkan pada: {{ $date }}</p>
    </div>

    <div class="summary">
        <table class="summary-table">
            <tr>
                <th>Total Distribusi</th>
                <td>{{ number_format($total_count, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Nominal</th>
                <td>Rp {{ number_format($total_amount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Distribusi</th>
                <th>Nama Mustahik</th>
                <th>Kategori</th>
                <th>Jenis Distribusi</th>
                <th>Nominal</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($distributions as $index => $distribution)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $distribution->distribution_code }}</td>
                <td>{{ $distribution->mustahik->name }}</td>
                <td>{{ \App\Models\Mustahik::CATEGORIES[$distribution->mustahik->category] ?? $distribution->mustahik->category }}</td>
                <td>
                    @switch($distribution->distribution_type)
                        @case('cash')
                            Tunai
                            @break
                        @case('goods')
                            Barang
                            @break
                        @case('voucher')
                            Voucher
                            @break
                        @case('service')
                            Layanan
                            @break
                    @endswitch
                </td>
                <td class="text-right">Rp {{ number_format($distribution->amount, 0, ',', '.') }}</td>
                <td>{{ $distribution->distribution_date->format('d/m/Y') }}</td>
                <td>
                    @if($distribution->is_received)
                        Sudah Diterima
                    @else
                        Belum Diterima
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Laporan ini dihasilkan oleh Sistem Manajemen Zakat
    </div>
</body>
</html>