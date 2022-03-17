<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositTypes extends Model
{
    use HasFactory;
    protected $fillable=['SharesCode','SharesName','SharesAcc','InterestAcc','UsedToGuarantee','Withdrawable','MinAmount','LowerLimit','IntRate','sharevalue'];
}
