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
        Schema::create('hospital_specialists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('specialist_id')->constrained('specialists', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            // sama seperti index() method unique dapat berbentuk array yang akan memberikan secara langsung ke hospital_id dan specialist_id duaa field sekaligus indexing untuk optimialize query saat pencarian
            $table->unique(['hospital_id', 'specialist_id']); //composite index yang menggabungkan hospital_id dan specialist_id sebagai index
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_specialists');
    }
};
