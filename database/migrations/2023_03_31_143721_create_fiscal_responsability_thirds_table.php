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
        Schema::create('fiscal_responsability_thirds', function (Blueprint $table) {
            $table->id();
            $table->foreignId("fiscal_responsabilities_id")->constrained("fiscal_responsabilities");
            $table->foreignId("third_id")->constrained("thirds");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiscal_responsability_thirds');
    }
};
