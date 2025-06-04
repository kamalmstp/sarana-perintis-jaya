<x-filament::page>
    <form wire:submit.prevent="loadData">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament::button type="submit">Tampilkan</x-filament::button>
        </div>
    </form>

    @if ($entries)
        <div class="mt-6">
            <x-filament::card>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b font-semibold">
                            <th class="py-2">Tanggal</th>
                            <th>Keterangan</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Kredit</th>
                            <th class="text-right">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $runningBalance = 0; @endphp
                        @foreach ($entries as $entry)
                            @php
                                $runningBalance += $entry->debit - $entry->credit;
                            @endphp
                            <tr class="border-t">
                                <td class="py-1">{{ \Carbon\Carbon::parse($entry->date)->format('d-m-Y') }}</td>
                                <td>{{ $entry->description }}</td>
                                <td class="text-right">{{ number_format($entry->debit, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($entry->credit, 0, ',', '.') }}</td>
                                <td class="text-right font-semibold">{{ number_format($runningBalance, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-filament::card>
        </div>
    @endif
</x-filament::page>