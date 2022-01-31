<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiroTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giro_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('giro_number');
            $table->string('customer_name')->nullable();
            $table->date('giro_date')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->integer('id_period');
            $table->boolean('is_void')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giro_transaction');
    }
}
