@extends('Layout.pelanggan.app')

@section('content')

<section class="max-w-6xl mx-auto mt-6 px-4 space-y-6">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

    <!-- Header: Nama dan Total Ember -->
    <div class="flex flex-wrap justify-between items-center bg-green-600 text-white rounded-2xl px-8 py-6 shadow-lg">
        <!-- Nama -->
        <div>
            <h2 class="text-lg sm:text-xl font-semibold">
                Halo, {{ $pelanggan->nama_lengkap }} 👋
            </h2>
            <p class="text-sm text-green-100">Selamat datang kembali!</p>
        </div>

        <!-- Total Ember -->
        <div class="flex items-center gap-4 mt-4 sm:mt-0">
            <img src="{{ asset('img/trash.png') }}" alt="Icon total poin" class="w-12 h-12 drop-shadow" />
            <div>
                <p class="text-sm font-medium mb-1 text-green-100">Total Ember</p>
                <p class="text-3xl sm:text-4xl font-extrabold leading-none">{{ $totalEmber }}</p>
            </div>
        </div>
    </div>

    <!-- Reward List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($reward as $item)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-transform duration-300 hover:scale-[1.03] overflow-hidden group ring-1 ring-gray-200 flex flex-col justify-between">
            <div>
                <img src="{{ asset('img/' . $item['gambar']) }}" alt="{{ $item['nama'] }}"
                    class="w-full h-52 object-contain bg-white p-4">
                <div class="p-4">
                    <h3 class="text-md font-semibold text-gray-800 mb-1">{{ $item['nama'] }}</h3>
                    <div class="flex items-center text-gray-600 text-sm mb-3">
                        <span class="font-bold text-green-700">{{ $item['jumlah_ember_harga'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Tombol Tukar -->
            <div class="p-4 pt-0">
                <form action="{{ route('reward.tukar', $item->reward_id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-green-600 text-white font-semibold py-2 rounded-xl hover:bg-green-700 transition">
                        Tukar
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection
