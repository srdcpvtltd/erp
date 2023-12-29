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
        Schema::create('farmer_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farming_id')->nullable();
            $table->foreign('farming_id')->references('id')->on('farmings')->onDelete('cascade');  
            $table->foreignId('loan_category_id')->nullable();
            $table->foreign('loan_category_id')->references('id')->on('product_service_categories')->onDelete('cascade');         
            $table->foreignId('loan_type_id')->nullable();
            $table->foreign('loan_type_id')->references('id')->on('product_services')->onDelete('cascade');         
            $table->string('registration_number')->nullable();
            $table->string('agreement_number')->nullable();
            $table->double('price_kg')->default(0)->nullable();
            $table->double('quantity')->default(0)->nullable();
            $table->double('total_amount')->default(0)->nullable();
            $table->date('date')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_loans');
    }
};
