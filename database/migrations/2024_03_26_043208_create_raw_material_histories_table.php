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
        Schema::create('raw_material_histories', function (Blueprint $table) {
            $table->id();
            //date, raw_material_id, qty, balance

            $table->date('date');
            $table->foreignId('raw_material_id')->constrained('raw_materials');
            $table->integer('in');
            $table->integer('out');
            $table->string('description');
            $table->integer('balance');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_histories');
    }
};
