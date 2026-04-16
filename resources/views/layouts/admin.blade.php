<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ASMAN - Admin Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body  
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col">
            <div class="p-6 border-b border-slate-100">
                <h1 class="text-2xl font-bold text-blue-600">ASMAN</h1>
                <p class="text-xs text-slate-400 font-medium">Academic System Management</p>
            </div>
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('jurusans.index') }}" class="flex items-center p-3 rounded-xl transition-all {{ request()->routeIs('jurusans.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m0 10h1m-1 4h1m-7 10v-2a2 2 0 012-2h12a2 2 0 012 2v2"></path></svg>
                    Jurusan
                </a>
                <!-- Ruangan Dropdown -->
                <div x-data="{ open: {{ request()->routeIs('ruangans.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-3 rounded-xl transition-all {{ request()->routeIs('ruangans.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m0 10h1m-1 4h1m-7 10v-2a2 2 0 012-2h12a2 2 0 012 2v2"></path></svg>
                            Ruangan
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-4 pr-3 py-2 space-y-4">
                        <!-- Area Pembelajaran -->
                        <div x-data="{ sub1: {{ in_array(request('jenis'), ['Ruang Kelas', 'Ruang Laboratorium', 'Ruang Perpustakaan']) ? 'true' : 'false' }} }">
                            <button @click="sub1 = !sub1" class="w-full flex justify-between items-center text-left px-2 py-1 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 cursor-pointer hover:text-slate-600 transition-colors">
                                <span>Pembelajaran & Akademik</span>
                                <svg class="w-3 h-3 shrink-0 transition-transform" :class="sub1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="sub1" x-collapse class="space-y-1 pl-2 pb-2">
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Kelas']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Kelas' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Kelas</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Laboratorium']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Laboratorium' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Laboratorium</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Perpustakaan']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Perpustakaan' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Perpustakaan</a>
                            </div>
                        </div>
                        <!-- Area Administrasi -->
                        <div x-data="{ sub2: {{ in_array(request('jenis'), ['Ruang Pimpinan', 'Ruang Guru', 'Ruang TU (Tata Usaha)']) ? 'true' : 'false' }} }">
                            <button @click="sub2 = !sub2" class="w-full flex justify-between items-center text-left px-2 py-1 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 cursor-pointer hover:text-slate-600 transition-colors">
                                <span>Administrasi & Manajemen</span>
                                <svg class="w-3 h-3 shrink-0 transition-transform" :class="sub2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="sub2" x-collapse class="space-y-1 pl-2 pb-2">
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Pimpinan']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Pimpinan' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Pimpinan</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Guru']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Guru' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Guru</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang TU (Tata Usaha)']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang TU (Tata Usaha)' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang TU</a>
                            </div>
                        </div>
                        <!-- Area Penunjang -->
                        <div x-data="{ sub3: {{ in_array(request('jenis'), ['Ruang OSIS', 'Ruang Konseling', 'Ruang UKS', 'Ruang Ibadah']) ? 'true' : 'false' }} }">
                            <button @click="sub3 = !sub3" class="w-full flex justify-between items-center text-left px-2 py-1 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 cursor-pointer hover:text-slate-600 transition-colors">
                                <span>Penunjang Pendidikan</span>
                                <svg class="w-3 h-3 shrink-0 transition-transform" :class="sub3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="sub3" x-collapse class="space-y-1 pl-2 pb-2">
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang OSIS']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang OSIS' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang OSIS</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Konseling']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Konseling' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Konseling</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang UKS']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang UKS' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang UKS</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Ibadah']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Ibadah' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Ibadah</a>
                            </div>
                        </div>
                        <!-- Area Fasilitas Umum -->
                        <div x-data="{ sub4: {{ in_array(request('jenis'), ['Ruang Toilet', 'Tempat Bermain / Olahraga', 'Ruang Gudang']) ? 'true' : 'false' }} }">
                            <button @click="sub4 = !sub4" class="w-full flex justify-between items-center text-left px-2 py-1 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 cursor-pointer hover:text-slate-600 transition-colors">
                                <span>Fasilitas Umum</span>
                                <svg class="w-3 h-3 shrink-0 transition-transform" :class="sub4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="sub4" x-collapse class="space-y-1 pl-2 pb-2">
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Toilet']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Toilet' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Toilet</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Tempat Bermain / Olahraga']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Tempat Bermain / Olahraga' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Tempat Bermain / Olahraga</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Gudang']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Gudang' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Gudang</a>
                            </div>
                        </div>
                        <!-- Area Bangunan & Sirkulasi -->
                        <div x-data="{ sub5: {{ in_array(request('jenis'), ['Ruang Bangunan', 'Ruang Sirkulasi', 'Ruang Praktik']) ? 'true' : 'false' }} }">
                            <button @click="sub5 = !sub5" class="w-full flex justify-between items-center text-left px-2 py-1 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 cursor-pointer hover:text-slate-600 transition-colors">
                                <span>Bangunan & Sirkulasi</span>
                                <svg class="w-3 h-3 shrink-0 transition-transform" :class="sub5 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="sub5" x-collapse class="space-y-1 pl-2 pb-2">
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Bangunan']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Bangunan' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Bangunan</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Sirkulasi']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Sirkulasi' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Sirkulasi</a>
                                <a href="{{ route('ruangans.index', ['jenis' => 'Ruang Praktik']) }}" class="block px-3 py-1.5 text-sm text-slate-600 rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ request('jenis') == 'Ruang Praktik' ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">Ruang Praktik</a>
                            </div>
                        </div>
                        <div class="pt-2 border-t border-slate-100">
                            <a href="{{ route('ruangans.index') }}" class="block px-3 py-2 text-sm text-slate-600 font-semibold rounded-lg hover:bg-slate-100 hover:text-blue-600 transition-colors {{ !request('jenis') ? 'bg-blue-50 text-blue-700' : '' }}">Semua Ruangan</a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('suppliers.index') }}" class="flex items-center p-3 rounded-xl transition-all {{ request()->routeIs('suppliers.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m0 10h1m-1 4h1m-7 10v-2a2 2 0 012-2h12a2 2 0 012 2v2"></path></svg>
                    Data Supplier
                </a>
                <a href="{{ route('barangs.index') }}" class="flex items-center p-3 rounded-xl transition-all {{ request()->routeIs('barangs.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Data Barang
                </a>
                @if(Auth::user() && Auth::user()->isAdmin())
                <a href="{{ route('users.index') }}" class="flex items-center p-3 rounded-xl transition-all {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-600 hover:bg-slate-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Kelola User
                </a>
                @endif
            </nav>
            <div class="p-4 border-t border-slate-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition-colors mb-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="text-sm font-semibold">Logout</span>
                    </button>
                </form>
                <div class="flex items-center p-2 rounded-lg bg-slate-50">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-3">
                        {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ Auth::user()->name ?? 'Guest' }}</p>
                        <p class="text-xs text-slate-500 truncate capitalize">{{ str_replace('_', ' ', Auth::user()->role ?? 'Guest') }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8">
                <h2 class="text-xl font-semibold text-slate-800">@yield('title')</h2>
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl flex items-center animate-fade-in-down">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
