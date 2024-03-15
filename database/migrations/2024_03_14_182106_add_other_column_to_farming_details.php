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
        Schema::table('farming_details', function (Blueprint $table) {
            $table->string('type')->nullable()->after('created_by');
            $table->foreignId('block_id')->nullable()->after('created_by');
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->foreignId('gram_panchyat_id')->nullable()->after('created_by');
            $table->foreign('gram_panchyat_id')->references('id')->on('gram_panchyats')->onDelete('cascade');
            $table->foreignId('village_id')->nullable()->after('created_by');
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade');
            $table->foreignId('zone_id')->nullable()->after('created_by');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
            $table->foreignId('center_id')->nullable()->after('created_by');
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farming_details', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('block_id');
            $table->dropColumn('gram_panchyat_id');
            $table->dropColumn('village_id');
            $table->dropColumn('zone_id');
            $table->dropColumn('center_id');
        });
    }
};
