<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000000;
            padding: 6px;
            text-align: left;
        }

        .no-border {
            border: none !important;
        }

        .section-header {
            font-weight: bold;
            margin-top: 10px;
        }

        .break-space {
            height: 20px;
        }
    </style>
</head>
<body>

@forelse ($data as $orderProses)
    {{-- Header Info DO/PO --}}
    <table class="no-border">
        <tr>
            <td class="no-border"><strong>DO Number</strong></td>
            <td class="no-border">{{ $orderProses->do_number }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>PO Number</strong></td>
            <td class="no-border">{{ $orderProses->po_number }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>SO Number</strong></td>
            <td class="no-border">{{ $orderProses->so_number }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>Item</strong></td>
            <td class="no-border">{{ $orderProses->item_proses }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>Total KG</strong></td>
            <td class="no-border">{{ $orderProses->total_kg_proses }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>Total Bag</strong></td>
            <td class="no-border">{{ $orderProses->total_bag_proses }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>Customer</strong></td>
            <td class="no-border">{{ optional($orderProses->orders->customers)->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>Note</strong></td>
            <td class="no-border">{{ $orderProses->note_proses }}</td>
        </tr>
    </table>

    {{-- Trucking Detail --}}
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Polisi</th>
                <th>Supir</th>
                <th>Bag Kirim</th>
                <th>Bag Terima</th>
                <th>Bruto</th>
                <th>Tara</th>
                <th>Netto</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orderProses->order_detail as $i => $detail)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $detail->date_detail }}</td>
                    <td>{{ optional($detail->trucks)->plate_number ?? '-' }}</td>
                    <td>{{ optional($detail->drivers)->name ?? '-' }}</td>
                    <td>{{ $detail->bag_send }}</td>
                    <td>{{ $detail->bag_received }}</td>
                    <td>{{ $detail->bruto }}</td>
                    <td>{{ $detail->tara }}</td>
                    <td>{{ $detail->netto }}</td>
                    <td>{{ $detail->status_detail }}</td>
                    <td>{{ $detail->note_detail }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11">Tidak Ada Data Trucking</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Spacer between records --}}
    <table class="no-border">
        <tr class="break-space"><td class="no-border">&nbsp;</td></tr>
    </table>
@empty
   <p>Tidak ada data DO/PO yang di Export</p>
@endforelse

</body>
</html>