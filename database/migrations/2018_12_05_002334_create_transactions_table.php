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
            $table->integer('from_user')->unsigned();
            $table->integer('to_user')->unsigned();
            $table->float('amount');
            $table->string('note')->nullable();
            $table->dateTime('created_at')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->softDeletesTz();

            // Foreign keys
            $table->foreign('from_user')->references('id')->on('users');
            $table->foreign('to_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
