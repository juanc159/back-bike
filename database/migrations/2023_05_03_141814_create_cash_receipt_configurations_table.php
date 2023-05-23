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
        Schema::create('cash_receipt_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->string("code");
            $table->string("title");
            $table->string("description");
            $table->string("printFormat");
            $table->string("manageCostCenters");
            $table->boolean("isRequired")->nullable();
            $table->string("default"); 
            $table->boolean("automaticNumbering")->nullable();
            $table->string("consecutive");
            $table->string("subject");
            $table->unsignedBigInteger("ledgerAccount_id");
            $table->string("table")->nullable();
            $table->boolean("state")->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_receipt_configurations');
    }
};
