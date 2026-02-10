@extends('layouts.admin')

@section('title', 'Daftar Kelas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-slate-700">Data Kelas</h3>
    <a href="{{ route('kelas.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center shadow-lg shadow-blue-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Kelas
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jurusan</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($kelas as $item)
            <tr class="hover:bg-blue-50/50 transition-colors group">
                <td class="px-6 py-4 text-sm text-slate-600 tracking-tight">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-slate-800">{{ $item->nama }}</span>
                        <span class="text-xs text-slate-500">Tingkat {{ $item->tingkat }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-slate-600">{{ $item->jurusan->nama }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('kelas.edit', $item) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-white rounded-lg border border-transparent hover:border-blue-100 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('kelas.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg border border-transparent hover:border-rose-100 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            @if($kelas->isEmpty())
            <tr>
                <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">
                    Belum ada data kelas.
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
