<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; line-height: 1.4; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .border { border: 1px solid #000; padding: 8px; }
        .wrapper { width: 100%; padding: 20px; }
        table { width: 100%; margin-top: 10px; }
        .mt-2 { margin-top: 10px; }
        .stamp { font-size: 24px; font-weight: bold; color: #000; border: 2px solid #000; padding: 5px; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="text-center">
            <h3>CV. SARANA PERINTIS JAYA</h3>
            <h4>NOTA PEMBAYARAN</h4>
        </div>

        <table>
            <tr>
                <td><strong>No.</strong></td>
                <td>{{ $payment->payment_number }}</td>
            </tr>
            <tr>
                <td><strong>Telah terima dari</strong></td>
                <td>CV. Sarana Perintis Jaya</td>
            </tr>
            <tr>
                <td><strong>Untuk pembayaran</strong></td>
                <td>{{ $payment->details->first()->worker_name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Uang sejumlah</strong></td>
                <td class="bold">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Rincian</strong></td>
                <td>
                    @foreach($payment->details as $detail)
                        Rp {{ number_format($detail->tarif_per_kg, 0, ',', '.') }} x {{ $detail->qty_kg }} = 
                        Rp {{ number_format($detail->total_price, 0, ',', '.') }}<br>
                    @endforeach
                </td>
            </tr>
        </table>

        <div class="mt-2">
            <p>Tanjung, {{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d F Y') }}</p>
            <p>Ttd. Petugas</p>
        </div>

        <div class="stamp">
            LUNAS <br>
            {{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d M Y') }}
        </div>
    </div>
</body>
</html>