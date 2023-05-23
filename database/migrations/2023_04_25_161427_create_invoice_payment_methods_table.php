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
        Schema::create('invoice_payment_methods', function (Blueprint $table) {
            $table->id();
            //Cuentas contables
            $table->unsignedBigInteger("ledgerAccount_id");
            $table->string("table")->nullable();
            $table->string('amount');
            $table->foreignId("invoice_id")->constrained("invoices");//Factura->reg.general
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payment_methods');
    }
};
