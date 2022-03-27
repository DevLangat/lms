<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_interests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Loanno');
            $table->string('MemberNo');
            $table->string('ApprovedAmount');
            $table->string('InterestAmount');
            $table->string('ApprovedBy');
            $table->string('InterestAcc')->nullable();
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
        Schema::dropIfExists('loan_interests');
    }
}
