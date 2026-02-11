<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable(); // new column
            $table->timestamps();
        });

        // Insert default trades
        DB::table('trades')->insert([
            [
                'name' => 'Plumbing', 
                'description' => 'All plumbing services including repair and installation',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Electrical', 
                'description' => 'Electrical installations, repair, and maintenance',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Carpentry', 
                'description' => 'Woodwork, furniture, and building structures',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Air-conditioning Maintenance', 
                'description' => 'AC repair and maintenance services',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Painting', 
                'description' => 'Interior and exterior painting services',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Roofing', 
                'description' => 'Roof repair and installation services',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Masonry', 
                'description' => 'Bricklaying, stonework, and concrete structures',
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
