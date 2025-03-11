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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Дата
            $table->string('document')->nullable(); // Документ
            $table->string('contragent')->nullabele(); // Контрагент
            $table->string('phone')->nullable();
            $table->string('contragent_tin')->nullable();
            $table->decimal('outcome', 15, 2)->default(0);
            $table->decimal('income', 15, 2)->default(0);
            $table->timestamp('last_update')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
