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
       Schema::create('tbl_pagu_opd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fkid_opd');
            $table->bigInteger('pagu_SG')->default(0);
            $table->bigInteger('pagu_BG')->default(0);
            $table->bigInteger('pagu_DTI')->default(0);
            $table->bigInteger('pagu_SiLPA_Melanjutkan')->default(0);
            $table->bigInteger('pagu_SiLPA_Efisiensi')->default(0);
            $table->year('tahun_pagu');
            $table->timestamps();

            $table->foreign('fkid_opd')->references('id')->on('tbl_opd')->onDelete('cascade');
            $table->unique(['fkid_opd', 'tahun_pagu']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pagu');
    }
};
