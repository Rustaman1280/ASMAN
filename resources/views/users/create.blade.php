@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-semibold text-slate-800">Form Tambah User</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                <select name="role" id="role" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required onchange="toggleJurusan()">
                    <option value="">Pilih Role</option>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 {{ old('role') == 'pj_ruangan' ? '' : 'hidden' }}" id="ruangan_container">
                <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Ruangan (Bisa pilih lebih dari satu)</label>
                <div class="mb-3">
                    <input type="text" id="search_ruangan" placeholder="Cari nama atau jenis ruangan..." class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" onkeyup="filterRuangan()">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-60 overflow-y-auto p-3 border border-slate-200 rounded-lg bg-slate-50" id="ruangan_list">
                    @forelse($ruangans as $ruangan)
                        <label class="flex items-start space-x-3 cursor-pointer p-2 hover:bg-slate-100 rounded transition-colors ruangan-item">
                            <input type="checkbox" name="ruangans[]" value="{{ $ruangan->id }}" class="mt-1 w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500" {{ is_array(old('ruangans')) && in_array($ruangan->id, old('ruangans')) ? 'checked' : '' }}>
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-slate-800">{{ $ruangan->nama }}</span>
                                <span class="text-xs text-slate-500">{{ $ruangan->jenis_ruangan }}</span>
                            </div>
                        </label>
                    @empty
                        <div class="col-span-2 text-sm text-slate-500 text-center py-2">Belum ada data ruangan.</div>
                    @endforelse
                </div>
                @error('ruangans')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">Simpan</button>
                <a href="{{ route('users.index') }}" class="text-slate-500 hover:text-slate-700 font-medium">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleJurusan() {
        const role = document.getElementById('role').value;
        const container = document.getElementById('ruangan_container');
        if (role === 'pj_ruangan') {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }

    function filterRuangan() {
        const input = document.getElementById('search_ruangan').value.toLowerCase();
        const items = document.querySelectorAll('.ruangan-item');
        
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(input)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endsection
