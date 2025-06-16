@extends('layout.admin.app')

@section('title', 'Pelaporan')

@section('content')
  <div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">Rekap Laporan Bulanan</h2>
    </div>

    <div class="overflow-x-auto rounded-lg border">
      <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700 table-auto">
        <thead class="bg-green-100 text-green-800 font-semibold">
          <tr>
            <th class="px-4 py-3 text-left">Laporan Bulanan</th>
            <th class="px-4 py-3 text-left">Total Pengambilan (Ember)</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          @foreach($data_laporan as $data_laporan)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">{{ \Carbon\Carbon::createFromFormat('Y-m', $data_laporan->bulan)->translatedFormat('F Y') }}</td>
            <td class="px-4 py-3">{{ $data_laporan->jumlah_ember }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Pagination dan Per Page -->
    <div class="flex items-center justify-between mt-6">
      <div class="flex items-center space-x-2">
        <label for="perPage" class="text-sm text-gray-600">Tampilkan</label>
        <select id="perPage" class="border rounded px-2 py-1 text-sm">
          <option>10</option>
          <option>20</option>
          <option>50</option>
        </select>
        <span class="text-sm text-gray-600">data per halaman</span>
      </div>
    </div>
  </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
