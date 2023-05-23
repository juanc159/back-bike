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
        Schema::create('charges_and_discounts_invoices', function (Blueprint $table) {
            $table->id();
            $table->boolean('in_use');
            $table->string('name');
            $table->foreignId("company_id")->constrained("companies");//Compañia
            $table->foreignId("type_id")->constrained("type_charge_and_discounts");
            $table->foreignId("type_receipt_invoices_id")->constrained("types_receipt_invoices");
            $table->string('fee');
            //Cuentas contables
            $table->unsignedBigInteger("ledgerAccount_id");
            $table->string("ledgerAccount_table")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges_and_discounts_invoices');
    }
};
