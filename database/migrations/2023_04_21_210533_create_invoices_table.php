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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId("typesReceiptInvoice_id")->constrained("types_receipt_invoices");//tipo
            $table->foreignId("customer_id")->constrained("thirds");//cliente
            $table->foreignId("seller_id")->constrained("users");//vendedor
            $table->foreignId("currency_id")->constrained("currencies");//moneda
            $table->foreignId("company_id")->constrained("companies");//compañia
            $table->string("date_elaboration");
            $table->string("number");
            $table->string("gross_total");//total bruto
            $table->string("discount");//Descuento
            $table->string("subtotal");//sub total
            $table->string("net_total");//Total neto
            $table->string("total_form_payment");//Total formas de pago
            $table->string("observation")->nullable();//Total formas de pago
            $table->string('attachFile')->nullable();//adj archivo
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
