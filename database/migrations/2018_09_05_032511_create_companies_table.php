<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('district_id', 5);
            $table->string('address');
            $table->string('address_addition')->nullable(); // địa chỉ dòng 2
            $table->string('represent'); // ngươi đại diện
            //$table->unsignedBigInteger('interested')->default(0);
            //$table->unsignedBigInteger('total_investment')->default(0);

            $table->boolean('activated')->default(TRUE);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('districts');
        });

        Schema::table('users', function (Blueprint $table) {
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
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign(['company_id']);
        });

        Schema::dropIfExists('companies');
    }
}
