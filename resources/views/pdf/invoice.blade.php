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
        .text-top { vertical-align: text-top; }
        .bordered td, .bordered th { border: 1px solid #000; padding: 6px; }
        .no-border td { padding: 3px 6px; }
        .mt-2 { margin-top: 10px; }
        .mt-4 { margin-top: 20px; }
        .kop-surat {
            display: flex;
            align-items: center;
            text-align:center;
            gap: 10px;
            font-family: 'Times New Roman', serif;
            margin-bottom: 20px;
        }

        .kop-surat .spj {
            font-size: 68px;
            font-weight: bold;
            font-style: italic;
            color: #d52b2b; /* merah */
        }

        .kop-surat .nama-perusahaan {
            font-size: 24px;
            font-weight: bold;
            color: #003366; /* biru tua */
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <table style=" width:100%;border-bottom:1px solid;">
            <tr style="text-align: center;border-bottom:1px solid;">
                <td style="">

                </td>
                <td style="width: 25%; text-align: right;">
                    <span class="spj">SPJ</span>
                </td>
                <td style="width: 63%; text-align: center; padding-top:10;">
                    <span class="nama-perusahaan">CV SARANA PERINTIS JAYA</span>
                </td>
                <td></td>
            </tr>
        </table>
    </div>

    <h2 class="text-center text-bold text-underline">INVOICE</h2>

    <table class="no-border">
        <tr>
            <td width="20%">Kepada Yth</td>
            <td width="2%">:</td>
            <td>
                <strong>{{ $invoice->order->customers->name }}</strong>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>{{ $invoice->order->customers->address }}</td>
        </tr>
        <tr>
            <td>Fax</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Nomor</td>
            <td>:</td>
            <td>{{ $invoice->invoice_number }}</td>
        </tr>
    </table>


    <table class="bordered mt-2">
        <thead>
            <tr>
                <th colspan="2">
                    {{ $invoice->notes }}
                </th>
            </tr>
            <tr>
                <th>DESCRIPTION</th>
                <th class="text-right">UNIT PRICE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
            <tr>
                <td style="border-bottom:none; border-top:none;">
                    {{ $item->order_proses->locations->name }}  &nbsp;&nbsp;&nbsp;
                    {{ $item->order_proses->item_proses }} &nbsp;&nbsp;&nbsp;
                    {{ $item->order_proses->total_netto ?? '-' }}&nbsp;Kg &nbsp; X &nbsp;
                    Rp &nbsp;{{ number_format($item->order_proses->tarif, 0, ',', '.') }}
                </td>
                <td class="text-right" style="border-bottom:none; border-top:none;">
                    Rp {{ number_format($item->amount, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td style="border-top:none;"></td><td style="border-top:none;"></td>
            </tr>
            <tr>
                <td class="text-bold text-right">TOTAL</td>
                <td class="text-right text-bold">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p class="mt-2"><strong>Terbilang:</strong> {{ ucwords(terbilang($invoice->total_amount)) }} Rupiah.</p>

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