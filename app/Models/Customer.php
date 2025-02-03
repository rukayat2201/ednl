<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'firstname',
        'lastname',
        'bvn',
        'telephone',
        'dob',
        'residential_address',
        'state',
        'bank_code',
        'accountnumber',
        'company_id',
        'email',
        'city',
        'country',
        'id_card',
        'voters_card',
        'drivers_license',
    ];
}
