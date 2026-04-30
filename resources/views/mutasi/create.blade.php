@extends('layouts.admin')

@section('title', 'Buat Mutasi Baru')

@section('content')
<div class="max-w-3xl mx-auto" x-data="mutasiForm()">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-semibold text-slate-800">Form Mutasi Barang</h3>
            <p class="text-sm text-slate-500 mt-1">Catat perpindahan, perubahan status, atau penambahan unit barang.</p>
        </div>

        <form action="{{ route('mutasi.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Jenis Mutasi & Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Mutasi <span class="text-rose-500">*</span></label>
                    <select name="jenis_mutasi" x-model="jenisMutasi" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                        <option value="">Pilih Jenis Mutasi...</option>
                        <option value="penambahan">Penambahan Unit Baru</option>
                        <option value="ubah_status">Ubah Status / Kondisi</option>
                        <option value="ubah_lokasi">Pindah Lokasi</option>
                        <option value="peminjaman">Peminjaman Barang</option>
                        <option value="pengembalian">Pengembalian Barang</option>
                        <option value="penghapusan">Penghapusan Barang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Mutasi <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_mutasi" value="{{ date('Y-m-d') }}" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                </div>
            </div>

            <!-- Pilih Barang (Hanya untuk Penambahan) -->
            <div x-show="jenisMutasi === 'penambahan'" x-cloak class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl space-y-4">
                <div class="flex justify-between items-center">
                    <h4 class="text-sm font-bold text-emerald-800 uppercase tracking-wider">Detail Penambahan Unit</h4>
                    <a href="{{ route('barangs.create', ['redirect_to' => url()->current() . '?jenis=penambahan']) }}" class="text-xs bg-emerald-600 text-white px-3 py-1.5 rounded-lg hover:bg-emerald-700 transition-all font-semibold shadow-sm">
                        + Tambah Barang Baru
                    </a>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Tipe Barang <span class="text-rose-500">*</span></label>
                    <select name="barang_id" :required="jenisMutasi === 'penambahan'"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                        <option value="">Pilih Barang...</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}">{{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi Awal <span class="text-rose-500">*</span></label>
                        <select name="kondisi" :required="jenisMutasi === 'penambahan'"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi Penempatan</label>
                        <select name="ruangan_id"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                            <option value="">Pilih Ruangan...</option>
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}">{{ $ruangan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Unit <span class="text-rose-500">*</span></label>
                        <input type="number" name="jumlah_unit" min="1" value="1" :required="jenisMutasi === 'penambahan'"
                               class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Pilih Unit (Untuk selain Penambahan) -->
            <div x-show="jenisMutasi !== '' && jenisMutasi !== 'penambahan'" x-cloak class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Unit Barang <span class="text-rose-500">*</span></label>
                    <select name="unit_barang_id" x-model="selectedUnit" @change="updateUnitInfo" :required="jenisMutasi !== '' && jenisMutasi !== 'penambahan'"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                        <option value="">Pilih Unit...</option>
                        @foreach($unitBarangs as $unit)
                            <option value="{{ $unit->id }}" data-kondisi="{{ $unit->kondisi }}" data-ruangan="{{ $unit->ruangan_id }}">
                                {{ $unit->kode_unit }} - {{ $unit->barang->nama_barang }} ({{ $unit->kondisi }}, Lokasi: {{ $unit->ruangan->nama ?? 'Belum ditempatkan' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Info Unit Terpilih -->
                <div x-show="selectedUnit !== ''" class="flex items-center gap-4 text-sm bg-white p-3 rounded-lg border border-slate-200">
                    <div>Status Saat Ini: <strong x-text="currentKondisi" class="uppercase text-amber-600"></strong></div>
                    <div class="w-px h-4 bg-slate-300"></div>
                    <div>Lokasi Saat Ini: <strong x-text="currentRuangan"></strong></div>
                </div>

                <!-- Fields for Ubah Status -->
                <div x-show="jenisMutasi === 'ubah_status'" class="pt-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status / Kondisi Baru <span class="text-rose-500">*</span></label>
                    <select name="status_akhir" :required="jenisMutasi === 'ubah_status'"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                        <option value="">Pilih Status Baru...</option>
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                    </select>
                </div>

                <!-- Fields for Ubah Lokasi -->
                <div x-show="jenisMutasi === 'ubah_lokasi'" class="pt-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pindah Ke Ruangan <span class="text-rose-500">*</span></label>
                    <select name="ruangan_akhir_id" :required="jenisMutasi === 'ubah_lokasi'"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                        <option value="">Pilih Ruangan Tujuan...</option>
                        @foreach($ruangans as $ruangan)
                            <option value="{{ $ruangan->id }}">{{ $ruangan->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Fields for Peminjaman -->
                <div x-show="jenisMutasi === 'peminjaman'" class="pt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Peminjam <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_peminjam" :required="jenisMutasi === 'peminjaman'" placeholder="Contoh: Budi Santoso"
                               class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kembali <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_kembali" :required="jenisMutasi === 'peminjaman'"
                               class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                    </div>
                </div>

                <!-- Info Penghapusan -->
                <div x-show="jenisMutasi === 'penghapusan'" class="pt-2 p-4 bg-rose-50 text-rose-700 rounded-xl border border-rose-200 text-sm font-medium">
                    Peringatan: Mutasi penghapusan akan menghapus unit barang ini dari sistem. Tindakan ini tidak dapat dibatalkan.
                </div>
            </div>

            <!-- Keterangan Umum -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan / Catatan</label>
                <textarea name="keterangan" rows="3" placeholder="Tulis catatan tambahan jika diperlukan..."
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all"></textarea>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-md transition-all">
                    Simpan Mutasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function mutasiForm() {
        return {
            jenisMutasi: '{{ $preselectedJenis ?? "" }}',
            selectedUnit: '{{ $preselectedUnitId ?? "" }}',
            currentKondisi: '',
            currentRuangan: '',
            
            init() {
                if (this.selectedUnit) {
                    // Slight delay to ensure DOM is ready
                    setTimeout(() => {
                        this.updateUnitInfo();
                    }, 100);
                }
            },

            updateUnitInfo() {
                if (!this.selectedUnit) {
                    this.currentKondisi = '';
                    this.currentRuangan = '';
                    return;
                }
                const selectEl = document.querySelector('select[name="unit_barang_id"]');
                const option = selectEl.options[selectEl.selectedIndex];
                if (option) {
                    this.currentKondisi = option.getAttribute('data-kondisi') || '-';
                    // We need actual ruangan name, we can just extract from option text or rely on a map.
                    // For simplicity, we just extract from the text which has "(... Lokasi: X)"
                    const text = option.textContent;
                    const match = text.match(/Lokasi:\s([^)]+)/);
                    this.currentRuangan = match ? match[1] : 'Belum ditempatkan';
                }
            }
        }
    }
</script>
@endsection
