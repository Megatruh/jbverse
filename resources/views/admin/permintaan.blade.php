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
                    <th class="px-6 py-4">Evidence</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($pendingUmkms as $user)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->umkm->name }}</td>
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