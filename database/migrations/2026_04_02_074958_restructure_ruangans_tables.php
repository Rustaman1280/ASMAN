<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First drop old location references in case we had any strict checks, 
        // though morphs usually don't have constraints. We'll simply let them be orphaned or update later.
        
        // Drop old tables
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('labs');

        // Create new table
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('jenis_ruangan');
            $table->string('nama');
            $table->string('tingkat')->nullable();
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangans');
        
        // Re-creating the old ones as basic schema in case of rollback
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('tingkat');
            $table->timestamps();
        });

        Schema::create('labs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->timestamps();
        });
    }
};
