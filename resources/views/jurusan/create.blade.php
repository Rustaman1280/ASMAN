@extends('layouts.admin')

@section('title', 'Tambah Jurusan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center">
        <a href="{{ route('jurusans.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h3 class="text-lg font-semibold text-slate-700">Form Jurusan Baru</h3>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm p-8">
        <form action="{{ route('jurusans.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="kode" class="block text-sm font-semibold text-slate-700 mb-2">Kode Jurusan</label>
                    <input type="text" name="kode" id="kode" value="{{ old('kode') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Contoh: RPL, TKJ, DKV" required>
                    @error('kode') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Jurusan</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                    @error('nama') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                    <a href="{{ route('jurusans.index') }}" class="px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-all">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">Simpan Jurusan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
