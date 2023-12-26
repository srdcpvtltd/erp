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
        Schema::create('farming_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farming_id')->nullable();
            $table->foreign('farming_id')->references('id')->on('farmings')->onDelete('cascade');
            $table->string('registration_number')->nullable();
            $table->string('agreement_number')->nullable();
            $table->date('date')->nullable();
            $table->double('amount')->default(0);
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farming_payments');
    }
};
