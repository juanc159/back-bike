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
        Schema::create('payroll_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_id")->constrained("employees");
            $table->foreignId("payroll_id")->constrained("payrolls");
            $table->string('workedDays');
            $table->string('wage');
            $table->string('amount_transport_assistance');
            $table->string('extra_hours');
            $table->string('bonuses');
            $table->string('commissions');
            $table->string('total_accrued');
            $table->string('deduction_health');
            $table->string('deduction_pension');
            $table->string('other_discounts');
            $table->string('total_deductibles');
            $table->string('total_paid');
            $table->string('employer_pension');
            $table->string('employer_compensation_box');
            $table->string('employer_arl');
            $table->string('total_form_pension');
            $table->string('total_form_health');
            $table->string('total_form_arl');
            $table->string('total_form_compensation_box');
            $table->string('layoffs');
            $table->string('severance_interest');
            $table->string('wage_premium');
            $table->string('vacation');
            $table->string('total_provisions');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_employees');
    }
};
