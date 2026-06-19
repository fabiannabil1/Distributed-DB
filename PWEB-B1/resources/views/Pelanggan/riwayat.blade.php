@extends('Layout.pelanggan.app')

@section('content')
<main class="flex flex-col flex-1 px-6 py-10 gap-10">
    <section class="flex flex-wrap justify-center gap-10 max-w-5xl mx-auto">
        <div class="bg-[#2f7a2f] rounded-xl flex items-center gap-6 px-8 py-6 min-w-[220px] max-w-[280px]">
            <img src="{{ asset('img/trash.png') }}" alt="Icon total poin" class="w-16 h-16" />
            <div class="text-white">
                <p class="font-semibold text-sm mb-1">Total poin</p>
                <p class="font-extrabold text-5xl leading-none">{{ $totalPoin }}</p>
            </div>
        </div>
        <div class="bg-[#2f7a2f] rounded-xl flex items-center gap-6 px-8 py-6 min-w-[220px] max-w-[280px]">
            <img src="{{ asset('img/calendar.png') }}" alt="Icon sisa hari" class="w-16 h-16" />
            <div class="text-white">
                <p class="font-semibold text-sm mb-1">Sisa Hari</p>
                <p class="font-extrabold text-5xl leading-none">{{ $sisaHari }}</p>
            </div>
        </div>
    </section>

    <section class="max-w-5xl mx-auto w-full">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-3 border-b border-gray-200 font-semibold text-gray-900">
                Halo, {{ $pelanggan->nama_lengkap }}! Ini Laporanmu
            </div>
            <table class="w-full text-left text-gray-700 text-sm">
                <thead class="bg-[#f5f9e9] text-gray-900 font-semibold">
                    <tr>
                        <th class="py-3 px-6">Tanggal Pengambilan</th>
                        <th class="py-3 px-6">Nama Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $item)
                        <tr class="border-b border-gray-200">
                            <td class="py-3 px-6">{{ $item->tanggal_pengambilan }}</td>
                            <td class="py-3 px-6">{{ $item->admin->nama_lengkap }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-gray-500 py-4">Belum ada riwayat pengambilan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="flex justify-end px-6 py-4 border-t border-gray-200">
                <label for="perPage" class="text-gray-500 text-sm mr-3 flex items-center gap-1">
                    Per page
                </label>
                <select name="perPage" id="perPage" class="border border-gray-300 rounded-md text-sm py-1 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>10</option>
                    <option>20</option>
                    <option>50</option>
                </select>
            </div>
        </div>
    </section>
</main>

<footer class="max-w-5xl mx-auto w-full px-6 py-6 flex justify-end">
    <a href="{{ route('pelanggan.landing') }}">
        <button type="button" class="bg-[#2f7a2f] text-white font-semibold rounded-full px-8 py-3 hover:bg-[#276927] transition">
            Kembali
        </button>
    </a>
</footer>


@endsection





