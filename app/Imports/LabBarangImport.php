<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Lab;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class LabBarangImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $lab;
    private $supplierCache = [];

    public function __construct(Lab $lab)
    {
        $this->lab = $lab;
    }

    public function model(array $row)
    {
        $supplierName = trim($row['supplier'] ?? '');
        $supplierId = null;

        if ($supplierName) {
            if (!isset($this->supplierCache[$supplierName])) {
                $supplier = Supplier::firstOrCreate(['nama_supplier' => $supplierName]);
                $this->supplierCache[$supplierName] = $supplier->id;
            }
            $supplierId = $this->supplierCache[$supplierName];
        }

        return new Barang([
            'nama_barang'         => $row['nama_barang'],
            'merk_model'          => $row['merkmodel'] ?? $row['merk_model'] ?? null,
            'no_seri_pabrik'      => $row['no_seri_pabrik'] ?? null,
            'ukuran'              => $row['ukuran'] ?? null,
            'bahan'               => $row['bahan'] ?? null,
            'tahun_pembuatan'     => $row['tahun_pembuatan'] ?? null,
            'kode_barang'         => $row['nomor_kode_barang'] ?? $row['kode_barang'] ?? 'BRG-' . uniqid(),
            'jumlah_baik'         => (int) ($row['jumlah_baik'] ?? 0),
            'jumlah_rusak_ringan' => (int) ($row['jumlah_rusak_ringan'] ?? 0),
            'jumlah_rusak_berat'  => (int) ($row['jumlah_rusak_berat'] ?? 0),
            'harga_perolehan'     => $row['harga_perolehan'] ?? 0,
            'keterangan_mutasi'   => $row['keterangan_mutasi'] ?? null,
            'supplier_id'         => $supplierId,
            'lokasi_type'         => Lab::class,
            'lokasi_id'           => $this->lab->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_barang' => 'required|string|max:255',
            'jumlah_baik' => 'nullable|integer|min:0',
            'jumlah_rusak_ringan' => 'nullable|integer|min:0',
            'jumlah_rusak_berat' => 'nullable|integer|min:0',
            'harga_perolehan' => 'nullable|numeric|min:0',
        ];
    }
}
