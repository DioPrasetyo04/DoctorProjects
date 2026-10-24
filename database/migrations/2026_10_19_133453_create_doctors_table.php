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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('photo');
            $table->text('about');
            $table->integer('yoe'); //years of experience
            $table->foreignId('specialist_id')->constrained('specialists', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('hospital_id')->constrained('hospitals', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('gender');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
