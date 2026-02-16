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
    Schema::create('jobs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
        $table->string('title');
        $table->text('description');
         $table->foreignId('trade_id')
              ->constrained('trades')
              ->onDelete('cascade');
        $table->decimal('budget', 10, 2)->nullable();
        $table->string('location');
        $table->enum('status', ['open', 'assigned', 'completed'])->default('open');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
