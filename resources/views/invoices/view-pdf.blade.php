<x-filament::page>
    <x-filament::card>
        {{-- Form detail invoice --}}
        {{ $this->form }}

        {{-- PDF Preview --}}
        @php
            $invoice = $this->record;
            $pdfUrl = $invoice->pdf_path
                ? Storage::url($invoice->pdf_path)
                : route('invoices.pdf.preview', $invoice);
        @endphp

        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">Preview PDF</h2>
            <iframe src="{{ $pdfUrl }}" style="width: 100%; height: 800px; border: none;"></iframe>
        </div>
    </x-filament::card>
</x-filament::page>