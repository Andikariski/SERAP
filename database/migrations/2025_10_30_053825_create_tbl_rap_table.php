<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_rap', function (Blueprint $table) {
           $table->id();

            // Foreign keys (nullable agar aman ketika data relasi dihapus)
            $table->unsignedBigInteger('fkid_sub_kegiatan')->nullable();
            $table->unsignedBigInteger('fkid_aktivitas_utama')->nullable();
            $table->unsignedBigInteger('fkid_opd')->nullable();

            // Data utama
            $table->string('jenis_kegiatan')->nullable();
            $table->integer('volume_tahun_berjalan')->nullable();
            $table->integer('volume_silpa_melanjutkan')->nullable();
            $table->integer('volume_silpa_efisiensi')->nullable();
            $table->integer('volume_total')->nullable();
            $table->string('satuan_volume')->nullable();
            $table->bigInteger('pagu_tahun_berjalan')->nullable();
            $table->bigInteger('pagu_silpa_melanjutkan')->nullable();
            $table->bigInteger('pagu_silpa_efisiensi')->nullable();
            $table->bigInteger('pagu_total')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('titik_lokasi')->nullable();
            $table->string('sasaran')->nullable();
            $table->string('ppsb')->nullable();
            $table->string('penerima_manfaat')->nullable();
            $table->string('sinergi_dana_lain')->nullable();
            $table->string('multiyears')->nullable();
            $table->date('jadwal_awal')->nullable();
            $table->date('jadwal_akhir')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('validasi', ['Menunggu', 'Perbaikan','Disetujui'])->default('Menunggu');
            $table->string('data_rka')->nullable();
            $table->string('data_kak')->nullable();
            $table->string('data_lainya')->nullable();
            
            // Denormalisasi Data Sub Kegiatan
            $table->string('kewenangan')->nullable();
            $table->string('kode_klasifikasi')->nullable();
            $table->string('sub_kegiatan')->nullable();
            $table->string('kinerja')->nullable();
            $table->string('indikator')->nullable();
            $table->string('satuan')->nullable();
            $table->string('klasifikasi_belanja')->nullable();

            // Denormalisasi Data Aktivitas Utama
            $table->string('aktivitas_utama')->nullable();
            $table->string('tema_pembangunan')->nullable();
            $table->string('program_prioritas')->nullable();
            $table->string('target_keluaran_strategis')->nullable();
            

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('fkid_sub_kegiatan')
                  ->references('id')->on('tbl_sub_kegiatan')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('fkid_aktivitas_utama')
                  ->references('id')->on('tbl_aktivitas_utama')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('fkid_opd')
                  ->references('id')->on('tbl_opd')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_rap');
    }
};
