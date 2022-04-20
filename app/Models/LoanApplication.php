<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;
    protected $fillable=['MemberNo','Loanno','Loantype','Loancode','AmountApplied','ApplicationDate','EffectDate'
    ,'RecoverInterestFirst','IntRate','Rperiod','Createdby','Approved','ApprovedAmount','RepayAmount','IsDisbursed'
    ,'ApprovedBy','Modifiedby','ApprovedOn','ModifiedOn'];

    public static function checkDefaults()
    { 
        $showpendingloans = LoanApplication::select(
            "loan_applications.*",             
            "repayments.name as Names"
        )
        ->leftJoin("repayments", "repayments.loanno", "=", "loan_applications.loanno")
        ->where ('datediff'('loan_applications.effectivedate','repayments.TransactionDate'),'>','1')
        ->get();
  }

    
}
