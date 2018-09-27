<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sums', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('beginning_balance')->default(0);
            $table->unsignedBigInteger('ending_balance')->default(0);
            $table->unsignedBigInteger('total_revenue')->default(0);
            $table->unsignedBigInteger('total_cost')->default(0);

            $table->date('arising_date');
            $table->unsignedInteger('company_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sums', function(Blueprint $table) {
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('sums');
    }
}
