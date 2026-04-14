@extends('layouts.admin')

@section('title', 'Detail Ruangan')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-100 flex items-start justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-800">{{ $ruangan->nama }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $ruangan->jenis_ruangan }} • {{ $ruangan->kategori }}</p>
                @if($ruangan->jurusan)
                <p class="text-sm font-medium mt-3"><span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">Jurusan: {{ $ruangan->jurusan->nama }}</span></p>
                @endif
                @if($ruangan->tingkat)
                <p class="text-sm font-medium mt-1"><span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700">Tingkat: {{ $ruangan->tingkat }}</span></p>
                @endif
            </div>
            <div>
                <a href="{{ route('ruangans.index', ['jenis' => $ruangan->jenis_ruangan]) }}" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Kembali</a>
            </div>
        </div>
        
        <div class="p-6 bg-slate-50/50">
            <h4 class="text-base font-semibold text-slate-700 mb-4 border-b pb-2">Daftar Barang di Ruangan Ini</h4>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-100 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase">No</th>
                            <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase">Kode Barang</th>
                            <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase">Nama Barang</th>
                            <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase">Total</th>
                            <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase text-center">Kondisi (Baik/Ringan/Berat)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($ruangan->barangs as $brg)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $brg->kode_barang }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-slate-800">{{ $brg->nama_barang }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $brg->jumlah_total }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="mx-1 text-emerald-600 text-sm" title="Baik">{{ $brg->jumlah_baik }}</span>/
                                <span class="mx-1 text-amber-500 text-sm" title="Rusak Ringan">{{ $brg->jumlah_rusak_ringan }}</span>/
                                <span class="mx-1 text-rose-600 text-sm" title="Rusak Berat">{{ $brg->jumlah_rusak_berat }}</span>
                            </td>
                        </tr>
                        @endforeach
                        @if($ruangan->barangs->isEmpty())
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400 italic">Belum ada barang di ruangan ini.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
