@extends('layouts.admin')

@section('title', 'Tambah Ruangan')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm max-w-3xl mx-auto" x-data="ruanganForm('{{ $jenis }}')">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-semibold text-slate-800">Form Tambah Ruangan</h3>
    </div>
    <form action="{{ route('ruangans.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Kategori Area</label>
                <select name="kategori" x-model="kategori" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" required>
                    <option value="">Pilih Kategori Area...</option>
                    <template x-for="(items, kat) in categories" :key="kat">
                        <option :value="kat" x-text="kat"></option>
                    </template>
                </select>
                @error('kategori') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div x-show="kategori">
                <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Ruangan</label>
                <select name="jenis_ruangan" x-model="jenisR" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" required>
                    <option value="">Pilih Jenis Ruangan...</option>
                    <template x-for="jenis in currentJenis" :key="jenis">
                        <option :value="jenis" x-text="jenis"></option>
                    </template>
                </select>
                @error('jenis_ruangan') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Ruangan</label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Cth: X RPL 1, Lab Komputer A, Toilet Siswa Lt 1" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" required>
                @error('nama') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div x-show="needsTingkat">
                <label class="block text-sm font-medium text-slate-700 mb-2">Tingkat (Opsional)</label>
                <input type="text" name="tingkat" value="{{ old('tingkat') }}" placeholder="Cth: 10, IX" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                @error('tingkat') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div x-show="needsJurusan">
                <label class="block text-sm font-medium text-slate-700 mb-2">Jurusan (Opsional)</label>
                <select name="jurusan_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                    <option value="">-- Tidak Terikat Jurusan --</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                    @endforeach
                </select>
                @error('jurusan_id') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 flex items-center justify-end space-x-3">
            <a href="javascript:history.back()" class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors cursor-pointer">Simpan Ruangan</button>
        </div>
    </form>
</div>

<script>
function ruanganForm(initialJenis) {
    const cats = {
        'Area Pembelajaran & Akademik': ['Ruang Kelas', 'Ruang Laboratorium', 'Ruang Perpustakaan'],
        'Area Administrasi & Manajemen': ['Ruang Pimpinan', 'Ruang Guru', 'Ruang TU (Tata Usaha)'],
        'Area Penunjang Pendidikan & Siswa': ['Ruang OSIS', 'Ruang Konseling', 'Ruang UKS', 'Ruang Ibadah'],
        'Area Fasilitas Umum & Sanitasi': ['Ruang Toilet', 'Tempat Bermain / Olahraga', 'Ruang Gudang'],
        'Area Bangunan & Sirkulasi': ['Ruang Bangunan', 'Ruang Sirkulasi', 'Ruang Praktik']
    };

    let initialKat = '';
    if(initialJenis) {
        for(let k in cats) {
            if(cats[k].includes(initialJenis)) {
                initialKat = k;
                break;
            }
        }
    }

    return {
        categories: cats,
        kategori: initialKat,
        jenisR: initialJenis,
        init() {
            this.$watch('kategori', (val) => {
                if(val && !cats[val].includes(this.jenisR)) {
                    this.jenisR = '';
                }
            });
        },
        get currentJenis() {
            return this.kategori ? cats[this.kategori] : [];
        },
        get needsTingkat() {
            return ['Ruang Kelas'].includes(this.jenisR);
        },
        get needsJurusan() {
            return ['Ruang Kelas', 'Ruang Laboratorium', 'Ruang Guru', 'Ruang Praktik'].includes(this.jenisR);
        }
    }
}
</script>
@endsection
