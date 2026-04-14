@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <!-- Stat Card: Jurusan -->
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m0 10h1m-1 4h1m-7 10v-2a2 2 0 012-2h12a2 2 0 012 2v2"></path></svg>
            </div>
            <span class="text-3xl font-bold text-slate-800">{{ \App\Models\Jurusan::count() }}</span>
        </div>
        <h4 class="text-lg font-semibold text-slate-700">Total Jurusan</h4>
        <p class="text-sm text-slate-500 mb-6">Program keahlian yang tersedia.</p>
        <a href="{{ route('jurusans.index') }}" class="text-blue-600 font-semibold text-sm hover:underline flex items-center">
            Kelola Jurusan
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>

    <!-- Stat Card: Ruangan -->
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m0 10h1m-1 4h1m-7 10v-2a2 2 0 012-2h12a2 2 0 012 2v2"></path></svg>
            </div>
            <span class="text-3xl font-bold text-slate-800">{{ \App\Models\Ruangan::count() }}</span>
        </div>
        <h4 class="text-lg font-semibold text-slate-700">Total Ruangan</h4>
        <p class="text-sm text-slate-500 mb-6">Fasilitas dan area sekolah.</p>
        <a href="{{ route('ruangans.index') }}" class="text-purple-600 font-semibold text-sm hover:underline flex items-center">
            Kelola Ruangan
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>
</div>

<div class="mt-12 bg-blue-600 rounded-3xl p-10 text-white relative overflow-hidden shadow-2xl shadow-blue-200">
    <div class="relative z-10">
        <h3 class="text-2xl font-bold mb-2">Selamat Datang di ASMAN Dashboard</h3>
        <p class="text-blue-100 max-w-lg mb-0">Kelola data akademik sekolah dengan lebih mudah, cepat, dan rapi dalam satu sistem terintegrasi.</p>
    </div>
    <div class="absolute right-0 top-0 bottom-0 opacity-10 pointer-events-none">
        <svg class="h-full" viewBox="0 0 200 200" fill="none"><circle cx="100" cy="100" r="100" fill="white"/></svg>
    </div>
</div>
@endsection
