<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('MemberNo')->unique();
            $table->string('Name');
            $table->string('Address');
            $table->string('Email')->nullable();
            $table->string('Mobile');
            $table->string('GroupCode');
            $table->string('KinName');
            $table->string('KinMobile');  
            $table->string('MaxLoan')->default('0');  
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
        Schema::dropIfExists('members');
    }
}
