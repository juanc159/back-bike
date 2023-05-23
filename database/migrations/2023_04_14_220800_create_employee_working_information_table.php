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
        Schema::create('employee_working_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId("typeContract_id")->constrained("type_contracts");
            $table->foreignId("company_id")->constrained("companies");
            $table->date('contractStartDate');
            $table->date('contractFinalDate');
            $table->string('salary');
            $table->string('comprehensive_salary')->nullable();
            $table->string('contract_number');
            $table->string('payroll_group');
            $table->foreignId("charge_id")->constrained("charge_catalogs");
            $table->foreignId("typeContributor_id")->constrained("contributing_types");
            $table->foreignId("subTypeContributor_id")->constrained("contributing_sub_types");
            $table->foreignId("health_background_id")->constrained("health_backgrounds");
            $table->string('health_fund_percentage');
            $table->foreignId("pension_fund_id")->constrained("pension_funds");
            $table->string('pension_fund_percentage');
            $table->foreignId("arl_id")->constrained("arls");
            $table->foreignId("risk_class_id")->constrained("risk_classes");
            $table->string('code_ciiu')->nullable();
            $table->string("code_id")->nullable();            
            $table->foreignId("compensation_box_id")->constrained("compensation_boxes");
            $table->foreignId("severance_fund_id")->nullable()->constrained("pension_funds");
            $table->string('withholding_deductions')->nullable();
            $table->foreignId("reasonRetirement_id")->nullable()->constrained("reason_retirements");
            $table->foreignId("employee_id")->constrained("employees");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_working_information');
    }
};
