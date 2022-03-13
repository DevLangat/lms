<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_parameters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Name');
            $table->string('Branch');
            $table->string('Address');
            $table->string('Email');
            $table->string('Telephone');
            $table->string('ContactPerson');
            $table->string('PinNumber');
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
        Schema::dropIfExists('company_parameters');
    }
}
