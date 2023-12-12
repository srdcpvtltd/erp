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
        Schema::create('farmings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('qualification')->nullable();
            $table->string('land_holding')->nullable();
            $table->string('language')->nullable();
            $table->string('sms_mode')->nullable();
            $table->integer('created_by')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreignId('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreignId('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreignId('block_id')->nullable();
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->foreignId('gram_panchyat_id')->nullable();
            $table->foreign('gram_panchyat_id')->references('id')->on('gram_panchyats')->onDelete('cascade');
            $table->foreignId('village_id')->nullable();
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmings');
    }
};
