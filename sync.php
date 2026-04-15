<?php
$barangs = App\Models\Barang::all();

$barangs = App\Models\Barang::all();
foreach ($barangs as $b) {
    if ($b->unitBarangs()->count() > 0) continue;
    
    $kondisis = array_merge(
        array_fill(0, $b->jumlah_baik, 'baik'),
        array_fill(0, $b->jumlah_rusak_ringan, 'rusak_ringan'),
        array_fill(0, $b->jumlah_rusak_berat, 'rusak_berat')
    );
    
    foreach ($kondisis as $i => $k) {
        $kodeUnit = $b->kode_barang . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
        App\Models\UnitBarang::create([
            'barang_id' => $b->id,
            'kode_unit' => $kodeUnit,
            'kondisi' => $k
        ]);
        echo "Created Unit $kodeUnit\n";
    }
}
echo "Done.\n";
