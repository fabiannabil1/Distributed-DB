<aside class="w-64 bg-white border-r relative">
    <div class="p-6">
      <img src="{{ asset('img/reponik-logo.png') }}" alt="RePonik Logo" class="mx-auto" />
      <nav>
        <ul>
            <li>
                <a href="/admin/dashboard"
                    class="flex items-center p-3 rounded-lg
                        {{ request()->is('admin/dashboard') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 5.5a3.5 3.5 0 100 7 3.5 3.5 0 000-7zM5 8.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5zM19 8.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5zM16.5 18.25c0-1.5-1.1-2.75-2.5-2.75h-4c-1.4 0-2.5 1.25-2.5 2.75V21h9v-2.75zM8.5 18.25c0-1-0.3-1.9-0.8-2.65C6.7 16.25 5.9 17 5.5 18v3H2v-2.75C2 16.5 3.6 15 5.5 15c1.2 0 2.2 0.65 2.8 1.5l0.2 0.25zM21.5 18.25V21h-3.5v-3c-0.4-1-1.2-1.75-2.2-2.4 0.6 0.75 0.9 1.65 0.9 2.65l0.3 0.5 0.5 1.25h4z"/>
                  </svg>
                  <span class="font-medium">Pelanggan</span>
                </a>
              </li>

              <li>
                <a href="/Admin.manajemenArtikel"
                    class="flex items-center p-3 rounded-lg
                        {{ request()->is('Admin.manajemenArtikel') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  <span>Manajemen Artikel</span>
                </a>
              </li>

              <li>
                <a href="/Admin.rute"
                    class="flex items-center p-3 rounded-lg
                        {{ request()->is('Admin.rute') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  <span>Pengambilan</span>
                </a>
              </li>

              <li>
                <a href="{{ route('admin.pelaporan') }}"
                    class="flex items-center p-3 rounded-lg
                        {{ request()->is('laporan') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  <span>Pelaporan</span>
                </a>
              </li>

                <li>
                    <a href="{{ route('katalog.index') }}"
                        class="flex items-center p-3 rounded-lg
                            {{ request()->routeIs('katalog.index') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">

                        <i data-feather="box" class="h-5 w-5 mr-3"></i>
                        <span>Manajemen Produk</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('transaksi.index') }}"
                        class="flex items-center p-3 rounded-lg
                            {{ request()->routeIs('transaksi.index') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                        <i data-feather="archive" class="h-5 w-5 mr-3"></i>
                        <span>Riwayat Transaksi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan.transaksi.index') }}"
                        class="flex items-center p-3 rounded-lg
                            {{ request()->routeIs('laporan.transaksi.index') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                        <i data-feather="file" class="h-5 w-5 mr-3"></i>
                        <span>Laporan Transaksi</span>
                    </a>
                </li>

              <li>
                <a href="{{ route('admin.manajemenReward') }}"
                    class="flex items-center p-3 rounded-lg
                        {{ request()->is('Admin.manajemenReward') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  <span>Manajemen Reward</span>
                </a>
            </li>
            <li>
                <a href="{{ route('konfirmasi.reward') }}"
                    class="flex items-center p-3 rounded-lg
                        {{ request()->is('konfirmasi/reward') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  <span>Konfirmasi Reward</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pengahsilanBerlangganan') }}"
                    class="flex items-center p-3 rounded-lg
                        {{ request()->is('pengahsilan/berlangganan') ? 'bg-green-800 text-white' : 'text-gray-800 hover:bg-gray-100' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  <span>Penghasilan Berlangganan</span>
                </a>
            </li>
        </ul>
      </nav>
    </div>
    <div class="absolute bottom-0 w-full p-6">
      <ul>
        <li>
            <button onclick="openAdminModal()" class="w-full flex items-center p-3 text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="text-left">Settings</span>
            </button>
          </li>

          <li>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
              @csrf
              <button type="button" onclick="confirmLogout()" class="w-full flex items-center p-3 text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="text-left">Logout</span>
              </button>
            </form>
          </li>
      </ul>
    </div>

    <!-- Sidebar Modal Admin -->
    <div id="adminSettingsModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex justify-center items-center transition-opacity duration-300">
      <div class="bg-white w-auto min-w-[450px] max-w-lg h-auto min-h-[250px] rounded-2xl shadow-2xl transform transition-all duration-300 scale-95">
        <div class="px-6 py-4 border-b bg-emerald-100 rounded-t-2xl text-center">
          <h2 class="text-2xl font-semibold text-emerald-800" id="adminModalTitle">Pengaturan Admin</h2>
        </div>

        <div class="px-6 py-6 space-y-6 max-h-[80vh] overflow-y-auto" id="adminModalContent">
          <!-- Content will be populated by JavaScript -->
        </div>

        <div class="px-6 py-4 border-t bg-emerald-100 rounded-b-2xl">
          <button onclick="closeAdminModal()" class="w-full py-2 text-emerald-600 hover:text-red-500 font-medium transition-colors text-base">Tutup</button>
        </div>
      </div>
    </div>
</aside>

<!-- Modal Konfirmasi Logout -->
<div id="logoutConfirmModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex justify-center items-center">
    <div class="bg-white w-full max-w-sm p-6 rounded shadow-lg">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Logout</h2>
      <p class="text-gray-600 mb-6">Apakah Anda yakin ingin logout?</p>
      <div class="flex justify-end space-x-2">
        <button onclick="closeLogoutModal()" class="px-4 py-2 text-sm text-gray-500 hover:text-red-500">Batal</button>
        <button onclick="submitLogout()" class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">Ya, Logout</button>
      </div>
    </div>
</div>

<script>
    function openAdminModal() {
      const modal = document.getElementById('adminSettingsModal');
      modal.classList.remove('hidden');
      setTimeout(() => {
        modal.querySelector('.transform').classList.remove('scale-95');
      }, 10);
      showAdminProfileAndPasswordForm();
    }

    function closeAdminModal() {
      const modal = document.getElementById('adminSettingsModal');
      modal.querySelector('.transform').classList.add('scale-95');
      setTimeout(() => {
        modal.classList.add('hidden');
      }, 300);
    }

    function showAdminProfileAndPasswordForm() {
      document.getElementById('adminModalTitle').innerText = 'Pengaturan Admin';
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}";
      console.log('CSRF Token:', csrfToken); // Debug CSRF token
      document.getElementById('adminModalContent').innerHTML = `
        <form id="adminSettingsForm">
          <input type="hidden" name="_token" value="${csrfToken}">
          <input type="hidden" name="_method" value="PATCH">
          <div class="space-y-6">
            <div>
              <label class="block text-sm font-medium text-emerald-700">Nama Lengkap</label>
              <input type="text" name="nama_lengkap" value="{{ auth('admin')->user()->nama_lengkap }}" class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-sm" required>
              <p class="text-sm text-red-600 mt-1 hidden" id="nama_lengkap_error"></p>
            </div>
            <div>
              <label class="block text-sm font-medium text-emerald-700">Email</label>
              <input type="text" value="{{ auth('admin')->user()->email }}" class="w-full px-4 py-2 border border-emerald-300 rounded-lg bg-emerald-50 cursor-not-allowed text-sm" readonly>
            </div>
            <div>
              <label class="block text-sm font-medium text-emerald-700">Telepon</label>
              <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', auth('admin')->user()->nomor_telepon) }}" class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all bg-white text-sm">
              <p class="text-sm text-red-600 mt-1 hidden" id="nomor_telepon_error"></p>
            </div>
            <div>
              <label class="block text-sm font-medium text-amber-700">Password Baru</label>
              <input type="password" name="password" class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 transition-all bg-white text-sm">
              <p class="text-sm text-red-600 mt-1 hidden" id="password_error"></p>
            </div>
            <div>
              <label class="block text-sm font-medium text-amber-700">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-400 transition-all bg-white text-sm">
            </div>
          </div>
          <div class="mt-6 flex justify-between">
            <button type="button" onclick="closeAdminModal()" class="text-sm text-emerald-600 hover:text-red-500 font-medium transition-colors">Kembali</button>
            <button type="button" onclick="submitAdminForm()" id="saveButton" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition-colors text-sm">Simpan</button>
          </div>
        </form>
      `;
    }

    function submitAdminForm() {
      const form = document.getElementById('adminSettingsForm');
      const saveButton = document.getElementById('saveButton');
      const formData = new FormData(form);

      // Reset previous error messages
      document.getElementById('nama_lengkap_error').classList.add('hidden');
      document.getElementById('nomor_telepon_error').classList.add('hidden');
      document.getElementById('password_error').classList.add('hidden');

      // Show loading state
      saveButton.disabled = true;
      saveButton.innerText = 'Menyimpan...';

      fetch("{{ route('admin.nama_dan_password.update') }}", {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(response => {
        console.log('Response status:', response.status);
        console.log('Response ok:', response.ok);

        if (response.status === 419) {
          throw new Error('CSRF token mismatch. Please refresh the page and try again.');
        }

        if (!response.ok) {
          return response.text().then(text => {
            console.log('Raw response:', text);
            throw new Error(`Server error (status ${response.status}): ${text.substring(0, 100)}...`);
          });
        }

        return response.json();
      })
      .then(data => {
        console.log('Response data:', data);
        if (data.success) {
          // On success, close the modal and refresh the page
          closeAdminModal();
          window.location.reload();
        } else if (data.errors) {
          // On validation failure, show errors and keep modal open
          if (data.errors.nama_lengkap) {
            const errorElement = document.getElementById('nama_lengkap_error');
            errorElement.innerText = data.errors.nama_lengkap[0];
            errorElement.classList.remove('hidden');
          }
          if (data.errors.nomor_telepon) {
            const errorElement = document.getElementById('nomor_telepon_error');
            errorElement.innerText = data.errors.nomor_telepon[0];
            errorElement.classList.remove('hidden');
          }
          if (data.errors.password) {
            const errorElement = document.getElementById('password_error');
            errorElement.innerText = data.errors.password[0];
            errorElement.classList.remove('hidden');
          }
        } else {
          alert('Gagal menyimpan data: Tidak ada pesan kesalahan dari server.');
        }
      })
      .catch(error => {
        console.error('Fetch error:', error);
        alert('Terjadi kesalahan saat menyimpan data: ' + error.message);
      })
      .finally(() => {
        // Reset button state
        saveButton.disabled = false;
        saveButton.innerText = 'Simpan';
      });
    }

    function confirmLogout() {
      document.getElementById('logoutConfirmModal').classList.remove('hidden');
    }

    function closeLogoutModal() {
      document.getElementById('logoutConfirmModal').classList.add('hidden');
    }

    function submitLogout() {
      document.getElementById('logoutForm').submit();
    }
</script>
