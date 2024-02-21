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
            $table->string('loan_account_number')->nullable()->after('amount');
            $table->string('ifsc')->nullable()->after('amount');
            $table->string('branch')->nullable()->after('bank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farming_payments', function (Blueprint $table) {
            $table->dropColumn('loan_account_number');
            $table->dropColumn('ifsc');
            $table->dropColumn('branch');
        });
    }
};
