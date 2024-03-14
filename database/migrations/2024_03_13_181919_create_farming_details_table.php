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
        Schema::create('farming_details', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('plot_number')->nullable();
            $table->string('kata_number')->nullable();
            $table->string('area_in_acar')->nullable();
            $table->string('quantity')->nullable();
            $table->string('tentative_harvest_quantity')->nullable();
            $table->date('date_of_harvesting')->nullable();
            $table->foreignId('seed_category_id')->nullable();
            $table->foreign('seed_category_id')->references('id')->on('seed_categories')->onDelete('cascade');
            $table->foreignId('farming_id')->nullable();
            $table->foreign('farming_id')->references('id')->on('farmings')->onDelete('cascade');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farming_details');
    }
};
