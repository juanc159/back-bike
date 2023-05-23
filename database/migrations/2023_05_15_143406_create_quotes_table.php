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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId("typesQuote_id")->constrained("types_quotes");//cotizaciones
            $table->foreignId("customer_id")->constrained("thirds");//cliente
            $table->foreignId("seller_id")->constrained("users");//vendedor
            $table->foreignId("currency_id")->constrained("currencies");//moneda
            $table->foreignId("company_id")->constrained("companies");//compañia
            $table->date("date_elaboration");
            $table->date("date_expiration");
            $table->string("number");
            $table->string("gross_total");//total bruto
            $table->string("discount");//Descuento
            $table->string("subtotal");//sub total
            $table->string("net_total");//Total neto 
            $table->string("observation")->nullable();
            $table->foreignId("statesQuotes_id")->default(1)->constrained("states_quotes");//estados

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
