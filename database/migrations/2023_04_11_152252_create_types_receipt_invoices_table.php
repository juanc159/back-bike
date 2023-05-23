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
        Schema::create('types_receipt_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");//Compañia
            $table->boolean('inUse');//en uso
            //Datos principales del comprobante
            $table->string('voucherCode');
            $table->string('voucherName');
            //Resolución de facturación
            $table->boolean('useAsElectronicDocument')->nullable();
            $table->string('resolutionNumberDian');
            $table->date('effectiveDate');
            $table->foreignId("validityInMonths_id")->constrained("validity_in_months");
            $table->date('endDateValidity');
            //Numeración
            $table->string('prefix');
            $table->string('initialNumbering');
            $table->string('finalNumbering');
            $table->string('nextInvoiceNumber');
            $table->boolean('automaticNumbering')->nullable();
            //Datos adicionales para facturación electronica
            $table->boolean('deliveryOrder')->nullable();
            $table->boolean('purchaseOrder')->nullable();
            //configuracion complem..
            $table->boolean('includeDecimals')->nullable();
            $table->boolean('activateVendorsByItem')->nullable();
            $table->boolean('enableCrossRemittances')->nullable();
            $table->foreignId("discountTypePerItem_id")->constrained("discount_per_items");
            //Cuentas contables
            $table->unsignedBigInteger("LedgerAccountsDiscount_id");
            $table->string("LedgerAccountsDiscount_table");
            $table->unsignedBigInteger("LedgerAccountsGift_id");
            $table->string("LedgerAccountsGift_table");
            //Retenciones
            $table->boolean('reteIva')->nullable();
            $table->boolean('reteIca')->nullable();
            $table->boolean('selfRetaining')->nullable();
            //Configuraciones de otras actividades economicas
            $table->boolean('invoicingIncomeForThirdParties');
            $table->boolean('copaysAdvances')->nullable();
            //Formato
            $table->foreignId("format_id")->constrained("format_display_print_invoices");
            $table->string('titleForDisplay');
            $table->foreignId("departament_id")->constrained("departaments");
            $table->foreignId("city_id")->constrained("cities");
            $table->string('address');
            $table->longText('observations');
            $table->string('affair');//asunto
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
        Schema::dropIfExists('types_receipt_invoices');
    }
};
