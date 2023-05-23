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
        Schema::create('charge_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("ledger_account_group_id")->constrained("ledger_account_groups");
            $table->foreignId("company_id")->constrained("companies");//Compañia
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charge_catalogs');
    }
};
