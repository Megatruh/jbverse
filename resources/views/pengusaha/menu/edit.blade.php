<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Edit Menu
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900">
					<form action="{{ route('pengusaha.menu.update', $menu) }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')

						<div class="border-b border-gray-200 pb-6 mb-6">
							<h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Dasar</h3>
                            
							<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
								<div>
									<x-input-label for="name" value="Nama Makanan/Minuman Utama" />
									<x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required value="{{ old('name', $menu->name) }}" />
								</div>
                                
								<div>
									<x-input-label for="category" value="Kategori" />
									<x-text-input id="category" name="category" type="text" class="mt-1 block w-full" required value="{{ old('category', $menu->category) }}" />
								</div>
							</div>

							<div class="mt-4">
								<x-input-label for="description" value="Deskripsi Menu (Opsional)" />
								<textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description', $menu->description) }}</textarea>
							</div>

							<div class="mt-4">
								<x-input-label for="image" value="Foto Menu (Opsional, Maks 2MB)" />
								<input type="file" id="image" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
								@if ($menu->image)
									<p class="mt-2 text-sm text-gray-500">Gambar saat ini:</p>
									<img src="{{ asset('storage/' . $menu->image) }}" alt="" class="mt-2 h-24 w-24 object-cover rounded border border-gray-200">
								@endif
							</div>
						</div>

						<div>
							<h3 class="text-lg font-bold text-gray-900 mb-4">Detail Varian & Harga</h3>

							<div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
								<div>
									<label class="block font-medium text-sm text-gray-700">Ukuran</label>
									<input type="text" name="ukuran" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required value="{{ old('ukuran', $menu->ukuran) }}">
								</div>

								<div>
									<label class="block font-medium text-sm text-gray-700">Varian / Rasa</label>
									<input type="text" name="variant" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required value="{{ old('variant', $menu->variant) }}">
								</div>

								<div>
									<label class="block font-medium text-sm text-gray-700">Harga (Rp)</label>
									<input type="number" name="price" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" min="0" required value="{{ old('price', $menu->price) }}">
								</div>
							</div>
						</div>

						<div class="flex items-center justify-end mt-8 gap-4 border-t border-gray-200 pt-4">
							<a href="{{ route('pengusaha.menu.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
							<x-primary-button>Update Menu</x-primary-button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
