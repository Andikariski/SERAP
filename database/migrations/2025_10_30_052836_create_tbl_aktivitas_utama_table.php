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
        Schema::create('tbl_aktivitas_utama', function (Blueprint $table) {
            $table->id();
            $table->text('aktivitas_utama');
            $table->string('tema_pembangunan');
            $table->text('program_prioritas');
            $table->text('target_keluaran_strategis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_aktivitas_utama');
    }
};
