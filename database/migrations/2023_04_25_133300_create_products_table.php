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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->foreignId("typeProduct_id")->constrained("type_products");
            $table->string("code");
            $table->string("ivaIncluded");
            $table->string("name");
            $table->string("price");
            $table->foreignId("taxCharge_id")->constrained("tax_charges");
            $table->string("unitOfMeasurement_id")->nullable();
            $table->string("unitOfMeasurement")->nullable();
            $table->string("factoryReference")->nullable();
            $table->string("barcode")->nullable();
            $table->string("description")->nullable();
            $table->foreignId("taxClassification_id")->nullable()->constrained("tax_charges");
            $table->string("withholdingTaxes_id")->nullable();
            $table->string("valueInpoconsumo")->nullable();
            $table->string("applyConsumptionTax")->nullable();
            $table->string("model")->nullable();
            $table->string("tariffCode")->nullable();
            $table->string("mark")->nullable();
            $table->boolean("state")->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
