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
        Schema::create('income_vehicle_thirds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('income_vehicle_id')->nullable()->constrained('income_vehicles');
            $table->foreignId('third_id')->nullable()->constrained('thirds');
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_vehicle_thirds');
    }
};
