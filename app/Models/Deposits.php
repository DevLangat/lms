<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposits extends Model
{
    use HasFactory;
    protected $fillables=['MemberNo','Amount','TransBy','ReceiptNo','Remarks','sharescode','TransactionDate'];
}
