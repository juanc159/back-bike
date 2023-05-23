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
        Schema::create('ledger_account_subauxiliaries', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->string("name"); 
            $table->foreignId("ledgerAccountClass_id")->constrained("ledger_account_classes"); 
            $table->foreignId("ledgerAccountGroup_id")->constrained("ledger_account_groups"); 
            $table->foreignId("ledgerAccountAccount_id")->constrained("ledger_account_accounts"); 
            $table->foreignId("ledgerAccountSubAccount_id")->constrained("ledger_account_sub_accounts"); 
            $table->foreignId("ledgerAccountAuxiliarie_id")->constrained("ledger_account_auxiliaries"); 
            $table->foreignId("company_id")->nullable()->constrained("companies");
            $table->foreignId("ledgerAccountCategory_id")->nullable()->constrained("ledger_account_categories"); 
            $table->foreignId("ledgerAccountBalance_id")->nullable()->constrained("ledger_account_balances");
            $table->boolean('tax_difference_account')->nullable(); 
            $table->boolean('active')->nullable(); 
            $table->string('relatedTo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_account_subauxiliaries');
    }
};
