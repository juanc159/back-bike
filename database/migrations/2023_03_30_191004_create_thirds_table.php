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
        Schema::create('thirds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('trade_name')->nullable();//nombre comercial
            $table->string('identifications');
            $table->string('branch_code')->nullable();//codigo sucursal
            $table->foreignId('departament_id')->constrained("departaments");
            $table->foreignId('city_id')->constrained("cities");
            $table->string('address')->nullable();
            $table->string('contact_name');
            $table->string('contact_last_name')->nullable();
            $table->string('email_fac');
            $table->string('indicative')->nullable();
            $table->string('phone_fac')->nullable();
            $table->string('postal_code')->nullable();//codigo postal
            $table->longText('observations')->nullable();
            $table->boolean('state')->default(1);
            $table->foreignId("basic_data_types_id")->constrained("basic_data_types");//tipo
            $table->foreignId("type_identifications_id")->nullable()->constrained("type_identifications");//tipo de indentificacion 
            $table->foreignId("type_regime_ivas_id")->nullable()->constrained("type_regime_ivas");//tipo regimen
            $table->foreignId("seller_id")->nullable()->constrained("users");//vendedor
            $table->foreignId("debt_seller_id")->nullable()->constrained("users");//cobrador
            $table->foreignId("company_id")->nullable()->constrained("companies");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thirds');
    }
};
