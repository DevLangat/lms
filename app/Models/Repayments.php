<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayments extends Model
{
    use HasFactory;
    protected $fillable=['Active','MemberNo','Loanno','amount','Principal','Interest','ReceiptNo','MobileNo','payment_status','TransactionDate','AuditTime','Balance'];
    
}
