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
            $table->string('land_type')->nullable()->after('ifsc_code');
            $table->string('offered_area')->nullable()->after('ifsc_code');
            $table->boolean('is_irregation')->default(0)->nullable()->after('ifsc_code');
            $table->string('irregation')->nullable()->after('ifsc_code');
            $table->string('non_loan_type')->nullable()->after('ifsc_code');
            $table->string('account_no_ifsc')->nullable()->after('ifsc_code');
            $table->string('name_of_cooperative')->nullable()->after('ifsc_code');
            $table->string('cooperative_address')->nullable()->after('ifsc_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmings', function (Blueprint $table) {
            $table->dropColumn('land_type');
            $table->dropColumn('offered_area');
            $table->dropColumn('is_irregation');
            $table->dropColumn('irregation');
            $table->dropColumn('non_loan_type');
            $table->dropColumn('account_no_ifsc');
            $table->dropColumn('name_of_cooperative');
            $table->dropColumn('cooperative_address');
        });
    }
};
