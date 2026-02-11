@extends('layouts.admin')

@section('title', 'Tambah Barang')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center">
        <a href="{{ route('barangs.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h3 class="text-lg font-semibold text-slate-700">Form Barang Baru</h3>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm p-8">
        <form action="{{ route('barangs.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kode_barang" class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang</label>
                        <input type="text" name="kode_barang" id="kode_barang" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Contoh: BRG-001" required>
                        @error('kode_barang') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="nama_barang" class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Contoh: Laptop Asus" required>
                        @error('nama_barang') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="stock_barang" class="block text-sm font-semibold text-slate-700 mb-2">Stock</label>
                        <input type="number" name="stock_barang" id="stock_barang" min="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Jumlah barang" required>
                        @error('stock_barang') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="supplier_id" class="block text-sm font-semibold text-slate-700 mb-2">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi Barang</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <select name="lokasi_type" id="lokasi_type" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" onchange="updateLokasiOptions()" required>
                                <option value="">-- Tipe Lokasi --</option>
                                <option value="kelas">Kelas</option>
                                <option value="lab">Laboratorium</option>
                            </select>
                            @error('lokasi_type') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <select name="lokasi_id" id="lokasi_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" required disabled>
                                <option value="">-- Pilih Lokasi --</option>
                            </select>
                            @error('lokasi_id') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="detail_barang" class="block text-sm font-semibold text-slate-700 mb-2">Detail Barang</label>
                    <textarea name="detail_barang" id="detail_barang" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Keterangan tambahan..."></textarea>
                    @error('detail_barang') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                    <a href="{{ route('barangs.index') }}" class="px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-all">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">Simpan Barang</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const kelasOptions = [
        @foreach($kelas as $k)
            { id: "{{ $k->id }}", nama: "{{ $k->nama }}" },
        @endforeach
    ];

    const labOptions = [
        @foreach($labs as $l)
            { id: "{{ $l->id }}", nama: "{{ $l->nama }}" },
        @endforeach
    ];

    function updateLokasiOptions() {
        const typeSelect = document.getElementById('lokasi_type');
        const locationSelect = document.getElementById('lokasi_id');
        const selectedType = typeSelect.value;
        
        locationSelect.innerHTML = '<option value="">-- Pilih Lokasi --</option>';
        locationSelect.disabled = true;

        let options = [];
        if (selectedType === 'kelas') {
            options = kelasOptions;
        } else if (selectedType === 'lab') {
            options = labOptions;
        }

        if (options.length > 0) {
            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt.id;
                option.textContent = opt.nama;
                locationSelect.appendChild(option);
            });
            locationSelect.disabled = false;
        }
    }
</script>
@endsection
