<header class="bg-white border-b px-6 py-4 flex justify-between items-center shadow-sm">
    <h1 class="text-xl font-semibold text-gray-800">Dashboard Admin</h1>

    <div class="flex items-center space-x-4">
      <span class="text-sm text-gray-600">
        {{ auth('admin')->user()->nama_lengkap }}
      </span>
    </div>
  </header>
