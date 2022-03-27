<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class LoanTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loan_types')->insert([
            'LoanCode'=>'L01',
            'LoanType' => 'Biashara Loan',
            'Ratio' => '15',
            'LoanAcc' => '673-054',
            'InterestAcc' => '673-055',
            'SharesCode' => 3,
            'LTSRatio' => 0,
            'MaxAmount' => 2000,
            'AuditID' => '',
            'ContraAcc' =>'',
            'Repaymethod' => 'STL',
            'PremiumAcc' => '0',
            'PremiumContraAcc' => 0,
            'GPeriod' => 2,
        ]);
    }
}
; 