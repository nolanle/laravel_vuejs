<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('type', ['initial', 'pawning', 'paid_fee', 'liquidate', 'refund', 'deposit', 'withdraw', 'other'])->default('initial');
            $table->boolean('addition')->default(TRUE);
            $table->unsignedInteger('contract_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedBigInteger('amount')->default(0);

            $table->longText('description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['contract_id']);
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('transactions');
    }
}
