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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('supervisor')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['new', 'in_progress', 'closed', 'resolved'])->default('new');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->boolval('is_marked');
            $table->integer('un_read_ount');
            $table->date('last_tickets');
            $table->unsignedBigInteger('assigned_to')->nullable(); // Admin/Dealer assigned to the ticket
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('new_users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('new_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
