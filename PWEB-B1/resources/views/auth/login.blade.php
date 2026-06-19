<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | RePonik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-[#f3f8ec] min-h-screen flex items-center justify-center">
    <div class="flex w-full max-w-6xl mx-auto bg-white shadow-lg rounded-3xl overflow-hidden">
        <div class="w-1/2 bg-[#f3f8ec] relative hidden md:block">
            <img src="{{ asset('img/logo_scoopy.png') }}" alt="Driver Illustration" class="absolute bottom-0 left-0 w-full max-h-[500px] object-contain">
            <img src="{{ asset('img/reponik-logo.png') }}" alt="Logo" class="absolute top-5 left-5 w-36">
        </div>

        <div class="w-full md:w-1/2 p-10">
            <h2 class="text-4xl font-bold text-center mb-2">Login</h2>
            <p class="text-center text-gray-500 mb-6">
                Tidak punya akun?
                <a href="{{ route('register') }}" class="text-green-700 font-medium hover:underline">Register</a>
            </p>

            @if ($errors->any())
                <div class="mb-4 text-red-600 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                });
            </script>
        @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block mb-1 font-medium">Masukkan alamat email</label>
                    <input type="email" name="email" placeholder="Alamat email" required
                        class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" />
                </div>

                <div>
                    <label class="block mb-1 font-medium">Masukkan Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" placeholder="Password" required
                            class="w-full border rounded-lg px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-green-500" />

                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-3 text-gray-400">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <div class="text-right mt-2">
                        <a href="{{ route('password.request') }}" class="text-sm text-green-700 hover:underline">Lupa Password?</a>
                    </div>
                </div>

                <button type="submit" class="w-full bg-green-800 hover:bg-green-700 text-white py-3 rounded-lg shadow-md">
                    Login
                </button>
            </form>

        @if ($errors->has('email') && $errors->first('email') === 'Akun Anda belum berlangganan.')
            <script>
                const nama = @json(session('nama') ?? 'Nama tidak tersedia');
                const email = @json(session('email') ?? 'Email tidak tersedia');
                const alamat = @json(session('alamat') ?? 'Alamat tidak tersedia');
                const pesan = encodeURIComponent(
                    `Halo Admin, saya belum bisa login karena belum berlangganan:\n\nNama: ${nama}\nEmail: ${email}\nAlamat: ${alamat}\n\nMohon dibantu ya!`
                );
                const waLink = `https://wa.me/6282257161599?text=${pesan}`;

                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Bisa Login',
                    text: 'Akun Anda belum berlangganan.',
                    confirmButtonText: 'Langganan',
                    confirmButtonColor: '#16a34a',
                    showCloseButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = waLink;
                    }
                });
            </script>
        @endif



        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10a9.956 9.956 0 013.63-7.76M15 12a3 3 0 00-3-3m0 0a3 3 0 010 6m0-6a3 3 0 100 6m0 0a9.959 9.959 0 005.376-1.513M19.07 4.93l-14.14 14.14" />
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>

</body>
</html>
