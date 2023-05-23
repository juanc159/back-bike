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
        Schema::create('types_credit_note_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId("typesCreditNotes_id")->constrained("types_credit_notes");
            $table->string("name");
            $table->string("path");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types_credit_note_files');
    }
};
