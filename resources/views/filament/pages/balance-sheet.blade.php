<x-filament::page>
    <form wire:submit.prevent="loadData">
        {{ $this->form }}
        <div class="mt-4">
            <x-filament::button type="submit">Tampilkan</x-filament::button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
        <div>
            <h2 class="text-xl font-bold mb-2">Aktiva</h2>
            <x-filament::card>
                @foreach ($assets as $item)
                    <div class="flex justify-between py-1 border-b">
                        <span>{{ $item->name }}</span>
                        <span class="text-right">{{ number_format($item->balance, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </x-filament::card>
        </div>

        <div>
            <h2 class="text-xl font-bold mb-2">Kewajiban</h2>
            <x-filament::card>
                @foreach ($liabilities as $item)
                    <div class="flex justify-between py-1 border-b">
                        <span>{{ $item->name }}</span>
                        <span class="text-right">{{ number_format($item->balance, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </x-filament::card>

            <h2 class="text-xl font-bold mt-4 mb-2">Ekuitas</h2>
            <x-filament::card>
                @foreach ($equity as $item)
                    <div class="flex justify-between py-1 border-b">
                        <span>{{ $item->name }}</span>
                        <span class="text-right">{{ number_format($item->balance, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </x-filament::card>
        </div>
    </div>
</x-filament::page>