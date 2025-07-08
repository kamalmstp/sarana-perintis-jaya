@php
    $files = $getRecord()->files;
@endphp

@if ($files->count())
    <ul class="space-y-2">
        @foreach ($files as $file)
            <li class="flex justify-between items-center p-2 bg-gray-50 border rounded-md shadow-sm">
                {{-- 🔹 Jenis Dokumen sebagai Badge + Link --}}
                <a href="{{ Storage::disk('public')->url($file->file_path) }}"
                   target="_blank"
                   title="Lihat File"
                   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                          {{ match($file->file_type) {
                                'spk' => 'bg-green-100 text-green-800',
                                'surat_jalan' => 'bg-blue-100 text-blue-800',
                                default => 'bg-gray-100 text-gray-800'
                          } }}">
                    {{ strtoupper($file->file_type) }}
                </a>

                {{-- 🗑️ Tombol Delete --}}
                <form method="POST" action="{{ route('filament.resources.files.destroy', $file) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Yakin ingin menghapus file ini?')"
                            title="Hapus File"
                            class="text-red-600 hover:text-red-700">
                        <x-heroicon-o-trash class="w-5 h-5"/>
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-sm text-gray-500">Belum ada file yang diunggah.</p>
@endif