<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('commodity_id');
            $table->unsignedInteger('company_id');

            $table->string('commodity_name')->nullable();
            $table->unsignedBigInteger('pawn_amount')->default(0);
            $table->boolean('interest_before_pawn')->default(FALSE);
            $table->unsignedBigInteger('interest_by_date')->default(0);
            $table->unsignedInteger('interest_period')->default(0);
            $table->unsignedInteger('days_of_delayed')->default(0);

            $table->date('paid_date')->nullable();
            $table->date('renew_date')->nullable();
            $table->date('liquidate_date')->nullable();
            $table->json('attrs')->nullable();
            $table->json('histories')->nullable();

            $table->date('pawn_date')->nullable();
            $table->longText('pawn_note')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('commodity_id')->references('id')->on('commodities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['commodity_id']);
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('contracts');
    }
}
