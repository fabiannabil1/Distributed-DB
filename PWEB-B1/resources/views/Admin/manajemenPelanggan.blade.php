@extends('Layout.admin.app')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
  <h2 class="text-gray-900 font-semibold text-lg mb-6">Daftar Pelanggan</h2>

  <table class="w-full border-collapse text-sm">
    <thead>
      <tr class="bg-green-100 text-gray-800 font-semibold text-[13px]">
        <th class="px-4 py-3 text-left border-b">Nama</th>
        <th class="px-4 py-3 text-left border-b">Email</th>
        <th class="px-4 py-3 text-left border-b">Alamat</th>
        <th class="px-4 py-3 text-left border-b">Latitude</th>
        <th class="px-4 py-3 text-left border-b">Longitude</th>
        <th class="px-4 py-3 text-left border-b">Status</th>
        <th class="px-4 py-3 text-left border-b">Aksi</th>
      </tr>
    </thead>
    <tbody class="text-gray-700">
      @foreach ($pelanggans as $pelanggan)
      <tr class="border-b hover:bg-gray-50 transition">
        <td class="px-4 py-3">{{ $pelanggan->nama_lengkap }}</td>
        <td class="px-4 py-3">{{ $pelanggan->email }}</td>
        <td class="px-4 py-3">{{ $pelanggan->alamat }}</td>
        <td class="px-4 py-3">{{ $pelanggan->latitude }}</td>
        <td class="px-4 py-3">{{ $pelanggan->longitude }}</td>
        <td class="px-4 py-3">{{ $pelanggan->status_berlangganan }}</td>
        <td class="px-4 py-3 flex space-x-3">
          <button
            class="edit-btn text-green-700 hover:text-green-800 flex items-center gap-1 font-semibold"
            data-id="{{ $pelanggan->pelanggan_id }}"
            data-alamat="{{ $pelanggan->alamat }}"
            data-latitude="{{ $pelanggan->latitude }}"
            data-longitude="{{ $pelanggan->longitude }}"
            data-status="{{ $pelanggan->status_berlangganan }}">
            <i class="fas fa-edit"></i> Edit
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-6 flex justify-center">
    {{ $pelanggans->links() }}
  </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 {{ $errors->any() ? '' : 'hidden' }}">
  <div class="bg-white w-auto min-w-[450px] max-w-lg h-auto min-h-[250px] rounded-2xl shadow-2xl">
    <div class="px-6 py-4 border-b bg-emerald-100 rounded-t-2xl text-center">
      <h3 class="text-2xl font-semibold text-emerald-800">Edit Data Pelanggan</h3>
    </div>

    <div class="px-6 py-6 space-y-6 max-h-[80vh] overflow-y-auto">
      <form id="editForm" method="POST" action="">
        @csrf
        @method('PUT')
        <input type="hidden" id="pelanggan_id" name="pelanggan_id" value="{{ old('pelanggan_id') }}" />

        <div>
            <label class="block text-sm font-medium text-emerald-700">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="w-full px-4 py-3 border border-emerald-300 rounded-lg bg-emerald-50 cursor-not-allowed text-base"
                   value="{{ old('alamat') }}" readonly>
        </div>

        <div>
          <label class="block text-sm font-medium text-emerald-700">Latitude</label>
          <input type="text" id="latitude" name="latitude" class="w-full px-4 py-2 border rounded-lg text-sm"
                 value="{{ old('latitude') }}" />
          <p class="text-sm text-red-600 mt-1 {{ $errors->has('latitude') ? '' : 'hidden' }}" id="latitude_error">
            @error('latitude') {{ $message }} @enderror
          </p>
        </div>

        <div>
          <label class="block text-sm font-medium text-emerald-700">Longitude</label>
          <input type="text" id="longitude" name="longitude" class="w-full px-4 py-2 border rounded-lg text-sm"
                 value="{{ old('longitude') }}" />
          <p class="text-sm text-red-600 mt-1 {{ $errors->has('longitude') ? '' : 'hidden' }}" id="longitude_error">
            @error('longitude') {{ $message }} @enderror
          </p>
        </div>

        <div>
          <label class="block text-sm font-medium text-amber-700">Status</label>
          <select id="status_berlangganan" name="status_berlangganan" class="w-full px-4 py-2 border rounded-lg text-sm">
            <option value="Tidak Aktif" {{ old('status_berlangganan') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            <option value="Aktif" {{ old('status_berlangganan') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
          </select>
          <p class="text-sm text-red-600 mt-1 {{ $errors->has('status_berlangganan') ? '' : 'hidden' }}" id="status_berlangganan_error">
            @error('status_berlangganan') {{ $message }} @enderror
          </p>
        </div>

        <div class="px-6 py-4 border-t bg-emerald-100 rounded-b-2xl flex justify-end gap-3">
          <button type="button" onclick="closeModal()" class="text-sm text-emerald-600 hover:text-red-500 font-medium">Batal</button>
          <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Buka Modal Jika Ada Error -->
@if ($errors->any())
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('editModal').classList.remove('hidden');
  });
</script>
@endif

<!-- Script AJAX -->
<script>
  function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.querySelectorAll('.text-red-600').forEach(el => el.classList.add('hidden'));
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const alamat = this.dataset.alamat;
        const latitude = this.dataset.latitude;
        const longitude = this.dataset.longitude;
        const status = this.dataset.status;

        document.getElementById('editForm').action = `/admin/pelanggan/${id}`;
        document.getElementById('pelanggan_id').value = id;
        document.getElementById('alamat').value = alamat;
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;
        document.getElementById('status_berlangganan').value = status;

        document.getElementById('editModal').classList.remove('hidden');
      });
    });

    document.getElementById('editForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const form = this;
      const formData = new FormData(form);
      const url = form.action;

      document.querySelectorAll('.text-red-600').forEach(el => el.classList.add('hidden'));

      fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          closeModal();
          window.location.reload();
        } else if (data.errors) {
          for (const field in data.errors) {
            const errorField = document.getElementById(`${field}_error`);
            if (errorField) {
              errorField.innerText = data.errors[field][0];
              errorField.classList.remove('hidden');
            }
          }
        }
      })
      .catch(err => {
        alert('Gagal menyimpan data: ' + err.message);
      });
    });
  });
</script>
@endsection
