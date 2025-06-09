<x-filament::page>
    <div class="space-y-4">
        {{-- Filter Form --}}
        <form wire:submit.prevent="generateReport" class="flex flex-col md:flex-row md:items-end gap-4">
            {{ $this->form }}

            <x-filament::button type="submit">
                Filter
            </x-filament::button>
        </form>

        {{-- Neraca: Aset, Liabilitas, Ekuitas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Aset --}}
            <div>
                <x-filament::card>
                    <x-slot name="header">
                        <h2 class="text-lg font-bold flex items-center gap-2">
                            <x-heroicon-o-banknotes class="w-5 h-5 text-primary-500" />
                            Aset
                        </h2>
                    </x-slot>
                    <table class="w-full text-sm">
                        @foreach ($assets as $asset)
                            <tr class="border-t">
                                <td class="py-1 text-gray-700">
                                    {{ $asset->code }} - {{ $asset->name }}
                                </td>
                                <td class="py-1 text-right text-gray-800 font-medium">
                                    Rp {{ number_format($asset->balance, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="border-t font-bold">
                            <td class="py-2">Total Aset</td>
                            <td class="py-2 text-right">
                                Rp {{ number_format(collect($assets)->sum('balance'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </x-filament::card>
            </div>

            {{-- Liabilitas --}}
            <div>
                <x-filament::card>
                    <x-slot name="header">
                        <h2 class="text-lg font-bold flex items-center gap-2">
                            <x-heroicon-o-scale class="w-5 h-5 text-danger-500" />
                            Liabilitas
                        </h2>
                    </x-slot>
                    <table class="w-full text-sm">
                        @foreach ($liabilities as $liability)
                            <tr class="border-t">
                                <td class="py-1 text-gray-700">
                                    {{ $liability->code }} - {{ $liability->name }}
                                </td>
                                <td class="py-1 text-right text-gray-800 font-medium">
                                    Rp {{ number_format($liability->balance, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="border-t font-bold">
                            <td class="py-2">Total Liabilitas</td>
                            <td class="py-2 text-right">
                                Rp {{ number_format(collect($liabilities)->sum('balance'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </x-filament::card>
            </div>

            {{-- Ekuitas --}}
            <div>
                <x-filament::card>
                    <x-slot name="header">
                        <h2 class="text-lg font-bold flex items-center gap-2">
                            <x-heroicon-o-user-group class="w-5 h-5 text-warning-500" />
                            Ekuitas
                        </h2>
                    </x-slot>
                    <table class="w-full text-sm">
                        @foreach ($equity as $eq)
                            <tr class="border-t">
                                <td class="py-1 text-gray-700">
                                    {{ $eq->code }} - {{ $eq->name }}
                                </td>
                                <td class="py-1 text-right text-gray-800 font-medium">
                                    Rp {{ number_format($eq->balance, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="border-t font-bold">
                            <td class="py-2">Total Ekuitas</td>
                            <td class="py-2 text-right">
                                Rp {{ number_format(collect($equity)->sum('balance'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </x-filament::card>
            </div>
        </div>

        {{-- Ringkasan Total --}}
        <x-filament::card class="mt-4">
            <div class="flex flex-col md:flex-row justify-between text-sm font-semibold text-gray-700 space-y-2 md:space-y-0">
                <div>
                    Total Aset:
                    <span class="text-gray-900">
                        Rp {{ number_format(collect($assets)->sum('balance'), 0, ',', '.') }}
                    </span>
                </div>
                <div>
                    Total Liabilitas + Ekuitas:
                    <span class="text-gray-900">
                        Rp {{ number_format(collect($liabilities)->sum('balance') + collect($equity)->sum('balance'), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </x-filament::card>
    </div>
</x-filament::page>