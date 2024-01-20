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
        Schema::table('farmings', function (Blueprint $table) {
            $table->string('father_name')->nullable();
            $table->foreignId('zone_id')->nullable();
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
            $table->foreignId('center_id')->nullable();
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
            $table->string('g_code')->nullable();
            $table->foreignId('seed_category_id')->nullable();
            $table->foreign('seed_category_id')->references('id')->on('seed_categories')->onDelete('cascade');
            $table->string('finance_category')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank')->nullable();
            $table->string('branch')->nullable();
            $table->string('ifsc_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmings', function (Blueprint $table) {
            $table->dropColumn('father_name');
            $table->dropColumn('zone_id');
            $table->dropColumn('center_id');
            $table->dropColumn('g_code');
            $table->dropColumn('seed_category_id');
            $table->dropColumn('finance_category');
            $table->dropColumn('account_number');
            $table->dropColumn('bank');
            $table->dropColumn('branch');
            $table->dropColumn('ifsc_code');
        });
    }
};
