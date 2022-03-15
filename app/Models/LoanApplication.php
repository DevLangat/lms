<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;
    protected $fillable=['MemberNo','Loanno','Loantype','AmountApplied','ApplicationDate','EffectDate'
    ,'RecoverInterestFirst','IntRate','Rperiod','Createdby','Approved','ApprovedAmount','RepayAmount','IsDisbursed'
    ,'ApprovedBy','Modifiedby','ApprovedBy','ApprovedOn','ModifiedOn'];

      
}
