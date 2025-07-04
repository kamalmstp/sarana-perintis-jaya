<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pembayaran Truck Rental</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .company-info {
            text-align: center;
            font-size: 11px;
        }
        .info-table, .payment-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 8px;
        }
        .payment-table th, .payment-table td {
            border: 1px solid #999;
            padding: 6px 10px;
            text-align: left;
        }
        .total-row {
            background-color: #f5f5f5;
        }

        /* SIGNATURE SECTION */
        .signature-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }
        .signature {
            width: 45%;
        }
        .signature .line {
            margin-top: 60px;
            border-top: 1px solid #000;
            width: 100%;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-style: italic;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>CV SARANA PERINTIS JAYA</h1>
    </div>

    <table class="info-table">
        <tr>
            <td colspan="2" style="text-align: center;">NOTA PEMBAYARAN ANGKUTAN</td>
            <td>No. Urut</td>
            <td>:</td>
            <td>{{ $record->receipt_number ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kepada Yth (Nama/NPWP)</td>
            <td>: &nbsp; {{ $payment->rental->name }} / {{ $payment->rental->npwp }}</td>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Pembayaran</td>
            <td>: &nbsp; </td>
            <td>Jam</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('h:m') }} &nbsp; WIB</td>
        </tr>
    </table>

    <table class="payment-table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">No.Polisi/Sopir</th>
                <th style="text-align: center;">Jenis Pupuk</th>
                <th style="text-align: center;">Kebun</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: center;">Harga/ Kg</th>
                <th style="text-align: center;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; $totalPph = 0; @endphp
            @foreach ($payment->rentalCosts as $i => $cost)
                @php
                    $netto = $cost->orderDetail->netto ?? 1;
                    $tarif = $cost->tarif_rental;
                    $total = $netto * $tarif;
                    $pph = $total * $cost->pph;
                    $adm = 5000;
                    $grandTotal += $total;
                    $totalPph += $pph;
                    $i += 0;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $i + 1 }}</td>
                    <td>{{ $cost->orderDetail->trucks->plate_number ?? '-' }} / {{ $cost->orderDetail->drivers->name ?? '-' }}</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;">{{ number_format($netto, 0, ',', '.') }} Kg</td>
                    <td style="text-align: center;">Rp {{ number_format($tarif, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="6" style="text-align: center;">TOTAL</td>
                    <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: center;">PPh Pasal 23 /PP 23 Tahun 2018</td>
                    <td>(Rp {{ number_format($totalPph, 0, ',', '.') }})</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">Biaya Administrasi</td>
                    <td></td>
                    <td style="text-align: center;">{{ $i + 1 }}</td>
                    <td style="text-align: center;">x</td>
                    <td style="text-align: center;">Rp {{ number_format(5000, 0, ',', '.') }}</td>
                    <td>(Rp {{ number_format(($i + 1) * $adm, 0, ',','.') }})</td>
                </tr>
                <tr style="font-weight: bold;" >
                    <td colspan="6" style="text-align: center;">Total Dibayarkan</td>
                    <td>Rp {{ number_format($grandTotal - $totalPph - (($i + 1) * $adm), 0, ',', '.') }}</td>
                </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 10px;">
        <tr>
            <td style="width: 50%; text-align: center;">
                <p>Diterima oleh,<br>Penerima</p>
                <br><br><br><br>
                <div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;">
                    {{ '......................' }}
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <p>Diserahkan oleh,<br>Kasir</p>
                <br><br><br><br>
                <div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;">
                    {{ '......................' }}
                </div>
            </td>
        </tr>
    </table>
</body>
</html>