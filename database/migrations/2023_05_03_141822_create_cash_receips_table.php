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
        Schema::create('cash_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("crConfigurations_id")->constrained("cash_receipt_configurations");
            $table->foreignId("company_id")->constrained("companies");
            $table->string('number');
            $table->foreignId("customer_id")->constrained("thirds");
            $table->date('date_elaboration');
            $table->foreignId("perform_id")->constrained("perform_a_s");
            //Cuentas contables
            $table->unsignedBigInteger("auxSubAux_id");
            $table->string("auxSubAux_table")->nullable();
            $table->foreignId("currencie_id")->constrained("currencies");
            $table->string("received_value");
            $table->string("observation");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_receips');
    }
};
