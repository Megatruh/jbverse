{{-- resources/views/admin/permintaan.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div>
        <h2 class="font-bold text-2xl text-gray-900">Permintaan Akun Pengusaha</h2>
        <p class="text-sm text-gray-500">Tinjau bukti evidence dan setujui pendaftaran baru.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-bold">
                <tr>
                    <th class="px-6 py-4">Nama Pendaftar</th>
                    <th class="px-6 py-4">Nama Toko</th>
                    <th class="px-6 py-4">Kontak</th>
                    <th class="px-6 py-4">Evidence</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($pendingUmkms as $user)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->umkm->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            @php
                                $contactNumber = optional($user->umkm)->contact_number;
                                $waNumber = $contactNumber
                                    ? '62' . ltrim(preg_replace('/[^0-9]/', '', $contactNumber), '0')
                                    : '';
                            @endphp
                            @if ($contactNumber)
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank"
                                    class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 font-medium hover:underline transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.117 1.528 5.845L.057 23.882a.75.75 0 00.918.943l6.188-1.462A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22.5c-1.948 0-3.772-.524-5.34-1.438l-.372-.215-3.886.918.952-3.777-.234-.385A10.46 10.46 0 011.5 12C1.5 6.21 6.21 1.5 12 1.5S22.5 6.21 22.5 12 17.79 22.5 12 22.5z"/>
                                    </svg>
                                    {{ $contactNumber }}
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($user->umkm->image_banner)
                                <button type="button"
                                    onclick="openEvidenceModal('{{ asset('storage/' . $user->umkm->image_banner) }}', '{{ $user->umkm->name }}')"
                                    class="inline-flex items-center gap-1.5 text-indigo-600 font-semibold hover:text-indigo-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Bukti
                                </button>
                            @else
                                <span class="text-gray-400 text-xs italic">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition">
                                    Setujui (ACC)
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">Tidak ada permintaan pendaftaran baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Evidence Modal --}}
<div id="evidence-modal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center p-4"
    role="dialog" aria-modal="true" aria-labelledby="modal-title">

    {{-- Backdrop --}}
    <div id="evidence-backdrop"
        class="absolute inset-0 bg-black/60 backdrop-blur-sm"
        onclick="closeEvidenceModal()"></div>

    {{-- Modal Card --}}
    <div class="relative z-10 bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Bukti Gerai</p>
                <h3 id="modal-title" class="text-base font-bold text-gray-900 mt-0.5"></h3>
            </div>
            <button type="button" onclick="closeEvidenceModal()"
                class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-1.5 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Image --}}
        <div class="p-4 bg-gray-50">
            <img id="evidence-img" src="" alt="Evidence"
                class="w-full max-h-96 object-contain rounded-xl border border-gray-200 bg-white" />
        </div>

        {{-- Footer --}}
        <div class="px-5 py-3 border-t border-gray-100 flex justify-end">
            <a id="evidence-download" href="#" target="_blank"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Buka di tab baru
            </a>
        </div>
    </div>
</div>

<script>
    function openEvidenceModal(imageUrl, tokoName) {
        document.getElementById('evidence-img').src = imageUrl;
        document.getElementById('evidence-download').href = imageUrl;
        document.getElementById('modal-title').textContent = tokoName;

        const modal = document.getElementById('evidence-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeEvidenceModal() {
        const modal = document.getElementById('evidence-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';

        // Reset image src after close animation
        setTimeout(() => {
            document.getElementById('evidence-img').src = '';
        }, 150);
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeEvidenceModal();
    });
</script>
@endsection