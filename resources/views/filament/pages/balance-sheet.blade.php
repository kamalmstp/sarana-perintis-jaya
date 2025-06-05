<x-filament::page>
    <div class="space-y-4">
        <div class="flex items-center gap-4">
            {{ $this->form }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Assets --}}
            <div>
                <x-filament::card>
                    <x-slot name="header">
                        <h2 class="text-lg font-bold">Aset</h2>
                    </x-slot>
                    <table class="w-full text-sm">
                        @foreach ($assets as $asset)
                            <tr class="border-t">
                                <td class="py-1 text-gray-700">{{ $asset->code }} - {{ $asset->name }}</td>
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

            {{-- Liabilities --}}
            <div>
                <x-filament::card>
                    <x-slot name="header">
                        <h2 class="text-lg font-bold">Liabilitas</h2>
                    </x-slot>
                    <table class="w-full text-sm">
                        @foreach ($liabilities as $liability)
                            <tr class="border-t">
                                <td class="py-1 text-gray-700">{{ $liability->code }} - {{ $liability->name }}</td>
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

            {{-- Equity --}}
            <div>
                <x-filament::card>
                    <x-slot name="header">
                        <h2 class="text-lg font-bold">Ekuitas</h2>
                    </x-slot>
                    <table class="w-full text-sm">
                        @foreach ($equity as $eq)
                            <tr class="border-t">
                                <td class="py-1 text-gray-700">{{ $eq->code }} - {{ $eq->name }}</td>
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

        {{-- Total Liabilitas + Ekuitas --}}
        <x-filament::card class="mt-4">
            <table class="w-full text-sm font-semibold">
                <tr class="border-t text-gray-700">
                    <td class="py-2">Total Liabilitas + Ekuitas</td>
                    <td class="py-2 text-right">
                        Rp {{
                            number_format(
                                collect($liabilities)->sum('balance') + collect($equity)->sum('balance'),
                                0, ',', '.'
                            )
                        }}
                    </td>
                </tr>
            </table>
        </x-filament::card>
    </div>
</x-filament::page>