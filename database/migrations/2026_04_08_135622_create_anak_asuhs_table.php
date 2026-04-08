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
        Schema::create('anak_asuhs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_lahir'); 
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('pendidikan');
            $table->string('bakat')->nullable(); 
            $table->text('medis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_asuhs');
    }
};
