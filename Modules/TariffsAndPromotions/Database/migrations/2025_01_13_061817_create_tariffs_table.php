<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->string('description', 250);
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->string('feature_1', 100)->nullable();
            $table->string('feature_2', 100)->nullable();
            $table->string('feature_3', 100)->nullable();
            $table->string('feature_4', 100)->nullable();
            $table->string('feature_5', 100)->nullable();
            $table->string('feature_6', 100)->nullable();
            $table->string('feature_7', 100)->nullable();
            $table->string('feature_8', 100)->nullable();
            $table->string('feature_9', 100)->nullable();
            $table->string('feature_10', 100)->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('created_by')->nullable()->references('id')->on('new_users');
            $table->foreignId('updated_by')->nullable()->references('id')->on('new_users');
            $table->softDeletes();

            // Repeat for up to feature_10
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
