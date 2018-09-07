<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function(Blueprint $table) {
            $table->string('id', 5);
            $table->string('name', 100);
            $table->string('type', 30);
            $table->primary('id');
        });
        Schema::create('districts', function(Blueprint $table) {
            $table->string('id', 5);
            $table->string('name', 100);
            $table->string('type', 30);
            $table->string('province_id', 5);
            $table->primary('id');
            $table->foreign('province_id')->references('id')->on('provinces');
        });
        Schema::create('wards', function(Blueprint $table) {
            $table->string('id', 5);
            $table->string('name', 100);
            $table->string('type', 30);
            $table->string('district_id', 5);
            $table->primary('id');
            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wards', function(Blueprint $table) {
            $table->dropForeign(['district_id']);
        });
        Schema::table('districts', function(Blueprint $table) {
            $table->dropForeign(['province_id']);
        });
        Schema::dropIfExists('wards');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('provinces');
    }
}
