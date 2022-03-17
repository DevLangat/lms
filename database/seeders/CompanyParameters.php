<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanyParameters extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_parameters')->insert([
            'Name' => 'Loan Management System',
            'SharesName' => 'Deposits',
            'SharesAcc' => '673-054',
            'InterestAcc' => '',
            'LoanToShareRatio' => 3,
            'UsedToGuarantee' => True,
            'Withdrawable' => True,
            'MinAmount' => 0,
            'LowerLimit' =>0,
            'IntRate' => 0,
            'sharevalue' => 0,
        ]);
    }
}
