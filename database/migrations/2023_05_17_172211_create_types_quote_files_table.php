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
        Schema::create('types_quote_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId("typesQuote_id")->constrained("types_quotes");
            $table->string("name");
            $table->string("path");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types_quote_files');
    }
};
