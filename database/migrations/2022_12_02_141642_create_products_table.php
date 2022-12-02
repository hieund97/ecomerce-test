<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 7)->unique();
            $table->string('name');
            $table->text('slug')->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('is_new')->comment('0: not new, 1: new');
            $table->integer('is_sale')->comment('0: not sale, 1: sale');
            $table->integer('highlight')->comment('0: not highlight, 1: highlight');
            $table->integer('status')->default(1)->comment('0: off, 1: on');
            $table->integer('quantity')->unsigned()->default(0);
            $table->text('description');
            $table->text('details');
            $table->string('related_product_id')->nullable();
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
        Schema::dropIfExists('products');
    }
}
