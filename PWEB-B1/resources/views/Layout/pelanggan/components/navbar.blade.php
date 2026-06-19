@php
    $user = auth('pelanggan')->user();
@endphp

<header class="fixed top-0 left-0 w-full z-[60] bg-white shadow-md">
  <div class="container mx-auto flex justify-between items-center py-4 px-6">
    <div class="text-2xl font-bold text-emerald-600">RePonik</div>
    <nav class="flex items-center space-x-6 text-sm font-medium text-gray-700">
        <!-- Kategori: Reward -->
        <div class="relative group">
            <button class="hover:text-emerald-600 transition-colors">Reward</button>
            <div class="absolute left-0 mt-2 w-48 bg-white border border-emerald-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <a href="{{ route('status.reward') }}" class="block px-4 py-2 hover:bg-emerald-50 hover:text-emerald-600">Status Reward</a>
                <a href="{{ route('pelanggan.reward') }}" class="block px-4 py-2 hover:bg-emerald-50 hover:text-emerald-600">Klaim Reward</a>
            </div>
        </div>

        <!-- Kategori: Layanan -->
        <div class="relative group">
            <button class="hover:text-emerald-600 transition-colors">Layanan</button>
            <div class="absolute left-0 mt-2 w-48 bg-white border border-emerald-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <a href="{{ route('pelanggan.riwayat') }}" class="block px-4 py-2 hover:bg-emerald-50 hover:text-emerald-600">Riwayat Penjemputan</a>
            </div>
        </div>

        <!-- Kategori: Belanja -->
        <div class="relative group">
            <button class="hover:text-emerald-600 transition-colors">Belanja</button>
            <div class="absolute left-0 mt-2 w-48 bg-white border border-emerald-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <a href="{{ route('katalog.index')}}" class="block px-4 py-2 hover:bg-emerald-50 hover:text-emerald-600">Katalog</a>
                <a href="{{ route('keranjang.index')}}" class="block px-4 py-2 hover:bg-emerald-50 hover:text-emerald-600">Keranjang</a>
                <a href="{{ route('transaksi.index')}}" class="block px-4 py-2 hover:bg-emerald-50 hover:text-emerald-600">Transaksi</a>
            </div>
        </div>

        <!-- Kategori: Informasi -->
        <a href="{{ route('artikel.show') }}#Artikel" class="hover:text-emerald-600 transition-colors">Artikel</a>
        <a href="#Kontak" class="hover:text-emerald-600 transition-colors">Kontak</a>

        @if ($user)
        <div class="relative">
          <button onclick="toggleDropdown()" class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xl focus:outline-none hover:bg-emerald-700 transition-colors">
            <i class="fas fa-user"></i>
          </button>
          <div id="dropdownMenu" class="absolute right-0 mt-2 w-56 bg-white border border-emerald-100 rounded-lg shadow-lg hidden z-50">
            <div class="py-1 border-b border-emerald-100">
              <div class="px-4 py-2 text-xs text-emerald-600 uppercase">Pengaturan</div>
              <button onclick="openAccountModal()" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Profil</button>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="py-1" id="logoutForm">
              @csrf
              <button type="button" onclick="confirmLogout()" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Logout</button>
            </form>
          </div>
        </div>
        @else
        <a href="{{ route('login') }}" class="bg-amber-400 hover:bg-amber-500 text-white px-4 py-2 rounded-lg transition-colors">Login</a>
        @endif
    </nav>
  </div>
</header>

<div class="h-24"></div>

<!-- Account Settings Modal -->
@if ($user)
<div id="accountSettingsModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex justify-center items-center transition-opacity duration-300">
    <div class="bg-gradient-to-b from-emerald-50 to-white w-full max-w-2xl max-h-[90vh] mt-24 rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 overflow-hidden flex flex-col">
    <div class="px-8 py-6 border-b bg-emerald-100 rounded-t-2xl text-center">
      <h2 class="text-2xl font-semibold text-emerald-800" id="modalTitle">Pengaturan Akun</h2>
    </div>

    <div id="modalContent" class="px-8 py-8 space-y-8 overflow-y-auto flex-1 scrollbar-thin scrollbar-thumb-emerald-300 scrollbar-track-emerald-100">
      @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
          <strong class="font-bold">Terjadi kesalahan:</strong>
          <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
          <strong class="font-bold">Sukses!</strong>
          <span class="block sm:inline">{{ session('success') }}</span>
        </div>
      @endif

      <form method="POST" action="{{ route('pengaturan.profil.simpan') }}">
        @csrf
        <div class="space-y-8">
          <div>
            <label class="block text-sm font-medium text-emerald-700">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user?->nama_lengkap) }}" class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 bg-white text-base" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-emerald-700">Email</label>
            <input type="text" value="{{ $user?->email }}" class="w-full px-4 py-3 border border-emerald-300 rounded-lg bg-emerald-50 cursor-not-allowed text-base" readonly>
          </div>
          <div>
            <label class="block text-sm font-medium text-emerald-700">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $user?->nomor_telepon) }}" class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 bg-white text-base" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-emerald-700">Alamat</label>
            <textarea name="alamat" class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 bg-white text-base" required>{{ old('alamat', $user?->alamat) }}</textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-emerald-700">Status Berlangganan</label>
            <input type="text" value="{{ $user?->status_berlangganan }}" class="w-full px-4 py-3 border border-emerald-300 rounded-lg bg-emerald-50 cursor-not-allowed text-base" readonly>
          </div>
        </div>
        <div class="mt-8 flex justify-between">
          <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition-colors text-base">Simpan</button>
        </div>
      </form>
    </div>

    <div class="px-8 py-6 border-t bg-emerald-100 rounded-b-2xl">
      <button onclick="closeAccountModal()" class="w-full py-3 text-emerald-600 hover:text-red-500 font-medium transition-colors text-lg">Tutup</button>
    </div>
  </div>
</div>
@endif

<!-- Modal Konfirmasi Logout -->
<div id="logoutConfirmModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex justify-center items-center transition-opacity duration-300">
  <div class="bg-white w-auto max-w-md h-auto p-8 rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 border border-emerald-100">
    <h2 class="text-xl font-semibold text-emerald-800 mb-4">Konfirmasi Logout</h2>
    <p class="text-gray-600 mb-6">Apakah Anda yakin ingin logout?</p>
    <div class="flex justify-end space-x-3">
      <button onclick="closeLogoutModal()" class="px-4 py-2 text-sm text-emerald-600 hover:text-red-500 font-medium transition-colors">Batal</button>
      <button onclick="submitLogout()" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition-all">Ya, Logout</button>
    </div>
  </div>
</div>

<script>
    function toggleDropdown() {
        document.getElementById('dropdownMenu')?.classList.toggle('hidden');
    }

    function openAccountModal() {
        const modal = document.getElementById('accountSettingsModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
        modal.querySelector('.transform')?.classList.remove('scale-95');
        }, 10);
    }

    function closeAccountModal() {
        const modal = document.getElementById('accountSettingsModal');
        modal.querySelector('.transform')?.classList.add('scale-95');
        setTimeout(() => {
        modal.classList.add('hidden');
        }, 300);
    }

    function confirmLogout() {
        const modal = document.getElementById('logoutConfirmModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
        modal.querySelector('.transform')?.classList.remove('scale-95');
        }, 10);
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutConfirmModal');
        modal.querySelector('.transform')?.classList.add('scale-95');
        setTimeout(() => {
        modal.classList.add('hidden');
        }, 300);
    }

    function submitLogout() {
        document.getElementById('logoutForm')?.submit();
    }

    @if ($errors->any())
        window.addEventListener('DOMContentLoaded', () => {
        openAccountModal();
        });
    @endif
</script>
