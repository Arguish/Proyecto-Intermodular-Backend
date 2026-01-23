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
        Schema::create('material_loans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('material_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('loan_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->text('observations')->nullable();
            $table->string('status')->default('prestado');
            // prestado | devuelto | atrasado

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_loans');
    }
};
