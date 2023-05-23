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
        Schema::create('detail_quote_visualizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("detail_quote_available_id")->constrained("detail_quote_availables");
            $table->foreignId("types_quote_id")->constrained("types_quotes");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_quote_visualizes');
    }
};
