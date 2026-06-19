@extends('Layout.admin.app')

@section('title', 'Katalog')

@section('content')
<section class="bg-white py-12">
    <div class="max-w-8xl px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <h1 class="text-3xl font-bold text-green-700">Produk RePonik</h1>

            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('katalog.index') }}" class="relative w-full max-w-xs">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    class="w-full border border-green-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                <i data-feather="search" class="absolute left-3 top-2.5 w-5 h-5 text-green-600"></i>
            </form>
        </div>

        <!-- Produk Aktif -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach ($produkAktif as $produk)
                @include('Layout.admin.components.katalog-card', ['produk' => $produk])
            @endforeach

            <!-- Tambah Produk -->
            <a href="{{ route('katalog.create') }}" class="flex items-center justify-center bg-white border-2 border-dashed border-green-300 rounded-xl hover:border-green-500 hover:bg-green-50 transition h-48">
                <div class="text-center text-green-600">
                    <i data-feather="plus-circle" class="w-10 h-10 mx-auto mb-2"></i>
                    <span class="font-medium">Tambah Produk Baru</span>
                </div>
            </a>
        </div>

        <!-- Produk Non-Aktif -->
        <div class="mt-6">
            <button id="toggleProdukNonBtn" class="flex items-center text-green-700 font-semibold text-lg mb-4 focus:outline-none hover:text-green-800 transition">
                <span>Lihat Produk Non-Aktif</span>
                <i id="chevronIcon" data-feather="chevron-down" class="ml-2 transition-transform duration-300"></i>
            </button>

            <div id="nonaktifList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                @forelse ($produkNonAktif as $produk)
                    @include('Layout.admin.components.katalog-card', ['produk' => $produk])
                @empty
                    <p class="text-gray-500 col-span-full">Tidak ada produk non-aktif.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            feather.replace();

            const toggleBtn = document.getElementById('toggleProdukNonBtn');
            const list = document.getElementById('nonaktifList');
            const chevron = document.getElementById('chevronIcon');

            toggleBtn.addEventListener('click', () => {
                list.classList.toggle('hidden');
                chevron.classList.toggle('rotate-180');
            });
        });
    </script>
</section>
@endsection
