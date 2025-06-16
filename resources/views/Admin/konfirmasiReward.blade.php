@extends('layout.admin.app')

@section('title', 'Konfirmasi Reward')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
  <h2 class="text-gray-900 font-semibold text-lg mb-6">Daftar Reward</h2>
  <table class="w-full border-collapse text-sm">
    <thead>
      <tr class="bg-green-100 text-gray-800 font-semibold text-[13px]">
        <th class="px-4 py-3 text-left border-b">Nama Lengkap</th>
        <th class="px-4 py-3 text-left border-b">Alamat</th>
        <th class="px-4 py-3 text-left border-b">Nama Reward</th>
        <th class="px-4 py-3 text-left border-b">Status</th>
        <th class="px-4 py-3 text-left border-b">Aksi</th>
      </tr>
    </thead>
    <tbody class="text-gray-700">
      @foreach ($reward as $item)
      <tr class="border-b hover:bg-gray-50 transition">
        <td class="px-4 py-3">{{ $item->pelanggan->nama_lengkap ?? '-' }}</td>
        <td class="px-4 py-3">{{ $item->pelanggan->alamat ?? '-' }}</td>
        <td class="px-4 py-3">{{ $item->reward->nama ?? '-' }}</td>
        <td class="px-4 py-3">{{ $item->statusReward->status ?? '-' }}</td>
        <td class="px-4 py-3 flex space-x-3">
          <button
            class="edit-btn text-green-700 hover:text-green-800 flex items-center gap-1 font-semibold"
            data-id="{{ $item->detail_reward_id }}"
            data-nama="{{ $item->pelanggan->nama_lengkap ?? '-' }}"
            data-alamat="{{ $item->pelanggan->alamat ?? '-' }}"
            data-reward="{{ $item->reward->nama ?? '-' }}"
            data-status="{{ $item->status_reward_id }}">
            <i class="fas fa-edit"></i> Edit
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300">
  <div class="bg-white w-auto min-w-[450px] max-w-lg h-auto rounded-2xl shadow-2xl transform transition-all duration-300 scale-95">
    <div class="px-6 py-4 border-b bg-emerald-100 rounded-t-2xl text-center">
      <h3 class="text-2xl font-semibold text-emerald-800">Edit Status Reward</h3>
    </div>

    <div class="px-6 py-6 space-y-6 max-h-[80vh] overflow-y-auto">
      <form id="editForm" method="POST" action="{{ route('admin.reward.update') }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="rewardId">

        <div>
          <label class="block text-sm font-medium text-emerald-700">Nama Pelanggan</label>
          <p id="namaPelanggan" class="text-gray-900 font-semibold"></p>
        </div>

        <div>
          <label class="block text-sm font-medium text-emerald-700">Alamat</label>
          <p id="alamatPelanggan" class="text-gray-900"></p>
        </div>

        <div>
          <label class="block text-sm font-medium text-emerald-700">Nama Reward</label>
          <p id="namaReward" class="text-gray-900"></p>
        </div>

        <div>
          <label class="block text-sm font-medium text-amber-700" for="statusSelect">Status</label>
          <select name="status" id="statusSelect" class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 bg-white text-sm">
            <option value= 1 >Menunggu</option>
            <option value= 2 >Diproses</option>
            <option value= 3 >Selesai</option>
          </select>
          <p id="status_error" class="text-sm text-red-600 mt-1 hidden"></p>
        </div>

        <div class="px-6 py-4 border-t bg-emerald-100 rounded-b-2xl flex justify-end gap-3">
          <button type="button" onclick="closeEditModal()" class="text-sm text-emerald-600 hover:text-red-500 font-medium transition-colors">Batal</button>
          <button type="submit" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition-colors text-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Buka modal dan isi form
  document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function () {
      document.getElementById('rewardId').value = this.dataset.id;
      document.getElementById('namaPelanggan').innerText = this.dataset.nama;
      document.getElementById('alamatPelanggan').innerText = this.dataset.alamat;
      document.getElementById('namaReward').innerText = this.dataset.reward;
      document.getElementById('statusSelect').value = this.dataset.status;

      document.getElementById('status_error').classList.add('hidden');
      document.getElementById('status_error').innerText = '';
      document.getElementById('editModal').classList.remove('hidden');
    });
  });

  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('status_error').classList.add('hidden');
  }

  // AJAX submit
  document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    const url = form.getAttribute('action');

    const statusError = document.getElementById('status_error');
    statusError.classList.add('hidden');
    statusError.innerText = '';

    fetch(url, {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    })
    .then(response => {
      if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
      return response.json();
    })
    .then(data => {
      if(data.success){
        closeEditModal();
        alert('Status reward berhasil diperbarui.');
        window.location.reload();
      } else if(data.errors && data.errors.status){
        statusError.innerText = data.errors.status[0];
        statusError.classList.remove('hidden');
      } else {
        alert('Update gagal: ' + JSON.stringify(data));
      }
    })
    .catch(error => {
      alert('Terjadi kesalahan saat memperbarui: ' + error.message);
      console.error(error);
    });
  });
</script>
@endsection
