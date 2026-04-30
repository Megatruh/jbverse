{{-- <a
    href="{{ route('pengusaha.edit') }}"
    class="inline-flex items-center justify-center rounded-md bg-white/15 px-3 py-2 text-sm font-medium text-white ring-1 ring-inset ring-white/25 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/40"
>
    Edit Profil UMKM
</a> --}}
<x-app-layout>
	<x-slot name="header">
		<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Pengusaha</h2>
				<p class="mt-1 text-sm text-gray-500">
					Kelola profil toko, pantau ringkasan performa, dan cek aktivitas terbaru.
				</p>
			</div>

			<div class="flex flex-wrap items-center gap-2">
				<a
					href="{{ route('beranda') }}"
					class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
				>
					Lihat Katalog
				</a>

				<a
					href="{{ route('toko.detail', $umkm) }}"
					class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
				>
					Lihat Halaman Toko
				</a>
			</div>
		</div>
	</x-slot>

	{{-- @php
		$bannerUrl = !empty($umkm->image_banner)
			? asset('storage/' . ltrim($umkm->image_banner, '/'))
			: null;

		$waNumber = preg_replace('/\D+/', '', (string) ($umkm->contact_number ?? ''));
		$waLink = !empty($waNumber) ? ('https://wa.me/' . $waNumber) : null;

		$avgRatingPretty = isset($avgRating) && $avgRating !== null
			? number_format((float) $avgRating, 1)
			: '—';
	@endphp --}}
    @php
		$bannerUrl = !empty($umkm->image_banner)
			? asset('storage/' . ltrim($umkm->image_banner, '/'))
			: null;

        // Tambahkan Logika Logo di Sini
		$logoUrl = !empty($umkm->logo)
			? asset('storage/' . ltrim($umkm->logo, '/'))
			: 'https://ui-avatars.com/api/?name=' . urlencode($umkm->name) . '&color=4F46E5&background=EEF2FF&size=128';

		$waNumber = preg_replace('/\D+/', '', (string) ($umkm->contact_number ?? ''));
		$waLink = !empty($waNumber) ? ('https://wa.me/' . $waNumber) : null;

		$avgRatingPretty = isset($avgRating) && $avgRating !== null
			? number_format((float) $avgRating, 1)
			: '—';
	@endphp

	<div class="py-10">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			@if (session('status'))
				<div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
					{{ session('status') }}
				</div>
			@endif

			<div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
				<div class="relative">
					<div class="h-44 sm:h-56 bg-gradient-to-r from-indigo-600 to-sky-500">
						@if ($bannerUrl)
							<img
								src="{{ $bannerUrl }}"
								alt="Banner toko"
								class="h-full w-full object-cover"
								loading="lazy"
							/>
						@endif
					</div>

					<div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>

					{{-- <div class="absolute bottom-0 left-0 right-0">
						<div class="px-6 py-5">
							<div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
								<div>
									<p class="text-sm text-white/80">Selamat datang,</p>
									<h3 class="mt-1 text-2xl sm:text-3xl font-semibold tracking-tight text-white">
										{{ $umkm->name }}
									</h3>
									<div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-white/85">
										<span class="inline-flex items-center rounded-full bg-white/15 px-2.5 py-1">
											Pemilik: <span class="ml-1 font-medium text-white">{{ $user->name }}</span>
										</span>

										<span class="inline-flex items-center rounded-full bg-white/15 px-2.5 py-1">
											Status akun:
											<span class="ml-1 font-medium text-white">{{ strtoupper($user->status ?? 'approved') }}</span>
										</span>

										<span class="inline-flex items-center rounded-full bg-white/15 px-2.5 py-1">
											Toko:
											@if ($umkm->is_open)
												<span class="ml-1 font-medium text-emerald-200">Buka</span>
											@else
												<span class="ml-1 font-medium text-amber-200">Tutup</span>
											@endif
										</span>
									</div>
								</div>

								<div class="flex flex-wrap items-center gap-2">
									<a
										href="{{ route('pengusaha.edit') }}"
										class="inline-flex items-center justify-center rounded-md bg-white/15 px-3 py-2 text-sm font-medium text-white ring-1 ring-inset ring-white/25 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/40"
									>
										Edit Profil UMKM
									</a>

									@if ($waLink)
										<a
											href="{{ $waLink }}"
											target="_blank"
											rel="noopener noreferrer"
											class="inline-flex items-center justify-center rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-900 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-white/40"
										>
											Hubungi via WhatsApp
										</a>
									@endif
								</div>
							</div>
						</div>
					</div> --}}
                    <div class="absolute bottom-0 left-0 right-0">
						<div class="px-6 py-5">
							<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
								
                                <div class="flex items-center gap-4">
                                    <div class="shrink-0">
                                        <img 
                                            src="{{ $logoUrl }}" 
                                            alt="Logo {{ $umkm->name }}" 
                                            class="h-16 w-16 sm:h-20 sm:w-20 rounded-full object-cover border-2 border-white shadow-lg bg-white"
                                        />
                                    </div>

                                    <div>
										<p class="text-sm font-medium text-white/90 drop-shadow-sm">Selamat datang,</p>
										<h3 class="mt-1 text-2xl sm:text-3xl font-bold tracking-tight text-white drop-shadow-md">
											{{ $umkm->name }}
										</h3>
										<div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-white/90 drop-shadow-sm">
											<span class="inline-flex items-center rounded-full bg-black/30 backdrop-blur-sm px-2.5 py-1 border border-white/10">
												Pemilik: <span class="ml-1 font-medium text-white">{{ $user->name }}</span>
											</span>

											<span class="inline-flex items-center rounded-full bg-black/30 backdrop-blur-sm px-2.5 py-1 border border-white/10">
												Status akun:
												<span class="ml-1 font-medium text-white">{{ strtoupper($user->status ?? 'approved') }}</span>
											</span>

											<span class="inline-flex items-center rounded-full bg-black/30 backdrop-blur-sm px-2.5 py-1 border border-white/10">
												Toko:
												@if ($umkm->is_open)
													<span class="ml-1 font-medium text-emerald-300">Buka</span>
												@else
													<span class="ml-1 font-medium text-amber-300">Tutup</span>
												@endif
											</span>
										</div>
									</div>
								</div>
                                <div class="flex flex-wrap items-center gap-2 mt-4 sm:mt-0">
									<a
										href="{{ route('pengusaha.edit') }}"
										class="inline-flex items-center justify-center rounded-md bg-white/20 backdrop-blur-sm px-3 py-2 text-sm font-medium text-white ring-1 ring-inset ring-white/30 hover:bg-white/30 transition-all focus:outline-none focus:ring-2 focus:ring-white/50 shadow-sm"
									>
										Edit Profil UMKM
									</a>

									@if ($waLink)
										<a
											href="{{ $waLink }}"
											target="_blank"
											rel="noopener noreferrer"
											class="inline-flex items-center justify-center rounded-md bg-white px-3 py-2 text-sm font-bold text-gray-900 shadow-lg hover:bg-gray-50 transition-all focus:outline-none focus:ring-2 focus:ring-white/50"
										>
											WhatsApp
										</a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="px-6 py-6">
					<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
						<div class="lg:col-span-2">
							<h4 class="text-base font-semibold text-gray-900">Ringkasan Toko</h4>
							<p class="mt-1 text-sm text-gray-500">Informasi ini tampil di halaman publik tokomu.</p>

							<dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
								<div class="rounded-lg border border-gray-200 p-4">
									<dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Slug</dt>
									<dd class="mt-1 text-sm font-semibold text-gray-900">{{ $umkm->slug }}</dd>
								</div>
								<div class="rounded-lg border border-gray-200 p-4">
									<dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Kontak</dt>
									<dd class="mt-1 text-sm font-semibold text-gray-900">{{ $umkm->contact_number }}</dd>
								</div>
								<div class="rounded-lg border border-gray-200 p-4 sm:col-span-2">
									<dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Deskripsi</dt>
									<dd class="mt-1 text-sm text-gray-700 leading-relaxed">
										{{ $umkm->description }}
									</dd>
								</div>
							</dl>
						</div>

						<div class="rounded-lg border border-indigo-100 bg-indigo-50/60 p-4">
							<h4 class="text-base font-semibold text-indigo-900">Aksi Cepat</h4>
							<p class="mt-1 text-sm text-indigo-800/80">Beberapa fitur akan muncul saat route sudah dibuat.</p>

							<div class="mt-4 grid gap-2">
								<div
									class="flex items-center justify-between rounded-md bg-white/70 px-3 py-2 text-sm font-medium text-gray-400 ring-1 ring-inset ring-gray-200"
									title="Fitur pengelolaan menu belum tersedia"
								>
									Kelola Menu
									<span>—</span>
								</div>

								<a
									href="{{ route('toko.detail', $umkm) }}"
									class="inline-flex items-center justify-between rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm ring-1 ring-inset ring-gray-200 hover:bg-gray-50"
								>
									Preview Halaman Toko
									<span class="text-gray-400">→</span>
								</a>

								<form method="POST" action="{{ route('logout') }}" class="mt-2">
									@csrf
									<button
										type="submit"
										class="w-full inline-flex items-center justify-center rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-200 hover:bg-gray-50"
									>
										Logout
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
				<div class="bg-white shadow-sm sm:rounded-lg p-5">
					<p class="text-sm font-medium text-gray-500">Total Menu</p>
					<p class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">{{ (int) ($menusCount ?? 0) }}</p>
					<p class="mt-1 text-xs text-gray-500">Menu yang terdaftar pada tokomu</p>
				</div>
				<div class="bg-white shadow-sm sm:rounded-lg p-5">
					<p class="text-sm font-medium text-gray-500">Total Ulasan</p>
					<p class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">{{ (int) ($reviewsCount ?? 0) }}</p>
					<p class="mt-1 text-xs text-gray-500">Ulasan dari pelanggan</p>
				</div>
				<div class="bg-white shadow-sm sm:rounded-lg p-5">
					<p class="text-sm font-medium text-gray-500">Rating Rata-rata</p>
					<div class="mt-2 flex items-baseline gap-2">
						<p class="text-3xl font-semibold tracking-tight text-gray-900">{{ $avgRatingPretty }}</p>
						<p class="text-sm text-gray-500">/ 5</p>
					</div>
					<p class="mt-1 text-xs text-gray-500">Berdasarkan semua ulasan</p>
				</div>
				<div class="bg-white shadow-sm sm:rounded-lg p-5">
					<p class="text-sm font-medium text-gray-500">Status Toko</p>
					<div class="mt-2">
						@if ($umkm->is_open)
							<span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Buka</span>
						@else
							<span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-sm font-semibold text-amber-700 ring-1 ring-inset ring-amber-200">Tutup</span>
						@endif
					</div>
					<form method="POST" action="{{ route('pengusaha.toggle_status') }}" class="mt-3">
						@csrf
						@method('PATCH')
						<button
							type="submit"
							class="w-full inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
						>
							{{ $umkm->is_open ? 'Tutup Toko' : 'Buka Toko' }}
						</button>
					</form>
				</div>
			</div>

			<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
				<div class="bg-white shadow-sm sm:rounded-lg">
					<div class="border-b border-gray-100 px-6 py-4">
						<h3 class="text-base font-semibold text-gray-900">Menu Terbaru</h3>
						<p class="mt-1 text-sm text-gray-500">5 menu terakhir yang dibuat.</p>
					</div>

					<div class="px-6 py-4">
						@if (!empty($latestMenus) && count($latestMenus) > 0)
							<ul role="list" class="divide-y divide-gray-100">
								@foreach ($latestMenus as $menu)
									<li class="py-3">
										<div class="flex items-start justify-between gap-4">
											<div>
												<p class="text-sm font-semibold text-gray-900">{{ $menu->name }}</p>
												<p class="mt-1 text-xs text-gray-500">
													Kategori: <span class="font-medium text-gray-700">{{ $menu->category }}</span>
													<span class="mx-1">•</span>
													Dibuat: {{ optional($menu->created_at)->diffForHumans() }}
												</p>
											</div>

											<a
												href="{{ route('menu.detail', ['umkm' => $umkm, 'menu' => $menu]) }}"
												class="shrink-0 text-sm font-medium text-indigo-600 hover:text-indigo-700"
											>
												Lihat
											</a>
										</div>
									</li>
								@endforeach
							</ul>
						@else
							<div class="rounded-lg border border-dashed border-gray-200 p-6 text-center">
								<p class="text-sm font-medium text-gray-900">Belum ada menu</p>
								<p class="mt-1 text-sm text-gray-500">Saat menu sudah ditambahkan, daftar terbaru akan muncul di sini.</p>
							</div>
						@endif
					</div>
				</div>

				<div class="bg-white shadow-sm sm:rounded-lg">
					<div class="border-b border-gray-100 px-6 py-4">
						<h3 class="text-base font-semibold text-gray-900">Ulasan Terbaru</h3>
						<p class="mt-1 text-sm text-gray-500">Ulasan pelanggan terbaru untuk menu tokomu.</p>
					</div>

					<div class="px-6 py-4">
						@if (!empty($latestReviews) && count($latestReviews) > 0)
							<ul role="list" class="divide-y divide-gray-100">
								@foreach ($latestReviews as $review)
									<li class="py-3">
										<div class="flex items-start justify-between gap-4">
											<div class="min-w-0">
												<p class="text-sm font-semibold text-gray-900 truncate">
													{{ optional($review->user)->name ?? 'Pelanggan' }}
													<span class="font-normal text-gray-500">menilai</span>
													<span class="font-semibold">{{ optional($review->menu)->name ?? 'Menu' }}</span>
												</p>

												<div class="mt-1 flex items-center gap-2">
													<div class="flex items-center">
														@for ($i = 1; $i <= 5; $i++)
															@php $filled = (int) ($review->rating ?? 0) >= $i; @endphp
															<svg class="h-4 w-4 {{ $filled ? 'text-yellow-400' : 'text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
																<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.962a1 1 0 00.95.69h4.166c.969 0 1.371 1.24.588 1.81l-3.37 2.449a1 1 0 00-.364 1.118l1.287 3.962c.3.921-.755 1.688-1.54 1.118l-3.37-2.449a1 1 0 00-1.175 0l-3.37 2.449c-.784.57-1.838-.197-1.539-1.118l1.287-3.962a1 1 0 00-.364-1.118L2.045 9.389c-.783-.57-.38-1.81.588-1.81h4.166a1 1 0 00.95-.69l1.286-3.962z" />
															</svg>
														@endfor
													</div>

													<p class="text-xs text-gray-500">{{ optional($review->created_at)->diffForHumans() }}</p>
												</div>

												<p class="mt-2 text-sm text-gray-700 line-clamp-2">
													{{ $review->comment }}
												</p>
											</div>
										</div>
									</li>
								@endforeach
							</ul>
						@else
							<div class="rounded-lg border border-dashed border-gray-200 p-6 text-center">
								<p class="text-sm font-medium text-gray-900">Belum ada ulasan</p>
								<p class="mt-1 text-sm text-gray-500">Saat pelanggan memberi ulasan, daftar terbaru akan muncul di sini.</p>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>