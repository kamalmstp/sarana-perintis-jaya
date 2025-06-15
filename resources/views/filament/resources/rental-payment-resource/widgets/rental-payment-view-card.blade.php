<x-filament-widgets::widget>
    <x-filament::section>
        <x-filament::card>
            <div class="space-y-2">
                <h2 class="text-xl font-bold text-primary-600">Detail Pembayaran Rental</h2>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <div class="text-gray-500">Nomor Kwitansi</div>
                        <div class="font-medium">{{ $record->receipt_number ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">Tanggal Pembayaran</div>
                        <div class="font-medium">{{ \Carbon\Carbon::parse($record->payment_date)->format('d M Y - h:m') }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">Pemilik Rental</div>
                        <div class="font-medium">{{ $record->rental->name }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">NPWP</div>
                        <div class="font-medium">{{ $record->rental->npwp ?? '-' }}</div>
                    </div>
                </div>

                <hr class="my-4" />

                <h3 class="text-lg font-semibold text-gray-700">Rincian Truk Rental</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border border-gray-300">
                        <thead class="bg-gray-100 text-left">
                            <tr>
                                <th class="border px-3 py-2">No</th>
                                <th class="border px-3 py-2">Plat Nomor</th>
                                <th class="border px-3 py-2 text-right">Netto (Qty)</th>
                                <th class="border px-3 py-2 text-right">Tarif</th>
                                <th class="border px-3 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($record->rentalCosts as $index => $cost)
                                @php
                                    $qty = $cost->orderDetail->netto ?? 1;
                                    $tarif = $cost->tarif_rental ?? 0;
                                    $subtotal = $qty * $tarif;
                                    $total += $subtotal;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-3 py-2">{{ $index + 1 }}</td>
                                    <td class="border px-3 py-2">{{ $cost->orderDetail->trucks->plate_number ?? '-' }}</td>
                                    <td class="border px-3 py-2 text-right">{{ number_format($qty, 0, ',', '.') }}</td>
                                    <td class="border px-3 py-2 text-right">Rp {{ number_format($tarif, 0, ',', '.') }}</td>
                                    <td class="border px-3 py-2 text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100 font-semibold">
                                <td colspan="4" class="border px-3 py-2 text-right">Total</td>
                                <td class="border px-3 py-2 text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-right text-lg font-bold mt-4">
                    Total: Rp {{ number_format($total, 0, ',', '.') }}
                </div>
            </div>
        </x-filament::card>
    </x-filament::section>
</x-filament-widgets::widget>
