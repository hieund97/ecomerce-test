<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_value', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('related_id');
            $table->integer('image_type')->default(1);
            $table->integer('is_primary')->default(0)->comment('0:not primary, 1:primary');
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
        Schema::dropIfExists('image_value');
    }
}
