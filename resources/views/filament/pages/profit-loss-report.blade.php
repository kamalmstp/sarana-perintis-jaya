<x-filament::page>
    <div class="space-y-6">

        {{-- Filter Tanggal --}}
        <x-filament::card>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Dari Tanggal</label>
                    <input
                        type="date"
                        wire:model.defer="startDate"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    />
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input
                        type="date"
                        wire:model.defer="endDate"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    />
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <x-filament::button wire:click="generateReport" icon="heroicon-o-funnel">
                    Terapkan Filter
                </x-filament::button>
            </div>
        </x-filament::card>

        {{-- Pendapatan --}}
        <x-filament::card>
            <x-slot name="header">
                <h2 class="text-lg font-semibold text-gray-800">Pendapatan</h2>
            </x-slot>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b">
                        <tr>
                            <th class="py-2 px-3">Kode</th>
                            <th class="py-2 px-3">Nama Akun</th>
                            <th class="py-2 px-3 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($revenues as $account)
                            <tr>
                                <td class="py-2 px-3">{{ $account['code'] }}</td>
                                <td class="py-2 px-3">{{ $account['name'] }}</td>
                                <td class="py-2 px-3 text-right text-green-600">
                                    Rp. {{ number_format($account['amount'], 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-semibold border-t border-gray-200">
                            <td colspan="2" class="py-2 px-3 text-right">Total Pendapatan</td>
                            <td class="py-2 px-3 text-right text-green-700">
                                Rp. {{ number_format($totalRevenue, 2, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::card>

        {{-- Biaya --}}
        <x-filament::card>
            <x-slot name="header">
                <h2 class="text-lg font-semibold text-gray-800">Biaya</h2>
            </x-slot>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b">
                        <tr>
                            <th class="py-2 px-3">Kode</th>
                            <th class="py-2 px-3">Nama Akun</th>
                            <th class="py-2 px-3 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $account)
                            <tr>
                                <td class="py-2 px-3">{{ $account['code'] }}</td>
                                <td class="py-2 px-3">{{ $account['name'] }}</td>
                                <td class="py-2 px-3 text-right text-red-600">
                                    Rp. {{ number_format($account['amount'], 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-semibold border-t border-gray-200">
                            <td colspan="2" class="py-2 px-3 text-right">Total Biaya</td>
                            <td class="py-2 px-3 text-right text-red-700">
                                Rp. {{ number_format($totalExpense, 2, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::card>

        {{-- Laba Bersih --}}
        <x-filament::card>
            <div class="text-center text-lg font-bold">
                Laba Bersih:
                <span class="{{ $netProfit >= 0 ? 'text-green-700' : 'text-red-700' }}">
                    Rp. {{ number_format($netProfit, 2, ',', '.') }}
                </span>
            </div>
        </x-filament::card>
    </div>
</x-filament::page>