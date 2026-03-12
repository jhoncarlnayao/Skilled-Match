<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            // Who filed it
            $table->foreignId('client_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('worker_id')
                  ->nullable()
                  ->constrained('workers')
                  ->nullOnDelete();

            // Full name of the person being reported (typed text fallback)
            $table->string('fullname')->nullable();

            // Direction: 'client' filed against a worker, 'worker' filed against a client
            $table->enum('filed_by', ['client', 'worker'])->default('client');

            // Complaint details
            $table->string('reason');
            $table->string('subject', 120);
            $table->text('description');

            // Optional screenshot (client-filed only)
            $table->string('screenshot')->nullable();

            // Admin
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'dismissed'])
                  ->default('pending');

            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};