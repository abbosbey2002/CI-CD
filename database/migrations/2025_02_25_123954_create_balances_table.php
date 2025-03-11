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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->string('contragent'); // Контрагент
            $table->decimal('outcome', 15, 2)->default(0); // сумма дебит
            $table->decimal('income', 15, 2)->default(0); // сумма кредит
            $table->decimal('bonus', 15, 2)->default(0); // бонус
            $table->string('phone')->nukable();
            $table->timestamp('last_update')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
