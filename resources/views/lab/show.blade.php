@extends('layouts.admin')

@section('title', 'Detail Lab: ' . $lab->nama)

@section('content')
<div x-data="labShowTable()" x-cloak>
    <div class="mb-6">
        <a href="{{ route('labs.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Daftar Lab
        </a>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center">
        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm font-medium flex items-center">
        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Info Ruangan --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-800">{{ $lab->nama }}</h3>
                <div class="flex items-center gap-4 mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                        {{ $lab->jurusan->nama ?? '-' }}
                    </span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </div>

    {{-- Statistik Ringkasan --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Barang</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $lab->barangs->count() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-emerald-100 p-4 shadow-sm">
            <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Baik</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $lab->barangs->sum('jumlah_baik') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-amber-100 p-4 shadow-sm">
            <p class="text-xs font-bold text-amber-500 uppercase tracking-wider">Rusak Ringan</p>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $lab->barangs->sum('jumlah_rusak_ringan') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-rose-100 p-4 shadow-sm">
            <p class="text-xs font-bold text-rose-500 uppercase tracking-wider">Rusak Berat</p>
            <p class="text-2xl font-bold text-rose-600 mt-1">{{ $lab->barangs->sum('jumlah_rusak_berat') }}</p>
        </div>
    </div>

    {{-- Tabel Daftar Barang --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-100">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Daftar Barang di Ruangan Ini</h4>
                <div class="flex flex-wrap items-center gap-2">
                    {{-- Column Toggle --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center px-3.5 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Kolom
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-slate-200 z-50 p-3 max-h-80 overflow-y-auto">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 px-1">Tampilkan Kolom</p>
                            <template x-for="col in allColumns" :key="col.key">
                                <label class="flex items-center py-1.5 px-1 hover:bg-slate-50 rounded-lg cursor-pointer">
                                    <input type="checkbox" :checked="columns.includes(col.key)" @change="toggleColumn(col.key)" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500 mr-2.5">
                                    <span class="text-sm text-slate-700" x-text="col.label"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                    {{-- Tambah Barang --}}
                    <a href="{{ route('barangs.create', ['lokasi_type' => 'lab', 'lokasi_id' => $lab->id, 'redirect_to' => route('labs.show', $lab)]) }}" class="inline-flex items-center px-3.5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Barang
                    </a>
                    {{-- Export --}}
                    <a href="{{ route('labs.export-barang', $lab) }}" class="inline-flex items-center px-3.5 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Export
                    </a>
                    {{-- Import --}}
                    <button @click="showImport = true" class="inline-flex items-center px-3.5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Import
                    </button>
                </div>
            </div>

            {{-- Search --}}
            <div class="mt-4 flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" x-model="search" placeholder="Cari nama barang, merk, kode..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400">
                </div>
                <button @click="search=''" x-show="search"
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
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">No</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('nama_barang')">Nama Barang</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('merk_model')">Merk/Model</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('no_seri')">No. Seri Pabrik</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('ukuran')">Ukuran</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('bahan')">Bahan</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('tahun')">Tahun</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('kode')">Nomor Kode</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center" x-show="columns.includes('jumlah')">Jumlah</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right" x-show="columns.includes('harga')">Harga Perolehan</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('keadaan')">Keadaan</th>
                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider" x-show="columns.includes('mutasi')">Ket. Mutasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($lab->barangs as $barang)
                <tr class="hover:bg-blue-50/50 transition-colors"
                    x-show="rowVisible('{{ addslashes($barang->nama_barang) }}', '{{ addslashes($barang->merk_model) }}', '{{ addslashes($barang->kode_barang) }}')"
                    x-transition.opacity>
                    <td class="px-4 py-4 text-sm text-slate-600 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-4 text-sm font-medium text-slate-800" x-show="columns.includes('nama_barang')">{{ $barang->nama_barang }}</td>
                    <td class="px-4 py-4 text-sm text-slate-600" x-show="columns.includes('merk_model')">{{ $barang->merk_model ?? '-' }}</td>
                    <td class="px-4 py-4 text-xs font-mono text-slate-500" x-show="columns.includes('no_seri')">{{ $barang->no_seri_pabrik ?? '-' }}</td>
                    <td class="px-4 py-4 text-sm text-slate-600" x-show="columns.includes('ukuran')">{{ $barang->ukuran ?? '-' }}</td>
                    <td class="px-4 py-4 text-sm text-slate-600" x-show="columns.includes('bahan')">{{ $barang->bahan ?? '-' }}</td>
                    <td class="px-4 py-4 text-sm text-slate-600" x-show="columns.includes('tahun')">{{ $barang->tahun_pembuatan ?? '-' }}</td>
                    <td class="px-4 py-4 text-xs font-mono font-semibold text-slate-500" x-show="columns.includes('kode')">{{ $barang->kode_barang }}</td>
                    <td class="px-4 py-4 text-sm text-slate-600 text-center" x-show="columns.includes('jumlah')">{{ $barang->jumlah_total }}</td>
                    <td class="px-4 py-4 text-sm text-slate-600 text-right whitespace-nowrap" x-show="columns.includes('harga')">
                        @if($barang->harga_perolehan)
                            Rp {{ number_format($barang->harga_perolehan, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-4" x-show="columns.includes('keadaan')">
                        <div class="flex gap-1 flex-wrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">B:{{ $barang->jumlah_baik }}</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">RR:{{ $barang->jumlah_rusak_ringan }}</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">RB:{{ $barang->jumlah_rusak_berat }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-xs text-slate-500 max-w-[120px] truncate" x-show="columns.includes('mutasi')">{{ $barang->keterangan_mutasi ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="px-6 py-12 text-center text-slate-400 italic">
                        Belum ada barang di lab ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 text-xs text-slate-500">
            Total: {{ $lab->barangs->count() }} barang
        </div>
    </div>

    {{-- Import Modal --}}
    <div x-show="showImport" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-transition.opacity>
        <div @click.away="showImport = false" class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md p-6 mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Import Barang ke {{ $lab->nama }}</h3>
                <button @click="showImport = false" class="p-1 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('labs.import-barang', $lab) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">File Excel (.xlsx)</label>
                    <input type="file" name="file" accept=".xlsx,.xls" required class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-xl p-1.5">
                </div>
                <div class="mb-4 p-3 bg-amber-50 border border-amber-100 rounded-xl">
                    <p class="text-xs text-amber-700">
                        <strong>Format:</strong> Pastikan kolom sesuai template.
                        <a href="{{ route('labs.template') }}" class="underline text-blue-600 hover:text-blue-800 ml-1">Download Template</a>
                    </p>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="showImport = false" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function labShowTable() {
    return {
        search: '',
        showImport: false,
        allColumns: [
            { key: 'nama_barang', label: 'Nama Barang' },
            { key: 'merk_model', label: 'Merk/Model' },
            { key: 'no_seri', label: 'No. Seri Pabrik' },
            { key: 'ukuran', label: 'Ukuran' },
            { key: 'bahan', label: 'Bahan' },
            { key: 'tahun', label: 'Tahun' },
            { key: 'kode', label: 'Nomor Kode' },
            { key: 'jumlah', label: 'Jumlah' },
            { key: 'harga', label: 'Harga Perolehan' },
            { key: 'keadaan', label: 'Keadaan' },
            { key: 'mutasi', label: 'Ket. Mutasi' },
        ],
        columns: JSON.parse(localStorage.getItem('lab_show_columns') || 'null') || ['nama_barang','merk_model','no_seri','ukuran','bahan','tahun','kode','jumlah','harga','keadaan','mutasi'],
        toggleColumn(key) {
            if (this.columns.includes(key)) {
                this.columns = this.columns.filter(c => c !== key);
            } else {
                this.columns.push(key);
            }
            localStorage.setItem('lab_show_columns', JSON.stringify(this.columns));
        },
        rowVisible(nama, merk, kode) {
            if (!this.search) return true;
            const q = this.search.toLowerCase();
            return (nama + ' ' + merk + ' ' + kode).toLowerCase().includes(q);
        }
    }
}
</script>
@endsection
