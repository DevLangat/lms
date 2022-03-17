<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('SharesCode');
            $table->string('SharesName');
            $table->string('SharesAcc');
            $table->string('InterestAcc');
            $table->integer('LoanToShareRatio');
            $table->boolean('UsedToGuarantee')->default(1);
            $table->boolean('Withdrawable');
            $table->float('MinAmount')->nullable();
            $table->float('LowerLimit')->nullable();
            $table->float('IntRate');
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
        Schema::dropIfExists('deposit_types');
    }
}
