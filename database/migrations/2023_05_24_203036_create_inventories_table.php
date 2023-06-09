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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies'); 
            $table->string("reference");
            $table->string("brand");
            $table->string("model");
            $table->string("color");
            $table->string("plate");
            $table->string("registrationSite");
            $table->string("purchaseValue");
            $table->enum("vehicleType",["moto","carro"]);
            $table->enum("state",["Ingresado","Separado","Vendido"]);
            $table->string("days");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
