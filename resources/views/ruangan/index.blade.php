@extends('layouts.admin')

@section('title', $jenis ? 'Daftar ' . $jenis : 'Semua Ruangan')

@section('content')
<div x-data="ruanganTable()" x-cloak>
    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center">
        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        {{-- Header --}}
        <div class="p-5 border-b border-slate-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <h3 class="text-lg font-bold text-slate-800">Data {{ $jenis ? $jenis : 'Ruangan' }}</h3>
                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" x-model="search" placeholder="Cari nama ruangan..."
                               class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    <a href="{{ route('ruangans.create', ['jenis' => $jenis]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Ruangan</th>
                        @if(!$jenis)
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori / Jenis</th>
                        @endif
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Detail</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Total Barang</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($ruangans as $item)
                    <tr class="hover:bg-blue-50/50 transition-colors"
                        x-show="rowVisible('{{ addslashes($item->nama) }}')"
                        x-transition.opacity>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-800">{{ $item->nama }}</td>
                        @if(!$jenis)
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <div>{{ $item->jenis_ruangan }}</div>
                            <div class="text-xs text-slate-400">{{ $item->kategori }}</div>
                        </td>
                        @endif
                        <td class="px-6 py-4 text-sm text-slate-600">
                            @if($item->jurusan)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 mb-1">Jurusan: {{ $item->jurusan->nama }}</span><br>
                            @endif
                            @if($item->tingkat)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">Tingkat: {{ $item->tingkat }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">{{ $item->barangs_count ?? $item->barangs->count() }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('ruangans.edit', $item) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-white rounded-lg border border-transparent hover:border-blue-100 transition-all" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('ruangans.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg border border-transparent hover:border-rose-100 transition-all" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($ruangans->isEmpty())
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">Belum ada data ruangan.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 text-xs text-slate-500">
            Total: {{ $ruangans->count() }} ruangan
        </div>
    </div>
</div>

<script>
function ruanganTable() {
    return {
        search: '',
        rowVisible(nama) {
            if (this.search) {
                const q = this.search.toLowerCase();
                if (!nama.toLowerCase().includes(q)) return false;
            }
            return true;
        }
    }
}
</script>
@endsection
