<x-filament::page>
    {{-- Filter Tanggal --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-4 space-y-4 sm:space-y-0 mb-6">
        <div class="space-y-2 w-full sm:w-1/2">
            <label for="startDate" class="text-sm font-medium text-gray-700">Dari Tanggal</label>
            <input
                type="date"
                id="startDate"
                wire:model="startDate"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500"
            />
        </div>

        <div class="space-y-2 w-full sm:w-1/2">
            <label for="endDate" class="text-sm font-medium text-gray-700">Sampai Tanggal</label>
            <input
                type="date"
                id="endDate"
                wire:model="endDate"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500"
            />
        </div>
    </div>

    {{-- Pendapatan --}}
    <x-filament::section heading="Pendapatan">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100 font-semibold">
                    <tr>
                        <th class="p-3 border-b">Akun</th>
                        <th class="p-3 text-right border-b">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($revenues as $rev)
                        <tr>
                            <td class="p-3 border-b">{{ $rev['name'] }}</td>
                            <td class="p-3 text-right border-b">Rp {{ number_format($rev['amount'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="p-3 text-center text-gray-500">Tidak ada data pendapatan</td>
                        </tr>
                    @endforelse
                    <tr class="font-bold bg-gray-50">
                        <td class="p-3 border-t">Total Pendapatan</td>
                        <td class="p-3 text-right border-t">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-filament::section>

    {{-- Biaya --}}
    <x-filament::section heading="Biaya" class="mt-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100 font-semibold">
                    <tr>
                        <th class="p-3 border-b">Akun</th>
                        <th class="p-3 text-right border-b">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($expenses as $exp)
                        <tr>
                            <td class="p-3 border-b">{{ $exp['name'] }}</td>
                            <td class="p-3 text-right border-b">Rp {{ number_format($exp['amount'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="p-3 text-center text-gray-500">Tidak ada data biaya</td>
                        </tr>
                    @endforelse
                    <tr class="font-bold bg-gray-50">
                        <td class="p-3 border-t">Total Biaya</td>
                        <td class="p-3 text-right border-t">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-filament::section>

    {{-- Laba Bersih --}}
    <div class="mt-8 text-right text-lg font-bold">
        Laba Bersih:
        <span class="{{ $netProfit < 0 ? 'text-red-600' : 'text-green-600' }}">
            Rp {{ number_format($netProfit, 0, ',', '.') }}
        </span>
    </div>
</x-filament::page>