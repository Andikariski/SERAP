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
    Schema::create('tbl_rap_status_options', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->integer('urutan')->default(0);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('tbl_rap_status_options');
}
};
