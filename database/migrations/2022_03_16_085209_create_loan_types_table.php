<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_types', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('LoanCode');
            $table->string('LoanType');
            $table->string('LoanAcc');
            $table->string('InterestAcc');
            $table->string('SharesCode');
            $table->float('LTSRatio');
            $table->float('MaxAmount');
            $table->string('AuditID');
            $table->string('ContraAcc');
            $table->string('Repaymethod');
            $table->string('PremiumAcc');
            $table->string('PremiumContraAcc');
            $table->string('GPeriod');            
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
        Schema::dropIfExists('loan_types');
    }
}
