<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');

//          $table->foreign('user_id')->references('id')->on('users'); // old version syntax
            $table->foreignId('user_id')->nullable()->constrained('users'); // new version syntax (https://laravel.com/docs/7.x/migrations#foreign-key-constraints)
            $table->date('birthday')->nullable();

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('address_postcode')->nullable();
            $table->string('address_roadAddress')->nullable();
            $table->string('address_jibunAddress')->nullable();
            $table->string('address_detail')->nullable();
            $table->string('address_extraAddress')->nullable();


            $table->text('note')->nullable();
            $table->timestamp('last_purchase')->nullable();
            $table->unsignedInteger('total_purchases')->default(0);
            $table->unsignedDecimal('total_paid')->default(0.00);
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
        Schema::dropIfExists('clients');
    }
}
