<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Barang',
            'Merk/Model',
            'No. Seri Pabrik',
            'Ukuran',
            'Bahan',
            'Tahun Pembuatan',
            'Nomor Kode Barang',
            'Jumlah Baik',
            'Jumlah Rusak Ringan',
            'Jumlah Rusak Berat',
            'Jumlah Total',
            'Harga Perolehan',
            'Keterangan Mutasi',
            'Supplier',
            'Lokasi',
        ];
    }

    public function map($barang): array
    {
        static $no = 0;
        $no++;

        $lokasi = '-';
        if ($barang->ruangans->isNotEmpty()) {
            $lokasi = $barang->ruangans->map(function ($r) {
                return "{$r->nama} ({$r->jenis_ruangan}) ×{$r->pivot->jumlah}";
            })->implode(', ');
        }

        return [
            $no,
            $barang->nama_barang,
            $barang->merk_model ?? '',
            $barang->no_seri_pabrik ?? '',
            $barang->ukuran ?? '',
            $barang->bahan ?? '',
            $barang->tahun_pembuatan ?? '',
            $barang->kode_barang,
            $barang->jumlah_baik,
            $barang->jumlah_rusak_ringan,
            $barang->jumlah_rusak_berat,
            $barang->jumlah_total,
            $barang->harga_perolehan ?? 0,
            $barang->keterangan_mutasi ?? '',
            $barang->supplier->nama_supplier ?? '-',
            $lokasi,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2563EB'],
                ],
            ],
        ];
    }
}
