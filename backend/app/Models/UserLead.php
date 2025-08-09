<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLead extends Model
{
     protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'message'
    ];
}
