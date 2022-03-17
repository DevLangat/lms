<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    use HasFactory;
    protected $fillable = [
        'LoanCode', 'LoanType', 'LoanAcc', 'InterestAcc', 'LTSRatio','SharesCode', 'MaxAmount', 'AuditID', 'ContraAcc', 'Repaymethod', 'PremiumAcc', 'PremiumContraAcc', 'GPeriod'
    ];
}
