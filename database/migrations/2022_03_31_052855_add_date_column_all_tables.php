<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateColumnAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->date('selected_date')->nullable();
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->date('selected_date')->nullable();
        });
//        Schema::table('receipts', function (Blueprint $table) {
//            $table->date('selected_date')->nullable();
//        });
//        Schema::table('receipts', function (Blueprint $table) {
//            $table->date('selected_date')->nullable();
//        });
//        Schema::table('receipts', function (Blueprint $table) {
//            $table->date('selected_date')->nullable();
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
