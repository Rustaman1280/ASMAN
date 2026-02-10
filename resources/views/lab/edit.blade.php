@extends('layouts.admin')

@section('title', 'Edit Lab')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center">
        <a href="{{ route('labs.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h3 class="text-lg font-semibold text-slate-700">Edit Data Laboratorium</h3>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm p-8">
        <form action="{{ route('labs.update', $lab) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="jurusan_id" class="block text-sm font-semibold text-slate-700 mb-2">Jurusan</label>
                    <select name="jurusan_id" id="jurusan_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" required>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $lab->jurusan_id) == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }} ({{ $jurusan->kode }})</option>
                        @endforeach
                    </select>
                    @error('jurusan_id') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lab</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $lab->nama) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" required>
                    @error('nama') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                    <a href="{{ route('labs.index') }}" class="px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-all">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">Perbarui Lab</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
