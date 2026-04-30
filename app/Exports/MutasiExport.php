<?php

namespace App\Exports;

use App\Models\Mutasi;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MutasiExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
            'Tanggal',
            'Jenis Mutasi',
            'Barang',
            'Unit Barang',
            'Detail Perubahan',
            'Keterangan',
            'Dicatat Oleh',
        ];
    }

    public function map($mutasi): array
    {
        static $no = 0;
        $no++;

        $detail = '';
        if ($mutasi->jenis_mutasi === 'penambahan') {
            $detail = "Menjadi: " . strtoupper($mutasi->status_akhir) . " di " . ($mutasi->ruanganAkhir->nama ?? '-');
        } elseif ($mutasi->jenis_mutasi === 'ubah_status') {
            $detail = strtoupper($mutasi->status_awal ?? '-') . " -> " . strtoupper($mutasi->status_akhir ?? '-');
        } elseif ($mutasi->jenis_mutasi === 'ubah_lokasi') {
            $detail = ($mutasi->ruanganAwal->nama ?? '-') . " -> " . ($mutasi->ruanganAkhir->nama ?? '-');
        } elseif ($mutasi->jenis_mutasi === 'peminjaman') {
            $detail = "Peminjam: " . $mutasi->nama_peminjam . " (Kembali: " . ($mutasi->tanggal_kembali ?? '-') . ")";
        } elseif ($mutasi->jenis_mutasi === 'pengembalian') {
            $detail = "Dikembalikan";
        } elseif ($mutasi->jenis_mutasi === 'penghapusan') {
            $detail = "Dihapus dari sistem";
        }

        return [
            $no,
            $mutasi->tanggal_mutasi,
            ucwords(str_replace('_', ' ', $mutasi->jenis_mutasi)),
            $mutasi->barang->nama_barang ?? '-',
            $mutasi->unitBarang->kode_unit ?? '-',
            $detail,
            $mutasi->keterangan ?? '-',
            $mutasi->user->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '10B981'], // Emerald 500 for Mutasi
                ],
            ],
        ];
    }
}
