@extends('layout.Pelanggan.app')

@section('content')

<section class="max-w-6xl mx-auto mt-8 px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Riwayat Reward Kamu</h1>

    @if($riwayatreward->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg shadow-md">
            Kamu belum pernah menukar reward apapun.
        </div>
    @else
        <div class="space-y-6">
            @foreach($riwayatreward as $item)
            <div class="flex bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <!-- Gambar reward -->
                <div class="flex-shrink-0 w-32 h-32 bg-gray-50 flex items-center justify-center p-4">
                    <img src="{{ asset('img/' . $item->reward->gambar) }}" alt="{{ $item->reward->nama }}" class="object-contain max-h-24" />
                </div>

                <!-- Konten detail -->
                <div class="flex flex-col justify-center p-4 flex-grow">
                    <!-- Baris: Nama | Status | Ember -->
                    <div class="flex flex-wrap justify-between items-center gap-2">
                        <!-- Nama Reward -->
                        <h2 class="text-lg font-semibold text-gray-900">
                            {{ $item->reward->nama }}
                        </h2>

                        <!-- Status -->
                        <span class="inline-block px-3 py-1 text-sm font-medium rounded-full
                            @switch($item->status_reward)
                                @case('Menunggu') bg-yellow-200 text-yellow-800 @break
                                @case('Diproses') bg-blue-200 text-blue-800 @break
                                @case('Selesai') bg-green-200 text-green-800 @break
                                @default bg-gray-200 text-gray-800
                            @endswitch
                        ">
                            {{ $item->statusReward->status }}
                        </span>

                        <!-- Jumlah Ember -->
                        <span class="text-gray-700 font-semibold">
                            {{ $item->reward->jumlah_ember_harga }} Ember
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</section>

@endsection
