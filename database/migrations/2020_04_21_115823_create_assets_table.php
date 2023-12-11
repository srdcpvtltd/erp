<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'assets', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->text('employee_id')->nullable();
            $table->string('name');
            $table->date('purchase_date');
            $table->date('supported_date');
            $table->decimal('amount',15,2)->default(0.00);
            $table->text('description')->nullable();
            $table->integer('created_by')->default(0);
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
