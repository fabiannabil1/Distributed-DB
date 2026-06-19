@extends('Layout.admin.app')

@section('title', 'Buat Reward')

@section('content')

<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow mt-10">
    {{-- Flash message --}}
  @if (session('success'))
      <div class="mb-4 p-4 rounded bg-green-100 text-green-800 font-medium">
          {{ session('success') }}
      </div>
  @endif
  <h2 class="text-lg font-semibold mb-4">Manajemen Reward</h2>

  <form action="{{ route('reward.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
  @csrf
  <!-- Nama -->
  <div class="flex items-center bg-green-50 px-4 py-3 rounded">
    <label class="w-32 font-medium text-gray-700">Nama</label>
    <input name="nama" type="text" placeholder="Masukan Nama" class="flex-1 border-none bg-transparent outline-none placeholder-gray-500" required />
  </div>

  <!-- Gambar -->
  <div class="flex items-center px-4 py-3 border-t">
    <label class="w-32 font-medium text-gray-700">Gambar</label>
    <input name="gambar" type="file" class="flex-1" required />
  </div>

  <!-- Harga Ember  -->
  <div class="flex items-center px-4 py-3 border-t">
    <label class="w-32 font-medium text-gray-700">Jumlah Ember Harga</label>
    <textarea name="jumlah_ember_harga" class="flex-1 border-none bg-transparent outline-none resize-none text-gray-700" rows="4" placeholder="Text Konten" required></textarea>
  </div>

  <!-- Tombol Upload -->
  <div class="flex justify-end pt-6">
    <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Upload</button>
  </div>
 </form>

</div>

@endsection
