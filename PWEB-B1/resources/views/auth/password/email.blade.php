<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | RePonik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f3f8ec] min-h-screen flex items-center justify-center">
    <div class="flex w-full max-w-6xl mx-auto bg-white shadow-lg rounded-3xl overflow-hidden">
        <div class="w-full p-10">
            <h2 class="text-4xl font-bold text-center mb-2">Reset Password</h2>
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block mb-1 font-medium">Masukkan alamat email</label>
                    <input type="email" name="email" placeholder="Alamat email" required
                        class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" />
                </div>

                <button type="submit" class="w-full bg-green-800 hover:bg-green-700 text-white py-3 rounded-lg shadow-md">
                    Kirim Link Reset
                </button>
            </form>
        </div>
    </div>
</body>
</html>
