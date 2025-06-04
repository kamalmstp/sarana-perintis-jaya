<x-filament::page>
    <form wire:submit.prevent="loadData">
        {{ $this->form }}
        <div class="mt-4">
            <x-filament::button type="submit">Tampilkan</x-filament::button>
        </div>
    </form>

    @if ($journals)
        <div class="mt-6">
            @foreach ($journals as $journalId => $items)
                <x-filament::card class="mb-4">
                    <div class="text-sm text-gray-600 mb-1">
                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($items[0]->date)->format('d-m-Y') }}
                    </div>
                    <div class="mb-2">
                        <strong>Keterangan:</strong> {{ $items[0]->description }}
                    </div>

                    <table class="w-full text-sm border-t">
                        <thead>
                            <tr class="text-left border-b">
                                <th>Akun</th>
                                <th class="text-right">Debit</th>
                                <th class="text-right">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $entry)
                                <tr class="border-b">
                                    <td>{{ $entry->account_name }}</td>
                                    <td class="text-right">{{ number_format($entry->debit, 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($entry->credit, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-filament::card>
            @endforeach
        </div>
    @endif
</x-filament::page>