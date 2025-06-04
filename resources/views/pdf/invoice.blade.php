<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>INVOICE</h2>
    <p>No: {{ $invoice->invoice_number }}<br>
       Tanggal: {{ $invoice->invoice_date }}<br>
       Customer: {{ $invoice->customer_name }}</p>

    <table>
        <thead>
            <tr>
                <th>DO/PO</th>
                <th>Deskripsi</th>
                <th>Tarif</th>
                <th>Netto</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $item->order_proses->do_number ?? '-' }}</td>
                <td>{{ $item->description }}</td>
                <td class="text-right">Rp {{ number_format($item->tarif, 0, ',', '.') }}</td>
                <td class="text-right">{{ $item->total_netto }} Kg</td>
                <td class="text-right">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="text-right" style="margin-top: 10px;">
        <strong>Total: Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</strong><br>

        <strong>Grand Total: Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</strong>
    </p>
</body>
</html>