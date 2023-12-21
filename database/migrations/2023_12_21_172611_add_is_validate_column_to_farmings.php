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
            $table->boolean('is_validate')->default(0)->nullable()->after('created_by');
            $table->string('farmer_id')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmings', function (Blueprint $table) {
            $table->dropColumn('is_validate');
            $table->dropColumn('farmer_id');
        });
    }
};
