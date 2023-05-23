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
        Schema::create('third_type_thirds', function (Blueprint $table) {
            $table->id();
            $table->foreignId("third_id")->constrained("thirds");
            $table->foreignId("type_of_third_id")->constrained("type_of_thirds");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('third_type_thirds');
    }
};
