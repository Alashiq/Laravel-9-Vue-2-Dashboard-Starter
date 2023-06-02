<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
'branch',
'account_number',
'currency_id',
'name_holder',

        'state',
    ];

}
