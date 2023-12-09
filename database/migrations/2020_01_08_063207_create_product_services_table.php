<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('sku');
            $table->decimal('sale_price', 16, 2)->default('0.0');
            $table->decimal('purchase_price', 16, 2)->default('0.0');
            $table->float('quantity')->default('0.0');
            $table->string('tax_id','50')->nullable();
            $table->integer('category_id')->default('0');
            $table->integer('unit_id')->default('0');
            $table->string('type');
            $table->integer('sale_chartaccount_id')->default('0');
            $table->integer('expense_chartaccount_id')->default('0');
            $table->text('description')->nullable();
            $table->string('pro_image')->nullable();
            $table->integer('created_by')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_services');
    }
}
