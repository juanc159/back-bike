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
        Schema::create('quote_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->constrained("products");//Productos
            $table->string('description')->nullable();
            $table->string('quantity');
            $table->string('unit_value');
            $table->string('discount_rate');
            $table->foreignId("tax_charge")->constrained("tax_charges");//Productos
            $table->foreignId("withholding_tax")->constrained("withholding_taxes");//Productos
            $table->foreignId("quote_id")->constrained("quotes");//Factura->reg.general
            $table->string("value_total")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_products');
    }
};
