<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('Active')->default(true);
            $table->string('MemberNo');    
            $table->string('Loanno');           
            $table->double('amount');
            $table->double('Principal');
            $table->double('Interest');
            $table->double('Balance');
            $table->string('ReceiptNo'); 
            $table->string('MobileNo'); 
            $table->integer('payment_status');
            $table->dateTime('TransactionDate');
            $table->timestamp('due_date')->nullable();//add a month to TransactionDate
            $table->timestamp('AuditTime')->nullable();
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('repayments');
    }
}
