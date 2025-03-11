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
        Schema::create('ticket_history_statuses', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->enum('old_status', ['new', 'in_progress', 'closed', 'resolved'])->default('new');
            $table->enum('new__status', ['new', 'in_progress', 'closed', 'resolved'])->default('new');
            $table->foreignId('updated_by_id')->constrained('new_users')->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_history_statuses');
    }
};
