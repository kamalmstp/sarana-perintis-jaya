<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pembayaran Truck Rental</title>
    <style>

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
            margin-top: 50px;
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
                    <div class="company-info">
                        <p>Jl. M Hatta No 70 RT/RW 016/004 Sampit - Kotawaringin Timur, Kalimantan Tengah</p>
                    </div>
                </td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="header">
        <h2>KWITANSI PEMBAYARAN</h2>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>No. Kwitansi</strong></td>
            <td>: {{ 'KW-' . str_pad($orderDetail->rentalCost->no_kwitansi, 5, '0', STR_PAD_LEFT) }}</td>
            <td><strong>Tanggal</strong></td>
            <td>: {{ $orderDetail->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <td><strong>No. Surat Jalan</strong></td>
            <td>: {{ $orderDetail->rentalCost->no_surat_jalan ?? '-' }}</td>
            <td><strong>Supir</strong></td>
            <td>: {{ $orderDetail->drivers->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Plat Nomor</strong></td>
            <td>: {{ $orderDetail->trucks->plate_number ?? '-' }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="payment-table" style="margin-top: 25px;">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pengiriman {{$orderDetail->order_proses->item_proses}} sebanyak {{$orderDetail->netto . ' Kg' ?? '-' }}, ke {{$orderDetail->order_proses->locations->name}}</td>
                <td>Rp {{ number_format($orderDetail->rentalCost->tarif_rental, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td>PPh Pasal 23 /PP 23 Tahun 2018</td>
                <td>(Rp {{ number_format(($orderDetail->rentalCost->tarif_rental * $orderDetail->rentalCost->pph), 0, ',', '.') }})</td>
            </tr>
            <tr class="total-row">
                <td>Biaya Administrasi</td>
                <td>(Rp {{ number_format(5000, 0, ',', '.') }})</td>
            </tr>
            <tr class="total-row" style="font-weight: bold;">
                <td>Total Dibayarkan</td>
                <td>Rp {{ number_format(($orderDetail->rentalCost->tarif_rental - 5000 - ($orderDetail->rentalCost->tarif_rental * $orderDetail->rentalCost->pph)), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <table style="width: 100%; margin-top: 30px;">
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

    <div class="footer">
        Dokumen ini dicetak sebagai bukti pembayaran tunai kepada supir berdasarkan Surat Jalan terkait.
    </div>
</body>
</html>