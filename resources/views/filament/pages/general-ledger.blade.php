<x-filament::page>
    <div class="space-y-6">
        {{-- Filter Form --}}
        <form wire:submit.prevent="loadTransactions">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                {{ $this->form }}

                <x-filament::button type="submit" class="w-full md:w-auto">
                    <x-heroicon-o-magnifying-glass class="w-4 h-4 mr-2" />
                    Tampilkan
                </x-filament::button>
            </div>
        </form>

        @if ($transactions)
            {{-- Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 shadow-sm border border-blue-100 dark:border-blue-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-blue-700 dark:text-blue-300">Akun</p>
                            <p class="font-semibold text-lg text-gray-900 dark:text-white">
                                {{ \App\Models\Account::find($account_id)?->name ?? '-' }}
                            </p>
                        </div>
                        <x-heroicon-o-banknotes class="w-6 h-6 text-blue-600 dark:text-blue-300" />
                    </div>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 shadow-sm border border-green-100 dark:border-green-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-green-700 dark:text-green-300">Periode</p>
                            <p class="font-semibold text-lg text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}
                            </p>
                        </div>
                        <x-heroicon-o-calendar-days class="w-6 h-6 text-green-600 dark:text-green-300" />
                    </div>
                </div>

                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 shadow-sm border border-purple-100 dark:border-purple-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-purple-700 dark:text-purple-300">Saldo Akhir</p>
                            <p class="font-bold text-xl text-purple-900 dark:text-purple-100">
                                Rp {{ number_format(collect($transactions)->last()['balance'] ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        <x-heroicon-o-chart-bar class="w-6 h-6 text-purple-600 dark:text-purple-300" />
                    </div>
                </div>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-xl mt-6">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Tanggal</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Deskripsi</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Debit</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Kredit</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($transactions as $txn)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($txn['date'])->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                                    {{ $txn['description'] }}
                                </td>
                                <td class="px-4 py-2 text-right text-green-700 dark:text-green-400">
                                    {{ $txn['debit'] ? 'Rp ' . number_format($txn['debit'], 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-4 py-2 text-right text-red-700 dark:text-red-400">
                                    {{ $txn['credit'] ? 'Rp ' . number_format($txn['credit'], 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-4 py-2 text-right font-semibold text-gray-900 dark:text-white">
                                    Rp {{ number_format($txn['balance'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-filament::page>