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
        Schema::table('farming_payments', function (Blueprint $table) {
            $table->string('type')->default('Security Deposit')->nullable()->after('amount');
            $table->string('bank')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farming_payments', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('bank');
        });
    }
};
