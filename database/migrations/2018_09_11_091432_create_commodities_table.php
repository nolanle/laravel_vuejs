<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('code')->nullable();

            $table->unsignedBigInteger('mortgage_amount')->default(0);
            $table->boolean('interest_before_mortgage')->default(FALSE);

            $table->unsignedBigInteger('interest_by_date')->default(0);
            // $table->unsignedBigInteger('total_interest')->default(0);

            $table->unsignedInteger('interest_period')->default(0);
            $table->unsignedInteger('days_of_delayed')->default(0);

            $table->json('attrs')->nullable();
            $table->boolean('activated')->default(FALSE);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commodities');
    }
}
