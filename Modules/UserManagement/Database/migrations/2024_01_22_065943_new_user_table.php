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

        Schema::create('new_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('login')->unique()->nullable(); // Only required for admin/dealer
            $table->string('password')->nullable(); // Only required for admin/dealer
            $table->string('phone')->unique()->nullable();
            $table->string('tg_id')->nullable(); // Only for bot users
            $table->string('company_tin')->nullable(); // Only for users
            $table->string('company_integration_id')->nullable(); // Only for users
            $table->enum('role', ['admin', 'dealer', 'user']);
            // $table->unsignedBigInteger('dealer_id')->nullable(); // FK for users linking to their dealer
            // $table->foreign('dealer_id')->references('id')->on('new_users')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
