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
        Schema::create('quote_imposed_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId("iva_id")->constrained("tax_charges");
            $table->string("name");
            $table->string("value");
            $table->string("iva");
            $table->foreignId("quote_id")->constrained("quotes");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_imposed_charges');
    }
};
