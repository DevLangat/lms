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
           
        ]);
    }
}
