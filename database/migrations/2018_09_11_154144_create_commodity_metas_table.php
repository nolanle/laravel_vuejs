<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommodityMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodity_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('commodity_id');

            $table->string('key');
            $table->string('value');

            $table->foreign('commodity_id')->references('id')->on('commodities')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commodity_metas');
    }
}
