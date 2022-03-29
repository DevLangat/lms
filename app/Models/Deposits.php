<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deposits extends Model
{
    use HasFactory;
    protected $fillable=['MemberNo','Amount','TransBy','ReceiptNo','mpesacode','Remarks','sharescode','TransactionDate'];

    public static function getdepositsRecieptNo()
    {
        $count =  DB::table('deposits')
        ->select(DB::raw('count(*) as count'))        
        ->get();
    if ($count) {
        foreach ($count as $d_count) {
            $newcount = $d_count->count + 1;
           
        }
        $receiptNo="D00".$newcount;

    }
    return $receiptNo;
    }
}
