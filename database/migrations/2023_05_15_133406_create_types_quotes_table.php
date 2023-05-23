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
        Schema::create('types_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");//Compañia
            $table->boolean('inUse');//en uso
            //Datos principales del comprobante
            $table->string('voucherCode');
            $table->string('voucherName');
            //Numeración 
            $table->string('initialNumbering'); 
            $table->string('proxNumberQuote'); 
            $table->boolean('automaticNumbering')->nullable(); 
            //configuracion complem..
            $table->boolean('includeDecimals')->nullable(); 
            $table->foreignId("discountTypePerItem_id")->constrained("discount_per_items");
            //Formato
            $table->foreignId("format_id")->constrained("format_display_print_invoices");
            $table->string('titleForDisplay');
            $table->string('header');
            $table->string('conditionsObservations');
            //Datos para envío por mail
            $table->string('subjectMail');
            $table->longText('contentMail');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types_quotes');
    }
};
