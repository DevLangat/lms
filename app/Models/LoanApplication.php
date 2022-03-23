<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;
    protected $fillable=['IDNo','Loanno','Loantype','Loancode','AmountApplied','ApplicationDate','EffectDate'
    ,'RecoverInterestFirst','IntRate','Rperiod','Createdby','Approved','ApprovedAmount','RepayAmount','IsDisbursed'
    ,'ApprovedBy','Modifiedby','ApprovedOn','ModifiedOn'];

      
}
// IDNo	Loanno	Loancode	AmountApplied	ApplicationDate	EffectDate	RecoverInterestFirst	IntRate	Rperiod	Createdby	Approved	ApprovedAmount	RepayAmount	IsDisbursed	ApprovedBy	Modifiedby	ApprovedOn	ModifiedOn	created_at	updated_at