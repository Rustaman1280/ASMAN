@extends('layouts.admin')

@section('title', 'Daftar Lab')

@section('content')
<div x-data="labTable()" x-cloak>
    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center">
        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        {{-- Header --}}
        <div class="p-6 border-b border-slate-100">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <h3 class="text-lg font-semibold text-slate-800">Data Laboratorium</h3>
                <div class="flex flex-wrap items-center gap-2">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center px-3.5 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Kolom
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-200 z-50 p-3">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 px-1">Tampilkan Kolom</p>
                            <template x-for="col in allColumns" :key="col.key">
                                <label class="flex items-center py-1.5 px-1 hover:bg-slate-50 rounded-lg cursor-pointer">
                                    <input type="checkbox" :checked="columns.includes(col.key)" @change="toggleColumn(col.key)" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500 mr-2.5">
                                    <span class="text-sm text-slate-700" x-text="col.label"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                    <a href="{{ route('labs.create') }}" class="inline-flex items-center px-3.5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Lab
                    </a>
                </div>
            </div>

            {{-- Search & Filter --}}
            <div class="mt-4 flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" x-model="search" placeholder="Cari nama lab atau jurusan..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400">
                </div>
                <select x-model="filterJurusan" class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all min-w-[180px]">
                    <option value="">Semua Jurusan</option>
                    @php $jurusans = $labs->pluck('jurusan.nama')->unique()->sort(); @endphp
                    @foreach($jurusans as $j)
                        <option value="{{ $j }}">{{ $j }}</option>
                    @endforeach
                </select>
                <button @click="search=''; filterJurusan=''" x-show="search || filterJurusan"
                        class="px-3 py-2.5 text-sm text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Reset
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('nama')">Nama Lab</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('jurusan')">Jurusan</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center" x-show="columns.includes('total_barang')">Total Barang</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($labs as $lab)
                    <tr class="hover:bg-blue-50/50 transition-colors"
                        x-show="rowVisible('{{ addslashes($lab->nama) }}', '{{ addslashes($lab->jurusan->nama) }}')"
                        x-transition.opacity>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-800" x-show="columns.includes('nama')">{{ $lab->nama }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-600" x-show="columns.includes('jurusan')">{{ $lab->jurusan->nama }}</td>
                        <td class="px-6 py-4 text-center" x-show="columns.includes('total_barang')">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">{{ $lab->barangs_count ?? $lab->barangs->count() }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('labs.show', $lab) }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-white rounded-lg border border-transparent hover:border-emerald-100 transition-all" title="Detail Barang">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('labs.edit', $lab) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-white rounded-lg border border-transparent hover:border-blue-100 transition-all" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('labs.destroy', $lab) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                    @if($labs->isEmpty())
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">Belum ada data lab.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 text-xs text-slate-500">
            Total: {{ $labs->count() }} lab
        </div>
    </div>
</div>

<script>
function labTable() {
    return {
        search: '',
        filterJurusan: '',
        allColumns: [
            { key: 'nama', label: 'Nama Lab' },
            { key: 'jurusan', label: 'Jurusan' },
            { key: 'total_barang', label: 'Total Barang' },
        ],
        columns: JSON.parse(localStorage.getItem('lab_columns') || 'null') || ['nama', 'jurusan', 'total_barang'],
        toggleColumn(key) {
            if (this.columns.includes(key)) {
                this.columns = this.columns.filter(c => c !== key);
            } else {
                this.columns.push(key);
            }
            localStorage.setItem('lab_columns', JSON.stringify(this.columns));
        },
        rowVisible(nama, jurusan) {
            if (this.search) {
                const q = this.search.toLowerCase();
                if (!(nama + ' ' + jurusan).toLowerCase().includes(q)) return false;
            }
            if (this.filterJurusan && jurusan !== this.filterJurusan) return false;
            return true;
        }
    }
}
</script>
@endsection
