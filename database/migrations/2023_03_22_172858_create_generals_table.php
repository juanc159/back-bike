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
        Schema::create('way_to_pay_generals', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->boolean('in_use')->default(true);
            $table->string('code');
            $table->string('name');
            $table->foreignId('related_to_id')->constrained("related_tos");
            $table->foreignId('ledger_account_auxiliary_id')->constrained("ledger_account_auxiliaries");
            $table->foreignId('payment_method_id')->nullable()->constrained("payment_methods");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('way_to_pay_generals');
    }
};
