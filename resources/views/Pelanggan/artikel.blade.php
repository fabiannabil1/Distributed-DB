@extends('layout.Pelanggan.app')

@section('title', 'Read Artikel')

@section('content')
<div class="bg-gray-100 min-h-screen py-10 px-4">
    <div class="bg-white max-w-4xl mx-auto rounded-2xl shadow-lg overflow-hidden">
        <!-- Gambar Tampil Sepenuhnya -->
        <img src="{{ asset('img/' . $artikel->gambar) }}" alt="Gambar Artikel"
             class="w-full h-auto object-cover">

        <div class="p-6 sm:p-8">
            <!-- Judul Artikel -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $artikel->judul }}</h1>

            <!-- Konten Artikel (Teks Tampil Sepenuhnya, Menyesuaikan Panjang Card) -->
            <div class="text-gray-700 text-base leading-relaxed space-y-4 mb-6 break-words">
                {!! nl2br(e($artikel->konten)) !!}
            </div>


            <a href="/" class="inline-block text-green-600 font-medium hover:underline transition">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
