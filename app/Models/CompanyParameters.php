<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyParameters extends Model
{
    use HasFactory;
    protected $fillable=['Name','Branch','Address','Telephone','Email','ContactPerson','PinNumber'];
}
