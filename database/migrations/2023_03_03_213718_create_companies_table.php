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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained("users");
            $table->string("name");
            $table->string("email");
            $table->string("nit");
            $table->string("phone");
            $table->string("address");
            $table->string("description")->nullable();
            $table->string("nameLegalRepresentative");
            $table->string("phoneLegalRepresentative");
            $table->string("startDate");
            $table->string("endDate");
            $table->boolean("state")->default(1);
            $table->string("headerReport")->nullable();
            $table->string("footerReport")->nullable();
            $table->string("identification_rep");//cedula legal
            $table->string("address_rep");
            $table->string("email_rep");
            $table->text("logo");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
