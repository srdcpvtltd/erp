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
            $table->text('police_station')->nullable()->after('gender');
            $table->text('post_office')->nullable()->after('gender');
            $table->text('registration_no')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmings', function (Blueprint $table) {
            $table->dropColumn('police_station');
            $table->dropColumn('post_office');
            $table->dropColumn('registration_no');
        });
    }
};
