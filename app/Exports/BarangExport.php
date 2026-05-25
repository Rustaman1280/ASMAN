<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->with(['ruangans'])->get();
    }

    public function headings(): array
    {
        return [
            'No.',
            'Kode Barang/ ID Barang',
            'Reg.',
            'Nama Barang Sesuai Permendagri 108',
            'Nama Barang',
            'Alamat',
            'Merk / Tipe',
            'No. Sertifikat / No. Pabrik / No. Chasis / No. Mesin / No. Polisi/ No. Ruas Jalan/ No. Daerah Irigasi',
            'Cara Perolehan / Status Barang',
            'Bulan Perolehan',
            'Tahun Perolehan',
            'Ukuran Barang / Konstruksi (P,SP,D)',
            'Keadaan Barang (B,KB,RB)',
            'Volume',
            'Nilai Perolehan',
            'Harga Satuan',
            'Nilai Perolehan2',
            'Koreksi',
            'Umur Ekonomis',
            'Penyusutan s.d Tahun Sebelumnya',
            'Beban Penyusutan per Bulan',
            'Umur Ekonomis2',
            'Bulan Manfaat s.d 31 Des 2024',
            'Akum Peny s.d 31 Des 2024',
            'Koreksi Pembulatan',
            'Masa Manfaat s.d 31 Mar 2025',
            'Beban Penyusutan 2025',
            'Akum Peny s.d 2025',
            'Nilai Buku',
            'Nama OPD',
            'Sub OPD',
            'Keterangan/ Tgl. Buku/ Tahun Sensus'
        ];
    }

    public function map($barang): array
    {
        static $no = 0;
        $no++;

        $keadaan = 'B';
        if ($barang->jumlah_rusak_berat > 0) $keadaan = 'RB';
        elseif ($barang->jumlah_rusak_ringan > 0) $keadaan = 'KB';

        $volume = $barang->jumlah_total;
        $hargaSatuan = $barang->harga_perolehan ?? 0;
        $nilaiPerolehan = $volume * $hargaSatuan;

        return [
            $no,
            $barang->kode_barang,
            $barang->reg ?? '', // Reg.
            $barang->kategori ?? $barang->nama_barang, // Nama Barang Sesuai Permendagri 108
            $barang->nama_barang,
            $barang->alamat ?? 'SMKN 1 GARUT', // Alamat
            $barang->merk_model ?? '',
            $barang->no_seri_pabrik ?? '',
            $barang->cara_perolehan ?? 'BOS REGULER', // Cara Perolehan
            $barang->bulan_perolehan ?? '', // Bulan Perolehan
            $barang->tahun_pembuatan ?? '',
            $barang->ukuran ?? '',
            $keadaan,
            $volume,
            $nilaiPerolehan,
            $hargaSatuan,
            $nilaiPerolehan, // Nilai Perolehan2
            $barang->koreksi ?? 0, // Koreksi
            $barang->masa_manfaat_bulan ? ($barang->masa_manfaat_bulan / 12) : '', // Umur Ekonomis
            $barang->penyusutan_sd_tahun_sebelumnya ?? 0, // Penyusutan s.d Tahun Sebelumnya
            $barang->beban_penyusutan_per_bulan ?? 0, // Beban Penyusutan per Bulan
            $barang->masa_manfaat_bulan ? ($barang->masa_manfaat_bulan / 12) : '', // Umur Ekonomis2
            $barang->bulan_manfaat_sd_des_2024 ?? 0, // Bulan Manfaat s.d 31 Des 2024
            $barang->akum_peny_sd_des_2024 ?? 0, // Akum Peny s.d 31 Des 2024
            $barang->koreksi_pembulatan ?? 0, // Koreksi Pembulatan
            $barang->masa_manfaat_sd_mar_2025 ?? 0, // Masa Manfaat s.d 31 Mar 2025
            $barang->beban_penyusutan_2025 ?? 0, // Beban Penyusutan 2025
            $barang->akum_peny_sd_2025 ?? 0, // Akum Peny s.d 2025
            $barang->nilai_buku ?? $nilaiPerolehan, // Nilai Buku
            $barang->nama_opd ?? 'DINAS PENDIDIKAN',
            $barang->sub_opd ?? 'SMKN 1 GARUT',
            $barang->keterangan_mutasi ?? 'KABUPATEN GARUT'
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
