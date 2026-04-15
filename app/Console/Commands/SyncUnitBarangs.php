<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncUnitBarangs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-unit-barangs';
    protected $description = 'Sync UnitBarang rows according to aggregate counts in Barang table';

    public function handle()
    {
        $barangs = \App\Models\Barang::all();
        $count = 0;
        foreach ($barangs as $b) {
            if ($b->unitBarangs()->count() >= ($b->jumlah_baik + $b->jumlah_rusak_ringan + $b->jumlah_rusak_berat)) continue;
            
            $kondisis = array_merge(
                array_fill(0, $b->jumlah_baik, 'baik'),
                array_fill(0, $b->jumlah_rusak_ringan, 'rusak_ringan'),
                array_fill(0, $b->jumlah_rusak_berat, 'rusak_berat')
            );
            
            $existingCount = $b->unitBarangs()->count();
            
            foreach ($kondisis as $i => $k) {
                if ($i < $existingCount) continue;
                $kodeUnit = $b->kode_barang . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
                \App\Models\UnitBarang::create([
                    'barang_id' => $b->id,
                    'kode_unit' => $kodeUnit,
                    'kondisi' => $k
                ]);
                $count++;
            }
        }
        $this->info("Synced {$count} new UnitBarang records.");
    }
}
