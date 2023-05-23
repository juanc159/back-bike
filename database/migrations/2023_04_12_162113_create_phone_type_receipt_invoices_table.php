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
        Schema::create('phone_type_receipt_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('indicative');
            $table->string('phone');
            $table->string('extension');
            $table->foreignId("company_id")->constrained("companies");//Compañia
            $table->foreignId("type_receipt_invoices_id")->constrained("types_receipt_invoices");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_type_receipt_invoices');
    }
};
