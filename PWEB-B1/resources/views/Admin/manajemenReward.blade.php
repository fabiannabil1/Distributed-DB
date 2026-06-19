@extends('Layout.admin.app')

@section('title', 'Manajemen reward')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Manajemen Reward</h2>
    <a href="{{ route('reward.create') }}" class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition">
      <i class="fas fa-plus mr-2"></i> Tambah Reward
    </a>
  </div>

  <div class="overflow-x-auto rounded-lg border">
    <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700 table-auto">
      <thead class="bg-green-100 text-green-800 font-semibold">
        <tr>
          <th class="px-4 py-3 text-left">Nama</th>
          <th class="px-4 py-3 text-left">Gambar</th>
          <th class="px-4 py-3 text-left">Harga (Ember)</th>
          <th class="px-4 py-3 text-left w-32">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100">
        @foreach ($data_reward as $reward)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-3">{{ $reward->nama }}</td>
          <td class="px-4 py-3">
            <img src="{{ asset('img/' . $reward->gambar) }}" alt="Gambar" class="w-32 h-20 object-cover rounded" />
          </td>
          <td class="px-4 py-3 font-medium text-gray-800">{{ $reward->jumlah_ember_harga }}</td>
          <td class="px-4 py-3 w-40 whitespace-nowrap">
            <div class="flex items-center gap-3">
              <a href="{{ route('reward.edit', $reward->reward_id) }}"
                 class="bg-blue-100 text-blue-800 px-3 py-1 rounded hover:bg-blue-200 transition font-medium"
                 title="Edit">
                Edit
              </a>
              <form action="{{ route('reward.destroy', $reward->reward_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus reward ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 transition font-medium"
                        title="Hapus">
                  Hapus
                </button>
              </form>
            </div>
          </td>
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

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
