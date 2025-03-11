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
        Schema::create('contact_branches', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('full_address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('comment')->nullable();
            $table->boolean('use_full_address')->default(false);
            $table->boolean('use_phone_numbers')->default(false);
            $table->string('phone_number_1')->nullable();
            $table->string('phone_number_1_person', 50)->nullable();
            $table->string('phone_number_2')->nullable();
            $table->string('phone_number_2_person', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_branches');
    }
};
