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
        Schema::create('income_vehicles', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_init');
            $table->foreignId('company_id')->constrained('companies'); 
            $table->foreignId('mecanic_id')->constrained('mecanics');
            $table->enum('type_vehicle', ['Moto', 'Carro']);
            $table->string('brand');
            $table->enum('pay_labor', ['Si', 'No']);
            $table->string('plate');
            $table->integer('value_labor');
            $table->integer('value_parts');
            $table->integer('total_costs');
            $table->integer('value_labor40');
            $table->integer('paid_labor')->nullable();
            $table->timestamp('date_pay_labor')->nullable();
            $table->integer('utilites');
            $table->string('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_vehicles');
    }
};
