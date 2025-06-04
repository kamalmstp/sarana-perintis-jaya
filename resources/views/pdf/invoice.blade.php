<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; }
        table { border-collapse: collapse; width: 100%; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .bordered td, .bordered th { border: 1px solid #000; padding: 6px; }
        .no-border td { padding: 3px 6px; }
        .mt-2 { margin-top: 10px; }
        .mt-4 { margin-top: 20px; }
    </style>
</head>
<body>

    <h2 class="text-center text-bold">INVOICE</h2>

    <table class="no-border">
        <tr>
            <td width="20%">Kepada Yth</td>
            <td width="2%">:</td>
            <td>
                <strong>PT TANTAHAN PANDUHUP ASI</strong><br>
                Cambridge City Square LT 3<br>
                Jl. S. Parman No. 217<br>
                Medan 20152
            </td>
        </tr>
        <tr>
            <td>Nomor</td>
            <td>:</td>
            <td>{{ $invoice->invoice_number }}</td>
        </tr>
    </table>

    <p class="text-center text-bold mt-2">
        Ongkos angkut kernel TPA sampai ke Gudang KTN
    </p>

    <table class="bordered mt-2">
        <thead>
            <tr>
                <th>DESCRIPTION</th>
                <th>LOKASI</th>
                <th class="text-right">UNIT PRICE</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    1. Perincian pembayaran:<br>
                    Kontrak 014/DO/TPA-PK/IV/2025<br>
                    151,140 kg x 355,-/MT<br><br>

                    Kontrak 017/DO/TPA-PK/IV/2025<br>
                    64,090 kg x 355,-/MT<br><br>

                    Kontrak 017/DO/TPA-PK/IV/2025<br>
                    11,360 kg x 350,-/MT<br><br>

                    Kontrak 019/DO/TPA-PK/IV/2025<br>
                    125,670 kg x 350,-/MT
                </td>
                <td>
                    Gudang KTN<br><br>
                    Gudang KTN<br><br>
                    Gudang KTN<br><br>
                    Gudang KTN
                </td>
                <td class="text-right">
                    53.654.700<br><br>
                    22.751.950<br><br>
                    3.976.000<br><br>
                    43.984.500
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-bold text-right">TOTAL</td>
                <td class="text-right text-bold">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p class="mt-2"><strong>Terbilang:</strong> Seratus Dua Puluh Empat Juta Tiga Ratus Enam Puluh Tujuh Ribu Seratus Lima Puluh Rupiah.</p>

    <table class="mt-4" width="100%">
        <tr>
            <td width="50%" style="border:1px solid #000; padding:6px;">
                <strong>CV SARANA PERINTIS JAYA</strong><br>
                BANK MANDIRI<br>
                Cab. Sampit<br>
                A/C 159-000061125-0
            </td>
            <td class="text-center">
                <strong>CV SARANA PERINTIS JAYA</strong><br>
                Sampit, {{ $invoice->invoice_date }}<br><br><br><br>
                <u>Nurul Fitriah</u>
            </td>
        </tr>
    </table>

    <p class="text-center mt-4" style="font-size: 10pt;">
        <strong>Jl. M Hatta No 70 RT/RW 016/004 Sampit - Kotawaringin Timur, Kalimantan Tengah</strong><br>
        Telp. 08115201797 &nbsp; email : <u>gungun_kurniawan@yahoo.co.id</u>
    </p>

</body>
</html>