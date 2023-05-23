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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("last_name");
            $table->foreignId("type_identifications_id")->constrained("type_identifications");
            $table->string("document_number");
            $table->string("email");
            $table->foreignId("company_id")->constrained("companies");
            $table->string("cellPhoneNumber");
            $table->string("residenceAddress");
            $table->foreignId("residenceDepartament_id")->constrained("departaments");
            $table->foreignId("residenceCity_id")->constrained("cities");
            $table->foreignId("officeDepartament_id")->constrained("departaments");
            $table->foreignId("officeCity_id")->constrained("cities");
            $table->string("residenceOffice");
            $table->foreignId("paymentMethod_id")->constrained("payment_methods");
            $table->foreignId("kind_procedure_id")->nullable()->constrained("banks");
            $table->string("cellPhoneNumberPay")->nullable();
            $table->foreignId("banking_entity_id")->nullable()->constrained("banks");
            $table->string("account_number")->nullable();
            $table->foreignId("account_type_id")->nullable()->constrained("account_types");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
