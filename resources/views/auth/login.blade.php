<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventaris SMKN 1 Garut</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/logo-smkn1-garut.svg') }}" alt="Logo SMKN 1 Garut" class="w-24 h-24">
                </div>
                <h1 class="text-2xl font-bold text-blue-600 mb-1">Inventaris SMKN 1 Garut</h1>
                <p class="text-slate-500 text-base">Sistem Manajemen Inventaris Sekolah</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="email" class="block text-base font-medium text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-3 text-base border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="admin@smkn1garut.sch.id" required value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-base font-medium text-slate-700 mb-2">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-3 text-base border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="••••••••" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 text-base rounded-lg transition-colors">
                    Masuk
                </button>
            </form>
        </div>
        <div class="bg-slate-50 p-4 text-center border-t border-slate-100">
            <p class="text-xs text-slate-500">&copy; {{ date('Y') }} SMKN 1 Garut. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>
</html>
