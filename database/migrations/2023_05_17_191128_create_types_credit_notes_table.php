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
        Schema::create('types_credit_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");//Compañia
            $table->boolean('inUse');//en uso
            //Datos principales del comprobante
            $table->string('voucherCode');
            $table->string('voucherName');
            //Numeración
            $table->string('initialNumbering');
            $table->string('nextInvoiceNumber');
            $table->boolean('automaticNumbering')->nullable();
            //Resolución de facturación
            $table->boolean('useAsElectronicDocument')->nullable();
            //configuracion complem..
            $table->boolean('includeDecimals')->nullable();
            $table->boolean('activateVendorsByItem')->nullable();
            $table->foreignId("discountTypePerItem_id")->constrained("discount_per_items");
            //Cuentas contables
            $table->unsignedBigInteger("LedgerAccountsDiscount_id");
            $table->string("LedgerAccountsDiscount_table");
            //Retenciones
            $table->boolean('reteIva')->nullable();
            $table->boolean('reteIca')->nullable();
            $table->boolean('selfRetaining')->nullable();
            //Configuraciones de otras actividades economicas
            $table->boolean('invoicingIncomeForThirdParties');
            $table->boolean('copaysAdvances')->nullable();
            //Formato
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
        Schema::dropIfExists('types_credit_notes');
    }
};
