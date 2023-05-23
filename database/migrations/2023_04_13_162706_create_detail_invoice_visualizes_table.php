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
        Schema::create('detail_invoice_visualizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("detail_invoice_availables_id")->constrained("detail_invoice_availables");
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
        Schema::dropIfExists('detail_invoice_visualizes');
    }
};
