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

            // The client (users.id) who filed the complaint
            $table->foreignId('client_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // The job the complaint is about
            // $table->foreignId('job_id')
            //       ->nullable()
            //       ->constrained('jobs')
            //       ->nullOnDelete();

            // // The worker (workers.id) being reported
            // $table->foreignId('worker_id')
            //       ->nullable()
            //       ->constrained('workers')
            //       ->nullOnDelete();

            // Typed/auto-filled worker name for quick reference
            $table->string('worker_name')->nullable();

            // Complaint fields
            $table->string('reason');       // no_show|incomplete_work|unprofessional|overcharging|damage|other
            $table->string('subject', 120);
            $table->text('description');

            // Optional screenshot — stored path e.g. complaints/abc123.jpg
            $table->string('screenshot')->nullable();

            // Admin-managed status
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'dismissed'])
                  ->default('pending');

            // Admin notes when reviewing / resolving
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            // No unique constraint needed since job_id is now optional
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};