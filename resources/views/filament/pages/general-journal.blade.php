<x-filament::page>
    {{-- Filter Form --}}
    <form wire:submit.prevent="loadData" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            {{ $this->form }}

            <x-filament::button type="submit" class="w-full md:w-auto">
                <x-heroicon-o-magnifying-glass class="w-5 h-5 mr-2" />
                Tampilkan
            </x-filament::button>
        </div>
    </form>

    {{-- Jurnal Entries --}}
    @if ($journals)
        <div class="mt-8 space-y-6">
            @foreach ($journals as $journalId => $items)
                <x-filament::card class="bg-white dark:bg-gray-900 shadow rounded-xl">
                    <div class="border-b pb-2 mb-4 text-sm text-gray-700 dark:text-gray-300">
                        <div class="font-medium">
                            <x-heroicon-o-calendar class="w-4 h-4 inline mr-1 text-gray-500" />
                            Tanggal: <span class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($items[0]->date)->format('d M Y') }}</span>
                        </div>
                        <div class="mt-1">
                            <x-heroicon-o-pencil class="w-4 h-4 inline mr-1 text-gray-500" />
                            Keterangan: <span class="text-gray-800 dark:text-gray-200">{{ $items[0]->description }}</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left border-t border-gray-200 dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-2">Akun</th>
                                    <th class="px-4 py-2 text-right">Debit</th>
                                    <th class="px-4 py-2 text-right">Kredit</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($items as $entry)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                            {{ $entry->account_code ?? '' }} - {{ $entry->account_name }}
                                        </td>
                                        <td class="px-4 py-2 text-right text-green-700 dark:text-green-400">
                                            {{ $entry->debit ? 'Rp ' . number_format($entry->debit, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-4 py-2 text-right text-red-700 dark:text-red-400">
                                            {{ $entry->credit ? 'Rp ' . number_format($entry->credit, 0, ',', '.') : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-filament::card>
            @endforeach
        </div>
    @else
        <div class="text-center mt-12 text-gray-500 dark:text-gray-400">
            <x-heroicon-o-exclamation-circle class="w-6 h-6 mb-2 mx-auto" />
            Tidak ada data jurnal ditemukan.
        </div>
    @endif
</x-filament::page>