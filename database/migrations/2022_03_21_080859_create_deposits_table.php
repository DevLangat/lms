<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('MemberNo');
            $table->string('TransBy');
            $table->string('ReceiptNo');
            $table->string('mpesacode');
            $table->string('Remarks');
            $table->string('sharescode');
            $table->dateTime('TransactionDate');
            $table->float('Amount')->nullable();            
            $table->float('sharevalue')->nullable();
            $table->timestamps();
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}
