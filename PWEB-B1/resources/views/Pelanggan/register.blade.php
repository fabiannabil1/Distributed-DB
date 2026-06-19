<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrasi Akun</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-[#f0f6e9] min-h-screen flex flex-col">
  <header class="p-6">
    <img src="{{ asset('img/reponik-logo.png') }}" alt="Logo RePonik" class="h-8">
  </header>

  <main class="flex-grow flex justify-center items-start px-6 pb-12">
    <form action="{{ route('register') }}" method="POST" class="bg-white rounded-3xl w-full max-w-5xl p-10 shadow-[0_10px_30px_rgba(31,122,46,0.15)]">
      @csrf
      <h1 class="text-center font-extrabold text-4xl mb-10">Registrasi Akun</h1>

      <div class="mb-6">
        <label for="name" class="block mb-2 text-sm text-black">Masukkan Nama Lengkap</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required
          class="w-full rounded-md border border-gray-300 px-4 py-3 text-sm placeholder-gray-400 outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('name') border-red-500 @enderror">
        @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label for="email" class="block mb-2 text-sm text-black">Masukkan Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required
            class="w-full rounded-md border border-gray-300 px-4 py-3 text-sm placeholder-gray-400 outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('email') border-red-500 @enderror">
          @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="phone" class="block mb-2 text-sm text-black">Masukkan Nomor Telepon</label>
          <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
            class="w-full rounded-md border border-gray-300 px-4 py-3 text-sm placeholder-gray-400 outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('phone') border-red-500 @enderror">
          @error('phone') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="relative">
          <label for="password" class="block mb-2 text-sm text-black">Masukkan Password</label>
          <input type="password" id="password" name="password" required
            class="w-full rounded-md border border-gray-300 px-4 py-3 pr-12 text-sm placeholder-gray-400 outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('password') border-red-500 @enderror">
          <button type="button" onclick="togglePassword('password', this)"
            class="absolute right-3 top-[2.4rem] text-gray-500 hover:text-gray-700">
            <i class="far fa-eye"></i>
          </button>
          @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="relative">
          <label for="password_confirmation" class="block mb-2 text-sm text-black">Konfirmasi Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required
            class="w-full rounded-md border border-gray-300 px-4 py-3 pr-12 text-sm placeholder-gray-400 outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('password_confirmation') border-red-500 @enderror">
          <button type="button" onclick="togglePassword('password_confirmation', this)"
            class="absolute right-3 top-[2.4rem] text-gray-500 hover:text-gray-700">
            <i class="far fa-eye"></i>
          </button>
          @error('password_confirmation') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mb-8">
        <label for="address" class="block mb-2 text-sm text-black">Alamat</label>
        <textarea id="address" name="address" rows="3" required
          class="w-full rounded-md border border-gray-300 px-4 py-3 text-sm placeholder-gray-400 outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
        @error('address') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
      </div>

      <button type="submit"
        class="w-full bg-[#1f7a2e] text-white py-4 rounded-lg shadow-[0_10px_15px_rgba(31,122,46,0.3)] text-base font-semibold hover:bg-[#176124] transition">
        Daftar
      </button>
    </form>
  </main>

  <script>
    function togglePassword(inputId, button) {
      const input = document.getElementById(inputId);
      const icon = button.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>
