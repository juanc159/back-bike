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
        Schema::create('ledger_account_groups', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->string("name"); 
            $table->foreignId("ledgerAccountClass_id")->constrained("ledger_account_classes"); 
            $table->foreignId("company_id")->nullable()->constrained("companies"); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_account_groups');
    }
};
