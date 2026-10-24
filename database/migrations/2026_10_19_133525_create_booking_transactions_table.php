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
        Schema::create('booking_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('status');
            // indexing digunakan untuk optimalize query di database untuk mempercepat hasil query ketika user melakukan pencarian
            $table->date('started_at')->index();
            $table->time('time_at');
            $table->integer('sub_total');
            $table->integer('tax_total');
            $table->integer('grand_total');
            $table->string('proof');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_transactions');
    }
};
