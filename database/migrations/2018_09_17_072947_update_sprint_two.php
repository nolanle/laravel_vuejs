<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSprintTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('commodities', function (Blueprint $table) {
            $table->json('attrs')->nullable();
        });

        Schema::table('contracts', function (Blueprint $table) {
            //$table->date('paid_date')->after('pawn_date')->nullable();
            //$table->boolean('is_renew')->after('paid_date')->default(FALSE);
            //$table->date('renew_date')->after('is_renew')->nullable();
            //$table->boolean('is_liquidate')->after('renew_date')->default(FALSE);
            //$table->date('liquidate_date')->after('is_liquidate')->nullable();
            $table->json('attrs')->nullable();
            $table->json('histories')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('commodities', function (Blueprint $table) {
            $table->dropColumn('attrs');
        });

        Schema::table('contracts', function (Blueprint $table) {
            //$table->dropColumn('paid_date');
            //$table->dropColumn('is_renew');
            //$table->dropColumn('renew_date');
            //$table->dropColumn('is_liquidate');
            //$table->dropColumn('liquidate_date');
            $table->dropColumn('attrs');
            $table->dropColumn('histories');
        });
    }
}
